<?php
declare (strict_types=1);

namespace Tsg\KickStart\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
