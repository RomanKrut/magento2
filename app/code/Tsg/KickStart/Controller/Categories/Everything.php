<?php
declare (strict_types=1);


namespace Tsg\KickStart\Controller\Categories;


use Magento\Framework\App\Action\Action;

class Everything extends Action
{
    public function execute()
    {
        $this->_redirect('*/*', ['limit' => 2000]);
    }
}
