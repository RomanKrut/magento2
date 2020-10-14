<?php
declare (strict_types=1);

namespace Tsg\KickStart\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;
use Tsg\KickStart\Model\Resource\Sales\Bestsellers as BestsellersResourceModel;

class PopulateBestsellersRecords implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public function apply()
    {
        $setup = $this->moduleDataSetup;
        $setup->startSetup();
        $table = $setup->getTable(BestsellersResourceModel::MAIN_TABLE);
        $setup->getConnection()->insert($table, ['id' => 1, 'is_featured' => true]);
        $setup->getConnection()->insert($table, ['id' => 3, 'is_featured' => true]);
        $setup->endSetup();
    }
}
