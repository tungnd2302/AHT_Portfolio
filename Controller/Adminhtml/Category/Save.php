<?php
namespace AHT\Portfolio\Controller\Adminhtml\Category;

class Save extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Index';

    protected $_resultPageFactory;
    protected $_categoryFactory;
    protected $_categoryResoureModel;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \AHT\Portfolio\Model\CategoryFactory $categoryFactory,
        \AHT\Portfolio\Model\ResourceModel\Category $categoryResoureModel
    )
    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_categoryFactory = $categoryFactory;
        $this->_categoryResoureModel = $categoryResoureModel;
        
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
        $category = $this->_categoryFactory->create();
        $categoryData = [];

        $categoryData = [
            'name'  => $data['name']
        ];

        $category->setData($categoryData);
        $this->_categoryResoureModel->save($category);
       
        return $this;
    }

    public function updateItem($data){
        $id = $data['id'];
        $category = $this->_categoryFactory->create()->load($id);
        $categoryData = [];

        $categoryData = [
            'name'  => $data['name']
        ];
       
        $category->addData($categoryData);
        $this->_categoryResoureModel->save($category);
        return $this;
    }
}