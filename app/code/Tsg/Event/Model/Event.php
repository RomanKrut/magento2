<?php

namespace Tsg\Event\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Tsg\Event\Api\Data\EventInterface;

class Event extends AbstractExtensibleModel implements EventInterface
{
    private const NAME = 'name';

    private const IS_ACTIVE = 'is_active';

    private const DESCRIPTION = 'description';

    private const SHORT_DESCRIPTION = 'short_description';

    private const IMAGE = 'image';

    protected function _construct()
    {
        parent::_construct();
        $this->_init(\Tsg\Event\Model\ResourceModel\Event::class);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_getData(self::NAME);
    }

    public function setName($name)
    {
        $this->setData(self::NAME, $name);
    }

    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    public function setIsActive($isActive)
    {
        $this->setData(self::IS_ACTIVE, $isActive);
    }

    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    public function setDescription($description)
    {
        $this->setData(self::DESCRIPTION, $description);
    }

    public function getShortDescription()
    {
        return $this->getData(self::SHORT_DESCRIPTION);
    }

    public function setShortDescription($shortDescription)
    {
        $this->setData(self::SHORT_DESCRIPTION, $shortDescription);
    }

    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    public function setImage($image)
    {
        $this->setData(self::IMAGE, $image);
    }
}
