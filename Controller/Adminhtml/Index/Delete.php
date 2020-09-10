<?php
namespace AHT\Portfolio\Controller\Adminhtml\Index;

use AHT\Portfolio\Model\Portfolio as Portfolio;


class Delete extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Index';

    protected $resultPageFactory;
    protected $_portfolioFactory;
    protected $_imagesFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \AHT\Portfolio\Model\PortfolioFactory $portfolioFactory,
        \AHT\Portfolio\Model\ImagesFactory $imagesFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->_portfolioFactory = $portfolioFactory;
        $this->_imagesFactory = $imagesFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
                //   die;
        $portfolioImages    = $this->_imagesFactory->create();
        
        $portfolioImage = $portfolioImages->getCollection()->addFieldToFilter('PortfolioId',$id)->getFirstItem()->getData();

        $portfolio = $this->_portfolioFactory->create()->load($id);

        if(!$portfolio)
        {
            $this->messageManager->addError(__('Unable to process. please, try again.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/', array('_current' => true));
        }

        try{
            $portfolio->delete();
            if(count($portfolioImage) > 0){
                $imageId = $portfolioImage['image_id'];
                $portfolioImages->load($imageId)->delete();
            }
            $this->messageManager->addSuccess(__('Your contact has been deleted !'));
        }
        catch(\Exception $e)
        {
            $this->messageManager->addError(__('Error while trying to delete contact'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', array('_current' => true));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', array('_current' => true));
    }
}