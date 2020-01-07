<?php

namespace Tsg\Event\Api\Data;

interface EventInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return void
     */
    public function setName($name);

    /**
     * @return int
     */
    public function getIsActive();

    /**
     * @param int $isActive
     * @return void
     */
    public function setIsActive($isActive);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     * @return void
     */
    public function setDescription($description);

    /**
     * @return string
     */
    public function getShortDescription();

    /**
     * @param string $shortDescription
     * @return void
     */
    public function setShortDescription($shortDescription);

}
