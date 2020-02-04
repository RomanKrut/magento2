<?php


namespace Tsg\Event\Block\Adminhtml\Event\Edit\Buttons;

use Magento\Backend\Block\Widget\Context;
use Tsg\Event\Api\EventRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Generic
{
    /**
     * @var Context
     */
    protected $context;
    /**
     * @var EventRepositoryInterface
     */
    protected $eventRepository;
    /**
     * @param Context $context
     * @param EventRepositoryInterface $authorRepository
     */
    public function __construct(
        Context $context,
        EventRepositoryInterface $authorRepository
    ) {
        $this->context = $context;
        $this->eventRepository = $authorRepository;
    }
    /**
     * Return entity id
     *
     * @return int|null
     */
    public function getEntityId()
    {
        try {
            return $this->eventRepository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }
    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
