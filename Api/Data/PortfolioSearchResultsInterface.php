<?php

namespace AHT\Portfolio\Api\Data;

interface PortfolioSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{   
    public function getItems();
    
    public function setItems(array $items);
}