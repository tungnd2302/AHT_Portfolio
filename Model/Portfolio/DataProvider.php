<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AHT\Portfolio\Model\Portfolio;

use AHT\Portfolio\Model\ResourceModel\Portfolio\Grid\CollectionFactory;
// use AHT\Portfolio\Model\Portfolio;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $_loadedData;
    protected $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $portfolioCollectionFactory,
        array $meta = [],
        array $data = [],
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ){
        $this->collection = $portfolioCollectionFactory->create();
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {   
        if(isset($this->_loadedData)) {
            return $this->_loadedData;
        }

        $items = $this->collection->getItems();
        
        $this->_loadedData = array();
        foreach($items as $contact)
        { 
            $itemData = $contact->getData();
            if (isset($itemData['path_1'])) {
                $imageName = $itemData['path_1'];
                $itemData['path_1'] = [
                    [
                        'name' => $itemData['path_1'],
                        'url'  => $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'portfolio/image/' . $itemData['path_1'],
                    ],
                ];
            } else {
                $itemData['path_1'] = null;
            }

            if (isset($itemData['path_2'])) {
                $imageName = $itemData['path_2'];
                $itemData['path_2'] = [
                    [
                        'name' => $itemData['path_2'],
                        'url'  => $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'portfolio/image/' . $itemData['path_2'],
                    ],
                ];
            } else {
                $itemData['path_2'] = null;
            }

            if (isset($itemData['path_3'])) {
                $imageName = $itemData['path_3'];
                $itemData['path_3'] = [
                    [
                        'name' => $itemData['path_3'],
                        'url'  => $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'portfolio/image/' . $itemData['path_3'],
                    ],
                ];
            } else {
                $itemData['path_3'] = null;
            }

            if (isset($itemData['path_4'])) {
                $imageName = $itemData['path_4'];
                $itemData['path_4'] = [
                    [
                        'name' => $itemData['path_4'],
                        'url'  => $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'portfolio/image/' . $itemData['path_4'],
                    ],
                ];
            } else {
                $itemData['path_4'] = null;
            }

            $this->_loadedData[$contact->getId()] = $itemData;
        }
        
        return $this->_loadedData;
    }

    // public function getData(){
    //     if (!$this->loadedData) {
    //         $storeId = (int) $this->request->getParam('store');
    //         $this->collection->setStoreId($storeId)->addAttributeToSelect('*');
    //         $items = $this->collection->getItems();
    //         foreach ($items as $item) {
    //             $item->setStoreId($storeId);
    //             $itemData = $item->getData();
                // if (isset($itemData['logo'])) {
                //     $imageName = explode('/', $itemData['logo']);
                //     $itemData['logo'] = [
                //         [
                //             'name' => $imageName[3],
                //             'url' => $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'logo/image' . $itemData['logo'],
                //         ],
                //     ];
                // } else {
                //     $itemData['logo'] = null;
                // }
                
    //             $this->loadedData[$item->getEntityId()] = $itemData;
    //             break;
    //         }
    //     }
    //     return $this->loadedData;
    // }

    
}