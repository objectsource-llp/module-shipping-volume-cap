<?php
declare(strict_types=1);

namespace Objectsource\ShippingVolumeCap\Model;

use Objectsource\ShippingVolumeCap\Api\Data\ShippingCountInterface;
use Objectsource\ShippingVolumeCap\Api\ShippingCountRepositoryInterface;
use Objectsource\ShippingVolumeCap\Model\ResourceModel\ShippingCount as ShippingCountResource;
use Objectsource\ShippingVolumeCap\Model\ResourceModel\ShippingCount\CollectionFactory;

class ShippingCountRepository implements ShippingCountRepositoryInterface
{
    /**
     * @var ShippingCountFactory
     */
    protected $shippingCountFactory;
    /**
     * @var ShippingCountResource
     */
    protected $shippingCountResource;

    /**
     * ShippingCountRepository constructor.
     * @param ShippingCountFactory $shippingCountFactory
     * @param ShippingCountResource $shippingCountResource
     */
    public function __construct(
        ShippingCountFactory $shippingCountFactory,
        ShippingCountResource $shippingCountResource
    ) {
        $this->shippingCountFactory = $shippingCountFactory;
        $this->shippingCountResource = $shippingCountResource;
    }

    /**
     * @inheritDoc
     */
    public function getCountByMethodCode(string $methodCode): ShippingCount
    {
        $countModel = $this->shippingCountFactory->create();
        $this->shippingCountResource->load($countModel, $methodCode, 'method_code');

        return $countModel;
    }

    /**
     * @inheritDoc
     */
    public function save(ShippingCount $shippingCount)
    {
        $this->shippingCountResource->save($shippingCount);
    }
}
