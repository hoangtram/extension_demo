<?php
namespace Store\PostCode\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        $connection = $setup;

        $connection->startSetup();
        $connection = $setup->getConnection();

        $tableName = $setup->getTable('customer_entity');

        if(version_compare($context->getVersion(), '2.0.1', '<')) {
            if ($connection->isTableExists($tableName) == true && $connection->tableColumnExists($tableName,'postcode') == false){
                $setup->run("ALTER TABLE " . $tableName . " ADD COLUMN postcode text DEFAULT null AFTER lock_expires;");
            }
        }

        $connection->endSetup();
    }
}