<?php

namespace ArmMage\ContactGrid\Plugin;

use ArmMage\ContactGrid\Model\ContactFormFactory;
use Magento\Contact\Controller\Index\Post;
use Magento\Framework\Exception\LocalizedException;

class ContactPlugin
{
    /**
     * @var ContactFormFactory
     */
    private $contactFactory;


    /**
     * constructor
     *
     * @param ContactFormFactory $customerFactory
     */
    public function __construct(ContactFormFactory $contactFactory)
    {
        $this->contactFactory = $contactFactory;
    }

    /**
     *  Saving contact data
     *
     * @return mixed
     */
    public function afterExecute(Post $subject, $result)
    {
        $postData = $subject->getRequest()->getParams();

        try {

            $customer = $this->contactFactory->create();
            $postData = $this->validatePostData($postData);
            $customer->setData('name', $postData['name']);
            $customer->setData('email', $postData['email']);
            $customer->setData('phone_number', $postData['telephone']);
            $customer->setData('description', $postData['comment']);
            $customer->save();
        } catch (\Exception $e) {
            $this->messageManager->addWarning(__('Could not  Save Data'));
        }

        return  $result;
    }

    /**
     * Validate  Post Data for  Saving
     *
     * @param mixed[] $data
     * @return mixed[]
     */
    private function validatePostData($data)
    {

        if (trim($data['name']) === '') {
            throw new LocalizedException(__('Enter the Name and try again.'));
        }
        if (trim($data['comment']) === '') {
            throw new LocalizedException(__('Enter the comment and try again.'));
        }
        if (false === \strpos($data['email'], '@')) {
            throw new LocalizedException(__('The email address is invalid. Verify the email address and try again.'));
        }

        return $data;
    }
}
