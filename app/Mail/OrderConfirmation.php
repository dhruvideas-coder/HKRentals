<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public Order   $order;
    public Setting $settings;
    public array   $email;

    public function __construct(Order $order)
    {
        $this->order    = $order;
        $this->settings = Setting::first() ?? new Setting();
        $this->email    = $this->resolveContent();
    }

    /**
     * Resolve each editable email field and replace placeholders with real values.
     */
    private function resolveContent(): array
    {
        $replacements = [
            '{customer_name}' => $this->order->customer_name,
            '{order_id}'      => $this->order->formatted_id,
            '{total}'         => '$' . number_format($this->order->total_amount, 2),
            '{company}'       => config('app.name', 'SK Rentals'),
        ];

        $resolved = [];
        foreach (array_keys(Setting::emailDefaults()) as $key) {
            $resolved[$key] = strtr($this->settings->getEmailField($key), $replacements);
        }

        return $resolved;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->email['subject'] ?: ('Order Confirmed — ' . $this->order->formatted_id),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-confirmation',
            with: [
                'order'    => $this->order,
                'settings' => $this->settings,
                'email'    => $this->email,
            ],
        );
    }

    public function build(): static
    {
        $this->order->loadMissing(['items.product', 'payment', 'customer']);

        $pdf = Pdf::loadView('pdf.order-receipt', [
            'order'    => $this->order,
            'settings' => $this->settings,
        ])->setPaper('A4', 'portrait');

        return $this->attachData(
            $pdf->output(),
            'Receipt-' . $this->order->formatted_id . '.pdf',
            ['mime' => 'application/pdf']
        );
    }
}
