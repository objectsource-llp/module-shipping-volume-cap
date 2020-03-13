<?php

namespace Objectsource\ShippingVolumeCap\Api;

use Objectsource\ShippingVolumeCap\Api\Data\ShippingCountInterface;
use Objectsource\ShippingVolumeCap\Model\ShippingCount;

interface ShippingCountRepositoryInterface
{
    /**
     * @param string $methodCode
     * @return ShippingCount
     */
    public function getCountByMethodCode(string $methodCode): ShippingCount;

    /**
     * @param ShippingCount $shippingCount
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(ShippingCount $shippingCount);
}
