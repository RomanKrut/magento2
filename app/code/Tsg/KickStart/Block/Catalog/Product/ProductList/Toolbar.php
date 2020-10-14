<?php
declare (strict_types=1);

namespace Tsg\KickStart\Block\Catalog\Product\ProductList;

class Toolbar extends \Magento\Catalog\Block\Product\ProductList\Toolbar
{
    /**
     * Retrieve available Order fields list
     *
     * @return array
     */
    public function getAvailableOrders()
    {
        $availableOrders = parent::getAvailableOrders();
        $availableOrders['bestsellers'] = __('Bestsellers');

        return $availableOrders;
    }
}
