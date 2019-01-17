<?php
/**
 * 
 */

namespace ItgSoftware\Itg\Controller\Home;

use Magento\Catalog\Api\ProductRepositoryInterface;

/**
 *Greeting page controller 
 */
    class Greeting extends \Magento\Framework\App\Action\Action
    {
        /**
         * @var \Magento\Framework\View\Result\PageFactory
         */
        protected $_pageFactory;

        /**
         * @var Magento\Catalog\Api\ProductRepositoryInterface
         */
        protected $productRepository;

        /**
         * @param \Magento\Framework\App\Action\Context $context
         * @param \Magento\Framework\View\Result\PageFactory $pageFactory
         * @param Magento\Catalog\Api\ProductRepositoryInterface $productRepository
         * @return \Magento\Framework\App\Action\Action
         */
        public function __construct(
            \Magento\Framework\App\Action\Context $context,
            \Magento\Framework\View\Result\PageFactory $pageFactory,
            ProductRepositoryInterface $productRepository
            ){
            $this->_pageFactory = $pageFactory;
            $this->productRepository = $productRepository;
            return parent:: __construct($context);
        }
        
        /**
         * Itg Greeting action
         */
        public function execute()
        {
            $prodcut = $this->productRepository->getById(1);
            return $this->_pageFactory->create();
        }
    }