<?php

namespace Tsg\Event\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => '1', 'label' => 'Event is not come yet'],
            ['value' => '2', 'label' => 'Event is active'],
            ['value' => '3', 'label' => 'Event is closed'],
        ];
    }
}
