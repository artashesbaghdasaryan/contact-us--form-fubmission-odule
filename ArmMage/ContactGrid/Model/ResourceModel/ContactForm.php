<?php

namespace ArmMage\ContactGrid\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ContactForm extends AbstractDb
{

    protected function _construct()
    {
        $this->_init('am_contact_form', 'id');
    }
}
