<?php
declare (strict_types=1);

namespace Tsg\KickStart\Model\Resource\Sales\Bestsellers;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Tsg\KickStart\Model\Sales\Bestsellers as BestsellersModel;
use Tsg\KickStart\Model\Resource\Sales\Bestsellers as BestsellersResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(BestsellersModel::class, BestsellersResourceModel::class);
    }
}
