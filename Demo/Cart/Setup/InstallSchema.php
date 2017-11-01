<?php
namespace Demo\Cart\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $connection = $setup->getConnection();
        $tableName = $setup->getTable('quote_item');
        
        if ($connection->isTableExists($tableName) == true && $connection->tableColumnExists($tableName,'cron_status') == false){
            $setup->run("ALTER TABLE 'magento'.'" . $tableName . "' ADD COLUMN 'cron_status' TINYINT(1) comment 'deault:null ; 1: cron runn success' AFTER 'base_weee_tax_row_disposition';");
        }

        $setup->endSetup();
    }
}