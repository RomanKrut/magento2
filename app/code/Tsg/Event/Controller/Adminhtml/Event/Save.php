<?php

namespace Tsg\Event\Controller\Adminhtml\Event;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Tsg\Event\Model\Event;
use Tsg\Event\Model\EventRepository;

class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    public function execute()
    {
        $params = $this->getRequest()->getParams();
        // first_fieldset then set data to event object then save
        if ($params && array_key_exists('first_fieldset', $params)) {
            $firstSet = $params['first_fieldset'];
            /** @var Event $event */
            $event = $this->_objectManager->create(Event::class);
            $event->setName($firstSet['name']);
            $event->setIsActive($firstSet['is_active']);
            $event->setDescription($firstSet['description']);
            $event->setShortDescription($firstSet['short_description']);

            /** @var EventRepository $eventRepo */
            $eventRepo = $this->_objectManager->create(EventRepository::class);
            $eventRepo->save($event);
        }
    }
}
