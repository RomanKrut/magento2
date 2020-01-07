<?php

namespace Tsg\Event\Model\ResourceModel;

class Event extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('tsg_event_entity', 'entity_id');
    }
}
