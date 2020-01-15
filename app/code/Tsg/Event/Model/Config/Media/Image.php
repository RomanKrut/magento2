<?php

namespace Tsg\Event\Model\Config\Media;

use Magento\Store\Model\StoreManagerInterface;

class Image
{
    /** @var string  */
    private const EVENT_MEDIA_DIR = 'event';

    /** @var StoreManagerInterface */
    private $storeManager;

    /**
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    /**
     * @return string
     */
    public function getEventMediaPath(): string
    {
        return self::EVENT_MEDIA_DIR;
    }

    /**
     * @return string
     */
    public function getTmpEventMediaPath(): string
    {
        return 'tmp/' . self::EVENT_MEDIA_DIR;
    }

    /**
     * @param string $fileName
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getTmpEventMediaUrl(string $fileName): string
    {
        $baseMediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $baseMediaUrl . $this->getShortTmpEventMediaUrl($fileName);
    }

    /**
     * @param string $fileName
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getEventMediaUrl(string $fileName): string
    {
        $baseMediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $baseMediaUrl . $this->getShortEventMediaUrl($fileName);
    }

    /**
     * @param $fileName
     * @return string
     */
    public function getShortTmpEventMediaUrl($fileName): string
    {
        return 'tmp' . '/' . self::EVENT_MEDIA_DIR . '/' . $this->_prepareFile($fileName);
    }

    /**
     * @param $fileName
     * @return string
     */
    public function getShortEventMediaUrl($fileName): string
    {
        return self::EVENT_MEDIA_DIR . '/' . $this->_prepareFile($fileName);
    }

    /**
     * Process file path.
     *
     * @param string $file
     * @return string
     */
    protected function _prepareFile($file)
    {
        return ltrim(str_replace('\\', '/', $file), '/');
    }
}
