<?php
namespace AHT\Portfolio\Model\ResourceModel\Images;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{       
    public function _construct() {
   	 $this->_init('AHT\Portfolio\Model\Images', 'AHT\Portfolio\Model\ResourceModel\Images');
    }

}