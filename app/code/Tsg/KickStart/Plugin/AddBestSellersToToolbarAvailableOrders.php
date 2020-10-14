<?php
declare (strict_types=1);

namespace Tsg\KickStart\Plugin;

use Magento\Catalog\Block\Product\ProductList\Toolbar;

class AddBestSellersToToolbarAvailableOrders
{
    /**
     * @param Toolbar $subject
     * @param $result
     * @return array
     */
    public function afterGetAvailableOrders(Toolbar $subject, $result): array
    {
        $result['bestsellers'] = 'BestSellers';

        return $result;
    }
}
