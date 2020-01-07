<?php

namespace Tsg\Event\Api\Data;

interface EventSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Tsg\Event\Api\Data\EventInterface[]
     */
    public function getItems();

    /**
     * @param \Tsg\Event\Api\Data\EventInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
