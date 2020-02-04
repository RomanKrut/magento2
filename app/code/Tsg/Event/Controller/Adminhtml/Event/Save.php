<?php

namespace Tsg\Event\Controller\Adminhtml\Event;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Tsg\Event\Model\Event;
use Tsg\Event\Model\EventRepository;
use Tsg\Event\Model\ImageUploader;

class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /** @var Event */
    private $eventObject;

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
                    $this->eventObject = $eventRepo->getById($firstSet['entity_id']);
                } else {
                    $this->eventObject = $this->_objectManager->create(Event::class);
                }
                $this->eventObject->setName($firstSet['name']);
                $this->eventObject->setIsActive($firstSet['is_active']);
                $this->eventObject->setDescription($firstSet['description']);
                $this->eventObject->setShortDescription($firstSet['short_description']);
                $hasImage = array_key_exists('image', $firstSet);
                /** @var ImageUploader $imageUploader */
                $imageUploader = $this->_objectManager->create(ImageUploader::class);
                if ($hasImage) {
                    $hasNewImage = array_key_exists('tmp_name', $firstSet['image'][0]);
                    if ($hasImage && $hasNewImage) {
                        if ($this->eventObject->getImage()) {
                            $this->deleteOldImage();
                        }
                        $this->eventObject->setImage($firstSet['image'][0]['file']);
                    }
                    if ($hasNewImage && $this->eventObject->getImage()) {
                        $imageUploader->moveImageFromTmp($this->eventObject->getImage());
                    }
                } elseif ($this->eventObject->getImage()) {
                    $this->deleteOldImage();
                    $this->eventObject->setImage('');
                }
                $eventRepo->save($this->eventObject);
                $this->messageManager->addSuccessMessage('Event successfully saved');
                $eventId = $this->eventObject->getId();
                if ($eventId && $this->getRequest()->getParam('back', false) === 'edit') {
                    $redirect->setPath(
                        '*/*/edit',
                        ['id' => $this->eventObject->getEntityId(), 'back' => null, '_current' => true]
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

    /**
     *
     */
    private function deleteOldImage()
    {
        /** @var Filesystem $fileSystem */
        $fileSystem = $this->_objectManager->get(Filesystem::class);
        /** @var \Magento\Framework\Filesystem\Directory\Write $writeDir */
        $writeDir = $fileSystem->getDirectoryWrite(DirectoryList::MEDIA);
        $imageToDelete = $this->eventObject->getImage();
        /** @var \Tsg\Event\Model\Config\Media\Image $config */
        $config = $this->_objectManager->get(\Tsg\Event\Model\Config\Media\Image::class);
        $realPathToImage = $config->getFilePathWithEventDir($imageToDelete);
        if ($writeDir->isExist($realPathToImage)) {
            $writeDir->delete($realPathToImage);
        }
    }
}
