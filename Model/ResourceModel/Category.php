<?php
namespace AHT\Portfolio\Model\ResourceModel;

class Category extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {
    protected function _construct() 
    {
        $this->_init('AHT_Categories', 'id');
        // $this->_getLoadSelect('abc','123','345');
    }
}