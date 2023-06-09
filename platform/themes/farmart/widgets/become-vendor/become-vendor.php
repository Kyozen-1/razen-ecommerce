<?php

use Botble\Widget\AbstractWidget;

class BecomeVendorWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * @var string
     */
    protected $widgetDirectory = 'become-vendor';

    /**
     * BecomeVendorWidget constructor.
     */
    public function __construct()
    {
        parent::__construct([
            'name' => __('Become a Vendor?'),
            'description' => __('Display Become a vendor on product detail sidebar'),
        ]);
    }
}
