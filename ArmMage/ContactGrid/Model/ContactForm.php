<?php

namespace ArmMage\ContactGrid\Model;

use Magento\Framework\Model\AbstractModel;
use ArmMage\ContactGrid\Model\ResourceModel\ContactForm as Resource;

class ContactForm extends AbstractModel
{

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Resource::class);
    }
}
