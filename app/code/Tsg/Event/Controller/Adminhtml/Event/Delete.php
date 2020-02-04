<?php

namespace Tsg\Event\Controller\Adminhtml\Event;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;

use Tsg\Event\Model\EventRepository;

class Delete extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $params = $this->getRequest()->getParams();
        if (array_key_exists('id', $params)) {
            $id = $params['id'];
            /** @var EventRepository $eventRepo */
            $eventRepo = $this->_objectManager->create(EventRepository::class);
            try {
                $event = $eventRepo->getById($id);
                $eventRepo->delete($event);
                $this->messageManager->addSuccessMessage('Event entity successfully deleted');
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage(sprintf('No entity with id = %s found', $id));
            }
        } else {
            $this->messageManager->addErrorMessage(sprintf('Parameter %s should be provided', 'id'));
        }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
