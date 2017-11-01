<?php

namespace Demo\Cart\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UninstallSchema implements UninstallInterface

{

    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $connection = $setup->getConnection();
        $tableName = $setup->getTable('quote_item');

        if ($connection->isTableExists($tableName) == true) {
            $connection->dropColumn($tableName, 'cron_status');
        }
    }
}