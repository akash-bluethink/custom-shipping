<?php
/**
 * Copyright © Custom shipping, Inc. All rights reserved.
 * @package Custome_Shipping
 * @date 2020.09  
 */
namespace Custom\Shipping\Observer\Sales;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Session\SessionManager;

class ModelServiceQuoteSubmitBefore implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var SessionManager
     */
    protected $_coreSession;
    /**
     * @var \Magento\Quote\Model\QuoteRepository
     */
    protected $quoteRepository;

    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * @var Custom\Shipping\Helper\Data
     */
    protected $_helper;


    protected $storeManager;

    /**
     * @param SessionManager                            $coreSession
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Quote\Model\QuoteRepository      $quoteRepository
     */
    public function __construct(
        SessionManager $coreSession,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Quote\Model\QuoteRepository $quoteRepository,
        \Custom\Shipping\Helper\Data $helper
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->_coreSession = $coreSession;
        $this->_objectManager = $objectManager;
        $this->_helper = $helper;
        
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        $storeId = $this->getStoreId();
        $quote = $observer->getEvent()->getQuote();
        if ($this->_helper->isActive() &&  $quote->getShippingAddress()->getShippingMethod() == 'customshipping_customshipping') {

            $order = $observer->getOrder();
            $CustomShippingAddressType = $this->_coreSession->getCustomShippingAddressType();
            if ($CustomShippingAddressType != '') {
                
                $order->setCustomShippingAddressType($CustomShippingAddressType);
                
            } else {
                
                throw new \Magento\Framework\Exception\LocalizedException(__("Please select address type for Custom Shipping Method."));
            }
        }
        return $this;
    }

    public function getStoreId()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->create('\Magento\Store\Model\StoreManagerInterface');
        return $storeManager->getStore()->getId();
    }
}
