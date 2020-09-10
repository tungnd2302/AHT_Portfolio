<?php
namespace AHT\Portfolio\Controller\Adminhtml\Category;

class Edit extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Index';

    protected $_resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->_resultPageFactory->create();
    }
}
