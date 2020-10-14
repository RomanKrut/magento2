<?php
declare (strict_types=1);

namespace Tsg\KickStart\Model\Resource\Sales;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Bestsellers extends AbstractDb
{
    public const MAIN_TABLE = 'tsg_kickstart_sales_bestsellers';
    private const ID_FIELD_NAME = 'id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, self::ID_FIELD_NAME);
    }
}
