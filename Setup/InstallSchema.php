<?php
/**
 * Copyright © Custom shipping, Inc. All rights reserved.
 * @package Custome_Shipping
 * @date 2020.09  
 */
namespace Custom\Shipping\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        

        $installer->getConnection()->addColumn(
            $installer->getTable('quote'),
            'custom_shipping_address_type',
            [
                'type' => 'text',
                'LENGTH' =>255,
                'nullable' => true,
                'comment' => 'Office address or Home Address',
            ]
        );


        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order'),
            'custom_shipping_address_type',
            [
                'type' => 'text',
                'LENGTH' =>255,
                'nullable' => true,
                'comment' => 'Office address or Home Address',
            ]
        );

        $setup->endSetup();
    }
}
