<?php

namespace Objectsource\ShippingVolumeCap\Model;

use \Magento\Framework\Model\AbstractModel;
use \Magento\Framework\DataObject\IdentityInterface;
use Objectsource\ShippingVolumeCap\Api\Data\ShippingCountInterface;
use Objectsource\ShippingVolumeCap\Model\ResourceModel\ShippingCount\Collection;

/**
 * @method ResourceModel\ShippingCount getResource()
 * @method Collection getCollection()
 */
class ShippingCount extends AbstractModel implements ShippingCountInterface,
    IdentityInterface
{
    const CACHE_TAG = 'objectsource_shippingvolumecap_shippingcount';
    protected $_cacheTag = 'objectsource_shippingvolumecap_shippingcount';
    protected $_eventPrefix = 'objectsource_shippingvolumecap_shippingcount';

    protected function _construct()
    {
        $this->_init(ResourceModel\ShippingCount::class);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return string|null
     */
    public function getMethodCode(): ?string
    {
        return $this->getData('method_code');
    }

    /**
     * @param string $methodCode
     */
    public function setMethodCode(string $methodCode): void
    {
        $this->setData('method_code', $methodCode);
    }

    /**
     * @return int|null
     */
    public function getCount(): ?int
    {
        return $this->getData('count');
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->setData('count', $count);
    }
}
