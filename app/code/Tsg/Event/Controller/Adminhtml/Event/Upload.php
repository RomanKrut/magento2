<?php

namespace Tsg\Event\Controller\Adminhtml\Event;

use Magento\Framework\App\Filesystem\DirectoryList;

class Upload extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
    )
    {
        parent::__construct($context);
        $this->resultRawFactory = $resultRawFactory;
    }

    /**
     * Upload file controller action.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $imageUploadId = $this->_request->getParam('param_name', null);
        try {
            /** @var \Magento\MediaStorage\Model\File\Uploader $uploader */
            $uploader = $this->_objectManager->create(
                \Magento\MediaStorage\Model\File\Uploader::class,
                ['fileId' => $imageUploadId]
            );
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
            /** @var \Magento\Framework\Image\Adapter\AdapterInterface $imageAdapter */
            $imageAdapter = $this->_objectManager->get(\Magento\Framework\Image\AdapterFactory::class)->create();
            $uploader->addValidateCallback('event_event_image', $imageAdapter, 'validateUploadFile');
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
            $mediaDirectory = $this->_objectManager
                ->get(\Magento\Framework\Filesystem::class)
                ->getDirectoryRead(DirectoryList::MEDIA);
            /** @var \Tsg\Event\Model\Config\Media\Image $config */
            $config = $this->_objectManager->get(\Tsg\Event\Model\Config\Media\Image::class);
            $result = $uploader->save($mediaDirectory->getAbsolutePath($config->getTmpEventMediaPath()));

            unset($result['path']);
            $fileName = $result['file'];
            $result['url'] = $config ->getTmpEventMediaUrl($fileName);
        } catch (\Exception $exception) {
            $result = ['error' => $exception->getMessage(), 'errorcode' => $exception->getCode()];
        }
        /** @var \Magento\Framework\Controller\Result\Raw $response */
        $response = $this->resultRawFactory->create();
        $response->setHeader('Content-type', 'text/plain');
        $response->setContents(json_encode($result));

        return $response;
    }
}
