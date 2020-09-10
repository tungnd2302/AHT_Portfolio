<?php
namespace AHT\Portfolio\Controller\Adminhtml\Index;

class Save extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Index';

    protected $_resultPageFactory;
    protected $_portfolioFactory;
    protected $_imagesFactory;
    protected $_portfolioResoureModel;
    protected $_imagesResoureModel;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \AHT\Portfolio\Model\PortfolioFactory $portfolioFactory,
        \AHT\Portfolio\Model\ImagesFactory $imagesFactory,
        \AHT\Portfolio\Model\ResourceModel\Portfolio $portfolioResoureModel,
        \AHT\Portfolio\Model\ResourceModel\Images $imagesResoureModel
    )
    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_portfolioFactory = $portfolioFactory;
        $this->_portfolioResoureModel = $portfolioResoureModel;
        $this->_imagesFactory = $imagesFactory;
        $this->_imagesResoureModel = $imagesResoureModel;
        
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if($data)
        {
            try{
                $id = $data['id'];
                if(empty($id)){
                    $this->saveItem($data);
                }else{
                    $this->updateItem($data);
                }
                $this->messageManager->addSuccess(__('Lưu portfolio thành công.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                return $resultRedirect->setPath('*/*/');
            }
            catch(\Exception $e)
            {
                $this->messageManager->addError($e->getMessage());
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);
                // return $resultRedirect->setPath('*/*/edit', ['id' => $portfolio->getId()]);
            }
        }

         return $resultRedirect->setPath('*/*/');
    }

    public function saveItem($data){
        //     echo "<pre>";
        //     print_r($data);
        //     echo "</pre>";
        //   die;
        $portfolio = $this->_portfolioFactory->create();
        $images    = $this->_imagesFactory->create();
        $portfolioData = [];
        $imageData = [];

        $portfolioData = [
            'title'  => $data['title'],
            'categoryid'  => $data['categoryid'],
            'description'  => $data['description']
        ];
       
        $portfolio->setData($portfolioData);
        $this->_portfolioResoureModel->save($portfolio);
        $lastPortfolioId = $portfolio->getId();
        $relativePath_1 = (isset($data['path_1'])) ? $this->getRelativePath($data['path_1'][0]['url']) : '' ;
        $relativePath_2 = (isset($data['path_2'])) ? $this->getRelativePath($data['path_2'][0]['url']) : '' ;
        $relativePath_3 = (isset($data['path_3'])) ? $this->getRelativePath($data['path_3'][0]['url']) : '' ;
        $relativePath_4 = (isset($data['path_4'])) ? $this->getRelativePath($data['path_4'][0]['url']) : '' ;
    
        $imageData = [
            'PortfolioId'  => $lastPortfolioId,
            'path_1'         => $relativePath_1,
            'path_2'         => $relativePath_2,
            'path_3'         => $relativePath_3,
            'path_4'         => $relativePath_4,
        ];

        $images->setData($imageData);
        $this->_imagesResoureModel->save($images);
        return $this;
    }

    public function updateItem($data){
        $id = $data['id'];
        $portfolio = $this->_portfolioFactory->create()->load($id);
        $portfolioimages    = $this->_imagesFactory->create();
        
        $portfolioData = [];
        $imageData = [];

        $portfolioData = [
            'title'  => $data['title'],
            'categoryid'  => $data['categoryid'],
            'description'  => $data['description']
        ];
       
        $portfolio->addData($portfolioData);
        $this->_portfolioResoureModel->save($portfolio);

        
        $portfolioImage = $portfolioimages->getCollection()->addFieldToFilter('PortfolioId',$id)->getFirstItem()->getData();
    //     echo "<pre>";
    //     print_r($data);
    //     echo "</pre>";
    //   die;
        if(isset($data['path_1']) || isset($data['path_2']) || isset($data['path_3']) || isset($data['path_4'])){
            $relativePath_1 = (isset($data['path_1'])) ? $this->getRelativePath($data['path_1'][0]['url']) : '' ;
            $relativePath_2 = (isset($data['path_2'])) ? $this->getRelativePath($data['path_2'][0]['url']) : '' ;
            $relativePath_3 = (isset($data['path_3'])) ? $this->getRelativePath($data['path_3'][0]['url']) : '' ;
            $relativePath_4 = (isset($data['path_4'])) ? $this->getRelativePath($data['path_4'][0]['url']) : '' ;
        
            $imageData = [
                'PortfolioId'    => $id,
                'path_1'         => $relativePath_1,
                'path_2'         => $relativePath_2,
                'path_3'         => $relativePath_3,
                'path_4'         => $relativePath_4,
            ];

            if(count($portfolioImage) > 0){
                $id = $portfolioImage['image_id'];
                $images    = $portfolioimages->load($id);
                $images->addData($imageData);
                $this->_imagesResoureModel->save($images);
            }else{
                $images    = $portfolioimages;
                $images->setData($imageData);
                $this->_imagesResoureModel->save($images);
            }
        }else{
           if(isset($portfolioImage['image_id'])){
                $id = $portfolioImage['image_id'];   
                $images    = $portfolioimages->load($id)->delete();
           }
        }

        return $this;
    }

    public function getRelativePath($path){
        $relativePath = '';
        $posTmp = strrpos($path,"image");
        $relativePath = substr($path,$posTmp + 6);
        return $relativePath;
    }
}