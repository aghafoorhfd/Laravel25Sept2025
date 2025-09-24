<?php

namespace App;

use Modules\Booking\Models\Booking;
use Illuminate\Database\Eloquent\Model;

class BookingPayment extends Model
{
     protected $table = 'bravo_booking_payments';

    protected $fillable = [
        'booking_id',
        'payment_gateway',
        'amount',
        'currency',
        'converted_amount',
        'converted_currency',
        'exchange_rate',
        'status',
        'logs',
        'create_user',
        'update_user',
    ];

    // Define relation to booking if you want
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
