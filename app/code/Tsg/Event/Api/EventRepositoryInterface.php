<?php

namespace Tsg\Event\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Tsg\Event\Api\Data\EventInterface;
use Tsg\Event\Api\Data\EventSearchResultInterface;

interface EventRepositoryInterface
{
    /**
     * @param int $id
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param EventInterface $event
     * @return
     */
    public function save(EventInterface $event);

    /**
     * @param EventInterface $event
     * @return void
     */
    public function delete(EventInterface $event);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return EventSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
