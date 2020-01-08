<?php

namespace Tsg\Event\Controller\Adminhtml\Event;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Tsg\Event\Model\Event;
use Tsg\Event\Model\EventRepository;

class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    public function execute()
    {
        $redirect = $this->resultRedirectFactory->create();
        $params = $this->getRequest()->getParams();

        if ($params && array_key_exists('main_event_data', $params)) {
            $firstSet = $params['main_event_data'];
            /** @var Event $event */
            $event = $this->_objectManager->create(Event::class);
            $event->setName($firstSet['name']);
            $event->setIsActive($firstSet['is_active']);
            $event->setDescription($firstSet['description']);
            $event->setShortDescription($firstSet['short_description']);

            /** @var EventRepository $eventRepo */
            $eventRepo = $this->_objectManager->create(EventRepository::class);
            try {
                $eventRepo->save($event);
                $this->messageManager->addSuccessMessage('Event successfully saved');
                $eventId = $event->getId();
                if ($eventId && $this->getRequest()->getParam('back', false) === 'edit') {
                    $redirect->setPath(
                        '*/*/edit',
                        ['id' => $eventId->getEntityId(), 'back' => null, '_current' => true]
                    );
                } else {
                    $redirect->setPath('*/*/index');
                }
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage('Event was not saved');
                $redirect->setPath('*/*/newEvent');
            }
        }

        return $redirect;
    }
}
