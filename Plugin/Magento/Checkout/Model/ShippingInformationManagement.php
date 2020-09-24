<?php
/**
 * Copyright © Custom shipping, Inc. All rights reserved.
 * @package Custome_Shipping
 * @date 2020.09  
 */
namespace Custom\Shipping\Plugin\Magento\Checkout\Model;

use Magento\Framework\Session\SessionManager;
use Magento\Framework\Exception\CouldNotSaveException;

class ShippingInformationManagement
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

    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    ) {
        
        if ($this->_helper->isActive() && ($addressInformation->getShippingMethodCode() == 'customshipping' &&  $addressInformation->getShippingCarrierCode() == 'customshipping') ) {
            $extAttributes = $addressInformation->getExtensionAttributes();
            if (!$extAttributes) {
                return [$cartId, $addressInformation];
            }
            
            $CustomShippingAddressType = $extAttributes->getCustomShippingAddressType();
            
            $quote = $this->quoteRepository->getActive($cartId);
            
            if ($CustomShippingAddressType !='' && $quote->getId()) {
                
                  $quote->setCustomShippingAddressType($CustomShippingAddressType);
                  $quote->save();
                  if ($this->_coreSession->getCustomShippingAddressType()) {
                      $this->_coreSession->unsCustomShippingAddressType();
                      $this->_coreSession->setCustomShippingAddressType($CustomShippingAddressType);
                  } else {
                      $this->_coreSession->setCustomShippingAddressType($CustomShippingAddressType);
                  }
              }else{
                throw new \Magento\Framework\Exception\LocalizedException(__("Please select address type for Custom Shipping Method."));
              }
          
        }
        return [$cartId, $addressInformation];
    }
}
