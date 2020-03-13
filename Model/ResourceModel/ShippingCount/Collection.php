<?php

namespace Objectsource\ShippingVolumeCap\Model\ResourceModel\ShippingCount;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Objectsource\ShippingVolumeCap\Model\ShippingCount as Model;
use Objectsource\ShippingVolumeCap\Model\ResourceModel\ShippingCount as Resource;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init(Model::class, Resource::class);
    }
}
