<?php

namespace Tsg\Event\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;

use Tsg\Event\Api\Data\EventInterface;
use Tsg\Event\Api\EventRepositoryInterface;
use Tsg\Event\Model\ResourceModel\Event\Collection;
use Tsg\Event\Api\Data\EventSearchResultInterfaceFactory;
use Tsg\Event\Model\ResourceModel\Event\CollectionFactory as EventCollectionFactory;
use Tsg\Event\Model\ResourceModel\Event as EventResource;

class EventRepository implements EventRepositoryInterface
{
    /**
     * @var EventFactory
     */
    private $eventFactory;

    /**
     * @var EventCollectionFactory
     */
    private $eventCollectionFactory;

    /**
     * @var EventSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /** @var EventResource */
    private $eventResource;

    public function __construct(
        EventFactory $eventFactory,
        EventCollectionFactory $eventCollectionFactory,
        EventResource $eventResource,
        EventSearchResultInterfaceFactory $eventSearchResultInterfaceFactory
    )
    {
        $this->eventFactory = $eventFactory;
        $this->eventCollectionFactory = $eventCollectionFactory;
        $this->searchResultFactory = $eventSearchResultInterfaceFactory;
        $this->eventResource = $eventResource;
    }

    /**
     * @param int $id
     * @return EventInterface
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $event = $this->eventFactory->create();
        $this->eventResource->load($event, $id);
        if (!$event->getId()) {
            throw new NoSuchEntityException(__('Unable to find event with ID "%1"', $id));
        }
        return $event;
    }

    public function delete(EventInterface $event)
    {
        $this->eventResource->delete($event);
        return $event;
    }

    public function save(EventInterface $event)
    {
        $this->eventResource->save($event);
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->eventCollectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
