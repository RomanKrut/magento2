<?php
declare (strict_types=1);

namespace Tsg\KickStart\Controller\Me;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    /** @var CustomerSession */
    protected $customerSession;

    public function __construct(Context $context, CustomerSession $customerSession)
    {
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        /** @var  $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);

        $this->_eventManager->dispatch(
            'customer_views_bestselling_me_index',
            ['customer_id'=>  $this->customerSession->getCustomerId()]
        );
//        return $result;
    }
}
