<?php

namespace Tsg\Event\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Tsg\Event\Api\Data\EventInterface;

interface EventRepositoryInterface
{
    /**
     * @param int $id
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param $event
     * @return
     */
    public function save(EventInterface $event);

    /**
     * @param $event
     * @return void
     */
    public function delete(EventInterface $event);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Tsg\Event\Api\Data\EventSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
