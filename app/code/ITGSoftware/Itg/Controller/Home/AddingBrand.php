<?php
/**
 * Created by PhpStorm.
 * User: othman
 * Date: 1/20/2019
 * Time: 11:54 AM
 */

namespace ItgSoftware\Itg\Controller\Home;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;

/**
 * Class AddingBrand controller for adding brand form
 * @package ITGSoftware\Itg\Controller\Home
 */
class AddingBrand extends  Action
{
    /**
     * @var \ItgSoftware\Brands\Model\BrandFactory
     */
    protected $_brandFactory;

    /**
     * @var \ItgSoftware\Brands\Model\ResourceModel\BrandFactory
     */
    protected $_brandResourceFactory;


    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param  \ItgSoftware\Brands\Model\BrandFactory $brandFactory
     * @param \ItgSoftware\Brands\Model\ResourceModel\BrandFactory $brandResourceFactory
     */
    public function __construct(
        Context $context,
        \ItgSoftware\Brands\Model\BrandFactory $brandFactory,
        \ItgSoftware\Brands\Model\ResourceModel\BrandFactory $brandResourceFactory)
    {
        $this->_brandFactory = $brandFactory;
        $this->_brandResourceFactory = $brandResourceFactory;
        return parent:: __construct($context);
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute()
    {
        if($this->isValidForm()){
            $params = (array) $this->getRequest()->getParams();
                if($this->addBrand($params)){
                    $this->messageManager->addSuccessMessage(__('A brand has been added successfully !'));
                    $resultRedirect = $this->resultRedirectFactory->create();
                    $resultRedirect->setPath('itg/home/brands');
                    return  $resultRedirect;
                }
                else {
                    $this->messageManager->addErrorMessage(__('A brand with same email is alredy exists!'));
                }
        }
        if(!$this->_view->isLayoutLoaded()){
            $this->_view->loadLayout();
            $this->_view->renderLayout();
        }
    }

    /**
     * Validate add brand form
     *
     * @return bool
     */
    public function isValidForm()
    {
        $data = $this->getRequest()->getParams();
        if(empty($data))
            return false;
        foreach ($data as $param) {
            if (empty($param) || $param == " ")
                return false;
        }
        return true;
    }

    /**
     * Add new brand to DB
     *
     * @param $data
     * @return bool
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function addBrand($data)
    {
        $brand = $this->_brandFactory->create();
        $brandResource = $this->_brandResourceFactory->create();

        $brandResource->load($brand,$data['brandemail'],'email');
        if($brand->getId())
            return false;
        $brand->setData([
            'brand_name'=> $data['brandname'],
            'brand_site_url'=> $data['siteurl'],
            'description'=>$data['decription'],
            'email' => $data['brandemail']
        ]);
        $brandResource->save($brand);
        return true;
    }
}