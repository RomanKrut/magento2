<?php
declare (strict_types=1);

namespace Tsg\KickStart\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class Description implements ArgumentInterface
{
    /**
     * @return string
     */
    public function getWordsCount(): string
    {
        $description = 'This is a description';
        $wordsCount = str_word_count($description);

        return "$description (<em>$wordsCount words</em>)";
    }
}
