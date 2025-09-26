<?php
namespace Modules\Booking\Models;

use App\BaseModel;
use Illuminate\Support\Facades\DB;
use Modules\Tour\Models\Tour;

class Payment extends BaseModel
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
        'update_user'
    ];
}
