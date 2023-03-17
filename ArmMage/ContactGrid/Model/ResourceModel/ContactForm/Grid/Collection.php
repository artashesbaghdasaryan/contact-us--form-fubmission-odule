<?php

namespace ArmMage\ContactGrid\Model\ResourceModel\ContactForm\Grid;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use ArmMage\ContactGrid\Model\ContactForm as Model;
use ArmMage\ContactGrid\Model\ResourceModel\ContactForm as Resource;

class Collection extends AbstractCollection
{
    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Model::class, Resource::class);
    }
}
