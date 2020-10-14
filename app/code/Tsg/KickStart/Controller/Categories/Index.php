<?php
declare (strict_types=1);


namespace Tsg\KickStart\Controller\Categories;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\HTTP\PhpEnvironment\Request;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\Collection;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory;
use Tsg\KickStart\Model\Resource\Sales\Bestsellers;

class Index extends Action
{
    /** @var CollectionFactory  */
    private $bestSellersCollectionFactory;

    public function __construct(Context $context, CollectionFactory $bestSellersCollectionFactory)
    {
        parent::__construct($context);
        $this->bestSellersCollectionFactory = $bestSellersCollectionFactory;
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);

        /** @var Collection $collection */
        $collection = $this->bestSellersCollectionFactory->create();
        $mainTable = Bestsellers::MAIN_TABLE;
        $collection->getSelect()->joinLeft(
            $mainTable,
            "sales_bestsellers_aggregated_yearly.id = $mainTable.id",
            ['is_featured' => "SUM($mainTable.is_featured)"]
        );
        $collection->addOrder("$mainTable.is_featured", Collection::SORT_ORDER_DESC);
        $collection->addOrder("sales_bestsellers_aggregated_yearly.id", Collection::SORT_ORDER_DESC);
        foreach ($collection as $item) {
            var_dump($item->getData());
        }
        $result->setContents("Hello");
        return $result;
    }
}
