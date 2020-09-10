<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AHT\Portfolio\Model\Category;

use AHT\Portfolio\Model\ResourceModel\Category\Grid\CollectionFactory;
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
            $this->_loadedData[$contact->getId()] = $itemData;
        }
        // echo "<pre>";
        // print_r($this->_loadedData);
        // echo "</pre>";
        // die;
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