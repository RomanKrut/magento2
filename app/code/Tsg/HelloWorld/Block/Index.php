<?php

namespace Tsg\HelloWorld\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @return string
     */
    public function sayHello(): string
    {
        return sprintf('hello World from block %s', self::class);
    }
}
