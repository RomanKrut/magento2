<?php

namespace Tsg\Event\Model\ResourceModel\Event;

use Tsg\Event\Model\Event;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'event_event_index_collection';
    protected $_eventObject = 'event_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Event::class, \Tsg\Event\Model\ResourceModel\Event::class);
    }
}
