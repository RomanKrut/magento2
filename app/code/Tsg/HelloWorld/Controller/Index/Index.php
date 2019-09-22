<?php

namespace Tsg\HelloWorld\Controller\Index;

use \Magento\Framework\App\Action\Action;

class Index extends Action
{
    /**
     * @return void
     */
    public function execute(): void
    {
        echo 'Hello World';
    }
}
