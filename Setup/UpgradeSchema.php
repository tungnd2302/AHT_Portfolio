<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace AHT\Portfolio\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Upgrade the Catalog module DB scheme
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {   
        if (version_compare($context->getVersion(), '1.0.4', '<')) {
            $setup->getConnection()->changeColumn(
                $setup->getTable('AHT_Images'),
                'id',
                'image_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'length' => 255,
                    'comment' => 'image_id',
                    'identity' => true
                ]
            );

            $setup->getConnection()->modifyColumn(
                $setup->getTable('AHT_Images'),
                'image_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'length' => 255,
                    'comment' => 'image_id',
                    'identity' => true
                ]
            );
        }

        if (version_compare($context->getVersion(), '1.0.5', '<')) {
            $setup->getConnection()->changeColumn(
                $setup->getTable('AHT_Images'),
                'path',
                'path_1',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => false,
                    'default' => '',
                    'comment' => 'Path_image_ 1'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('AHT_Images'),
                'path_2',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 10,
                    'nullable' => false,
                    'default' => '',
                    'comment' => 'Path_image_2'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('AHT_Images'),
                'path_3',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 10,
                    'nullable' => false,
                    'default' => '',
                    'comment' => 'Path_image_3'
                ]
            );

            $setup->getConnection()->addColumn(
                $setup->getTable('AHT_Images'),
                'path_4',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 10,
                    'nullable' => false,
                    'default' => '',
                    'comment' => 'Path_image_4'
                ]
            );
        }
        
        if (version_compare($context->getVersion(), '1.0.6', '<')) {
            $setup->getConnection()->modifyColumn(
                $setup->getTable('AHT_Images'),
                'path_2',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => false,
                    'default' => '',
                    'comment' => 'Path_image_2'
                ]
            );

            $setup->getConnection()->modifyColumn(
                $setup->getTable('AHT_Images'),
                'path_3',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => false,
                    'default' => '',
                    'comment' => 'Path_image_3'
                ]
            );

            $setup->getConnection()->modifyColumn(
                $setup->getTable('AHT_Images'),
                'path_4',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => false,
                    'default' => '',
                    'comment' => 'Path_image_4'
                ]
            );
        }
        $setup->endSetup();
    }

}
