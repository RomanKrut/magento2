<?php

namespace Tsg\Event\Model;

use Tsg\Event\Model\ResourceModel\Event\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /** @var array */
    private $loadedData;

    /** @var \Tsg\Event\Model\Config\Media\Image  */
    private $imageConfig;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $eventCollection
     * @param \Tsg\Event\Model\Config\Media\Image $imageConfig
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $eventCollection,
        \Tsg\Event\Model\Config\Media\Image $imageConfig,
        array $meta = [],
        array $data = []
    )
    {
        $this->imageConfig = $imageConfig;
        $this->collection = $eventCollection->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if ($this->loadedData === null) {
            $this->collection->load();
            $this->loadedData = [];
            foreach ($this->collection as $item) {
                if ($item->getImage()) {
                    $item->setImage([[
                        'url' => $this->imageConfig->getEventMediaUrl($item->getImage()),
                        'name' => $item->getImage(),
                        'type' => 'image/png',
                    ]]);
                }
                $this->loadedData[$item->getEntityId()]['main_event_data'] = $item->getData();
            }
        }

        return $this->loadedData;
    }
}
