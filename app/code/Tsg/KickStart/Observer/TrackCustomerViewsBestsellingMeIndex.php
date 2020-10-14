<?php
declare (strict_types=1);


namespace Tsg\KickStart\Observer;


use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class TrackCustomerViewsBestsellingMeIndex implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $customerId = $observer->getData('customer_id');
        if ($customerId) {
            var_dump($customerId);
        }
    }
}
