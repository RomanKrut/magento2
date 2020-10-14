<?php
declare (strict_types=1);


namespace Tsg\KickStart\Controller\Categories;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;

class All extends Action
{
    public function execute()
    {
        $this->_forward('index', null, null, ['limit' => 1000]);
    }

}
