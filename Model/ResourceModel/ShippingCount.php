<?php

namespace Objectsource\ShippingVolumeCap\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ShippingCount extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('shipping_method_volume_count', 'entity_id');
    }
}