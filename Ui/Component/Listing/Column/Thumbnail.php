<?php
namespace AHT\Portfolio\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{
    const NAME = 'Thumbnail';

    const ALT_FIELD = 'path';

    protected $_storeManager;
    protected $_fileSystem;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,        
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Filesystem $filesystem
    ) {        
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->_storeManager = $storeManager;
        $this->_fileSystem = $filesystem;
        $this->urlBuilder = $urlBuilder;
    }

    /**
    * Prepare Data Source
    *
    * @param array $dataSource
    * @return array
    */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $mediaRelativePath=$this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'portfolio/image/';
                // $mediaRelativePath = $this->_fileSystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath() . 'logo/image/';
                $logoPath=$mediaRelativePath.$item['path_1'];
                $item[$fieldName . '_src'] = $logoPath;
                $item[$fieldName . '_alt'] = $this->getAlt($item);
                // $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                //     'brand/manage/edit',
                //     ['brand_id' => $item['brand_id'], 'store' => $this->context->getRequestParam('store')]
                // );
                $item[$fieldName . '_orig_src'] = $logoPath;

            }
        }
        return $dataSource;
    }

    /**
    * @param array $row
    *
    * @return null|string
    */
    protected function getAlt($row)
    {
        $altField = self::ALT_FIELD;
        return isset($row[$altField]) ? $row[$altField] : null;
    }
}