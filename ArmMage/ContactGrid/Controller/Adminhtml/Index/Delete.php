<?php

namespace ArmMage\ContactGrid\Controller\Adminhtml\Index;

use ArmMage\ContactGrid\Model\ResourceModel\ContactForm\Grid\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use ArmMage\ContactGrid\Model\ContactFormFactory;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'ArmMage_ContactGrid::delete';

    /**
     * Collection Factory
     *
     * @var CollectionFactory;
     */
    private $collectionFactory;

    /**
     * ContactForm Factory
     *
     * @var ContactFormFactory
     */
    private $contactFormFactory;

    /**
     * Mass action Filter
     *
     * @var Filter
     */
    private $filter;

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        Filter $filter,
        ContactFormFactory $contactFormFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->contactFormFactory = $contactFormFactory;
        parent::__construct($context);
    }

    /**
     * Execute action.
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     *
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            $deleteIds = $this->getRequest()->getParams('selected');
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $collection->addFieldToFilter('id', array('in' => $deleteIds));
            $count = 0;
            foreach ($collection as $item) {
                $model = $this->contactFormFactory->create()->load($item->getId());
                $model->delete();
                ++$count;
            }

            if ($count) {
                $this->messageManager->addSuccessMessage(__('A total of %1 record(s) were modified.', $count));
            }
        } catch (\Exception $e) {
            $deleteIds = $this->getRequest()->getParams('id');
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $collection->addFieldToFilter('id');
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultRedirect->setPath('contacts/index/index');
    }

    /**
     * Is the user allowed to delete the row.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
