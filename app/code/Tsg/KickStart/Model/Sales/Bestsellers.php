<?php
declare (strict_types=1);

namespace Tsg\KickStart\Model\Sales;

use Magento\Framework\Model\AbstractModel;
use Tsg\KickStart\Model\Resource\Sales\Bestsellers as BestsellersResourceModel;

/**
 * Best sellers sales model
 */
class Bestsellers extends AbstractModel
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(BestsellersResourceModel::class);
    }
}
