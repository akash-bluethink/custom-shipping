<?php
/**
 * Copyright © Custom shipping, Inc. All rights reserved.
 * @package Custome_Shipping
 * @date 2020.09  
 */
namespace Custom\Shipping\Block\Order;

use Magento\Sales\Block\Order\Info as SalesInfo;

class Info extends SalesInfo
{
    /**
     * @var string
     */
    protected $_template = 'Custom_Shipping::order/info.phtml';
}