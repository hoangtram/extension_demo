<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Demo\Mywishlist\Setup;
/**
 * Description of InstallSchema
 *
 * @author tram
 */
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();
        
//        create table wishlist_type
        $table  = $installer->getConnection()
            ->newTable($installer->getTable('demo_mywishlist_category'))
            ->addColumn(
                'wishlist_category_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Wishlist category Id'
            )
            ->addColumn(
                'label',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Label'
            )
            ->addColumn(
                'description',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Description'
            )->addColumn(
                'customer_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Customer ID'
            )
            ->addForeignKey(
                $installer->getFkName('wishlist', 'customer_id', 'customer_entity', 'entity_id'),
                'customer_id',
                $installer->getTable('customer_entity'),
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            );
        $installer->getConnection()->createTable($table);
        
//        create table mywishlist type value
        $table1  = $installer->getConnection()
            ->newTable($installer->getTable('demo_mywishlist_category_value'))
            ->addColumn(
                'wishlist_category_value_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Wishlist category Value Id'
            )
            ->addColumn(
                'wishlist_item_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Wishlist Item  ID'
            )
            ->addColumn(
                'wishlist_category_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                'Wishlist category  ID'
            )
            ->addForeignKey(
                $installer->getFkName('demo_mywishlist_category_value', 'wishlist_item_id', 'wishlist_item', 'wishlist_item_id'),
                'wishlist_item_id',
                $installer->getTable('wishlist_item'),
                'wishlist_item_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $installer->getFkName('demo_mywishlist_category_value', 'wishlist_category_id', 'demo_mywishlist_category', 'wishlist_category_id'),
                'wishlist_category_id',
                $installer->getTable('demo_mywishlist_category'),
                'wishlist_category_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            );
        $installer->getConnection()->createTable($table1);
        
        $installer->endSetup();
    }
}

