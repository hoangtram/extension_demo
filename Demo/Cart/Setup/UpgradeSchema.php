<?php
namespace Demo\Cart\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        $connection = $setup;

        $connection->startSetup();
        $connection = $setup->getConnection();

        $tableName = $setup->getTable('quote_item');

        if(version_compare($context->getVersion(), '2.0.1', '<')) {
            if ($connection->isTableExists($tableName) == true && $connection->tableColumnExists($tableName,'cron_status') == false){
                $setup->run("ALTER TABLE " . $tableName . " ADD cron_status tinyint(1) comment 'deault:null ; 1: cron ran sucess' AFTER base_weee_tax_row_disposition;");
            }
        }

        $connection->endSetup();
    }
}