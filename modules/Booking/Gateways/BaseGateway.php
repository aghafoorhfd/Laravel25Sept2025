<?php
namespace Modules\Booking\Gateways;

use Illuminate\Http\Request;

abstract class BaseGateway
{
    protected $id;
    public    $name;

    public function __construct($id = false)
    {
        if ($id)
            $this->id = $id;
    }

    public function isAvailable()
    {
        return $this->getOption('enable');
    }

    public function getHtml()
    {

    }

    /**
     * @param Request $request
     * @param \Modules\Booking\Models\Booking $booking
     */
    public function process(Request $request, $booking)
    {

    }

    public function cancelPayment(Request $request)
    {

    }

    public function confirmPayment(Request $request)
    {

    }

    public function getOptionsConfigs()
    {
        return [];
    }

    public function getOptionsConfigsFormatted()
    {

        $options = $this->getOptionsConfigs();
        if (!empty($options)) {
            foreach ($options as &$option) {
                $option['value'] = $this->getOption($option['id'], $option['std'] ?? '');
                $option['id'] = 'g_' . $this->id . '_' . $option['id'];
            }
        }
        return $options;
    }

    public function getOption($key, $default = '')
    {
        // print_r('g_' . $this->id . '_' . $key).PHP_EOL;
        return setting_item('g_' . $this->id . '_' . $key, $default);
    }

    public function getDisplayName()
    {
        return $this->getOption('name', $this->name);
    }

    public function getDisplayHtml()
    {
        return $this->getOption('html', '');
    }

    public function getReturnUrl()
    {
        return url(app_get_locale(false,false,"/").config('booking.booking_route_prefix') . '/confirm/' . $this->id);
    }

    public function getCancelUrl()
    {
        return url(app_get_locale(false,false,"/").config('booking.booking_route_prefix') . '/cancel/' . $this->id);
    }

    public function getDisplayLogo()
    {
        $logo_id = $this->getOption('logo_id');
        return get_file_url($logo_id);
    }
}
