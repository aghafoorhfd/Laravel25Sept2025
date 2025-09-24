<?php
namespace Modules\Booking\Gateways;

use Illuminate\Http\Request;
use Modules\Booking\Events\BookingCreatedEvent;

class OfflinePaymentGateway extends BaseGateway
{
    public $name = 'Offline Payment';

    public function process(Request $request, $booking)
    {
        // Simple change status to processing
        $booking->markAsProcessing($this);
        $booking->sendNewBookingEmails();

        event(new BookingCreatedEvent($booking));

        return response()->json([
            'url' => $booking->getDetailUrl()
        ]);
    }

    public function getOptionsConfigs()
    {
        return [
            [
                'type'  => 'checkbox',
                'id'    => 'enable',
                'label' => __('Enable Offline Payment?')
            ],
            [
                'type'  => 'input',
                'id'    => 'name',
                'label' => __('Custom Name'),
                'std'   => __("Offline Payment")
            ],
            [
                'type'  => 'upload',
                'id'    => 'logo_id',
                'label' => __('Custom Logo'),
            ],
            [
                'type'  => 'editor',
                'id'    => 'html',
                'label' => __('Custom HTML Description')
            ],
        ];
    }
}
