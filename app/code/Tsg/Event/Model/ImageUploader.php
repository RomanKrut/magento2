<?php

namespace Tsg\Event\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\Uploader as FileUploader;

class ImageUploader
{
    /** @var \Magento\MediaStorage\Helper\File\Storage\Database */
    protected $_coreFileStorageDb;

    /** @var \Magento\Framework\Filesystem\Directory\WriteInterface*/
    protected $mediaDirectory;

    /** @var \Tsg\Event\Model\Config\Media\Image */
    private $imageConfig;

    public function __construct(
        \Magento\MediaStorage\Helper\File\Storage\Database $coreFileStorageDb,
        \Magento\Framework\Filesystem $filesystem,
        \Tsg\Event\Model\Config\Media\Image $imageConfig
    )
    {
        $this->_coreFileStorageDb = $coreFileStorageDb;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->imageConfig = $imageConfig;

    }

    /**
     * Move image from temporary directory to normal
     *
     * @param string $file
     * @return string
     */
    public function moveImageFromTmp($file)
    {
        $file = $this->getFilenameFromTmp($this->getSafeFilename($file));
        $destinationFile = $this->getUniqueFileName($file);

        if ($this->_coreFileStorageDb->checkDbUsage()) {
            $this->_coreFileStorageDb->renameFile(
                $this->imageConfig->getShortTmpEventMediaUrl($file),
                $this->imageConfig->getShortEventMediaUrl($destinationFile)
            );

            $this->mediaDirectory->delete($this->imageConfig->getShortTmpEventMediaUrl($file));
            $this->mediaDirectory->delete($this->imageConfig->getShortEventMediaUrl($destinationFile));
        } else {
            $this->mediaDirectory->renameFile(
                $this->imageConfig->getShortTmpEventMediaUrl($file),
                $this->imageConfig->getShortEventMediaUrl($destinationFile)
            );
        }

        return str_replace('\\', '/', $destinationFile);
    }

    /**
     * Returns file name according to tmp name
     *
     * @param string $file
     * @return string
     */
    protected function getFilenameFromTmp($file)
    {
        return strrpos($file, '.tmp') === strlen($file) - 4 ? substr($file, 0, strlen($file) - 4) : $file;
    }

    /**
     * Returns safe filename for posted image
     *
     * @param string $file
     * @return string
     */
    private function getSafeFilename($file)
    {
        $file = DIRECTORY_SEPARATOR . ltrim($file, DIRECTORY_SEPARATOR);

        return $this->mediaDirectory->getDriver()->getRealPathSafety($file);
    }

    /**
     * Check whether file to move exists. Getting unique name
     *
     * @param string $file
     * @param bool $forTmp
     * @return string
     */
    protected function getUniqueFileName($file, $forTmp = false)
    {
        if ($this->_coreFileStorageDb->checkDbUsage()) {
            $destFile = $this->_coreFileStorageDb->getUniqueFilename(
                $this->imageConfig->getEventMediaPath(),
                $file
            );
        } else {
            $destinationFile = $forTmp
                ? $this->mediaDirectory->getAbsolutePath($this->imageConfig->getShortTmpEventMediaUrl($file))
                : $this->mediaDirectory->getAbsolutePath($this->imageConfig->getShortEventMediaUrl($file));
            // phpcs:disable Magento2.Functions.DiscouragedFunction
            $destFile = dirname($file) . '/' . FileUploader::getNewFileName($destinationFile);
        }

        return $destFile;
    }
}
