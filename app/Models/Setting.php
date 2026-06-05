<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    protected $casts = [
        'email_content' => 'array',
    ];

    private static array $emailDefaults = [
        'subject' => 'Your Order is Confirmed — {order_id}',
        'body'    => "Hi {customer_name},\n\nThank you for your order! Attached to this email you'll find your invoice for order {order_id}.\n\nYour total comes to {total}. Our team will contact you 48 hours before your rental start date to confirm the schedule.\n\nIf you have any questions, please don't hesitate to contact us.\n\nKind regards,\n{company}",
    ];

    public function getEmailField(string $key): string
    {
        $content = $this->email_content ?? [];
        return $content[$key] ?? self::$emailDefaults[$key] ?? '';
    }

    public static function emailDefaults(): array
    {
        return self::$emailDefaults;
    }
}
