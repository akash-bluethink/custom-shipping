<?php
/**
 * Copyright © Custom shipping, Inc. All rights reserved.
 * @package Custome_Shipping
 * @date 2020.09  
 */
namespace Custom\Shipping\Helper;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    protected $storeManager;

    /**
     * @param \Magento\Framework\App\Helper\Context   $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ){
        parent::__construct($context);
        $this->storeManager = $storeManager;
    }
	/**
     * Retrieve information from configuration.
     *
     * @param string $field
     *
     * @return void|false|string
     */
    public function isActive()
    {
        $path = 'carriers/customshipping/active';

        return $this->scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()
        );
    } 
}
