<?php

namespace Tsg\Event\Controller\Adminhtml\Event;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Tsg\Event\Model\Event;
use Tsg\Event\Model\EventRepository;
use Tsg\Event\Model\ImageUploader;

class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    public function execute()
    {
        $redirect = $this->resultRedirectFactory->create();
        $params = $this->getRequest()->getParams();
        if ($params && array_key_exists('main_event_data', $params)) {
            try {
                /** @var EventRepository $eventRepo */
                $eventRepo = $this->_objectManager->create(EventRepository::class);
                $firstSet = $params['main_event_data'];
                /** @var Event $event */
                if (array_key_exists('entity_id', $firstSet)) {
                    $event = $eventRepo->getById($firstSet['entity_id']);
                } else {
                    $event = $this->_objectManager->create(Event::class);
                }
                $event->setName($firstSet['name']);
                $event->setIsActive($firstSet['is_active']);
                $event->setDescription($firstSet['description']);
                $event->setShortDescription($firstSet['short_description']);
                $hasImage = array_key_exists('image', $firstSet);
                $hasNewImage = array_key_exists('tmp_name', $firstSet['image'][0]);
                if ($hasImage && $hasNewImage) {
                    $event->setImage($firstSet['image'][0]['file']);
                }
                $eventRepo->save($event);
                /** @var ImageUploader $image */
                $image = $this->_objectManager->create(ImageUploader::class);
                if ($hasNewImage && $event->getImage()) {
                    $image->moveImageFromTmp($event->getImage());
                }

                $this->messageManager->addSuccessMessage('Event successfully saved');
                $eventId = $event->getId();
                if ($eventId && $this->getRequest()->getParam('back', false) === 'edit') {
                    $redirect->setPath(
                        '*/*/edit',
                        ['id' => $event->getEntityId(), 'back' => null, '_current' => true]
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
