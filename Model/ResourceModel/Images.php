<?php
namespace AHT\Portfolio\Model\ResourceModel;

class Images extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {
    public function _construct() {
   	 $this->_init('AHT_Images', 'image_id');
    }
}