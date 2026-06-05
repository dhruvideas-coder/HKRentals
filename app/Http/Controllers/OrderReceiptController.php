<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderReceiptController extends Controller
{
    public function show(Order $order)
    {
        $order->load(['items.product', 'payment']);
        return view('pages.order-success', compact('order'));
    }

    public function download(Order $order)
    {
        $order->load(['items.product', 'payment', 'customer']);
        $settings = Setting::first();

        $pdf = Pdf::loadView('pdf.order-receipt', compact('order', 'settings'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Receipt-' . $order->formatted_id . '.pdf');
    }
}
