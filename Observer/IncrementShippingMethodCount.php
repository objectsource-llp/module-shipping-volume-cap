<?php
declare(strict_types=1);


namespace Objectsource\ShippingVolumeCap\Observer;

use \Magento\Framework\Event\Observer;
use \Magento\Framework\Event\ObserverInterface;
use Objectsource\ShippingVolumeCap\Api\ShippingCountRepositoryInterface;

class IncrementShippingMethodCount implements ObserverInterface
{
    /**
     * @var ShippingCountRepositoryInterface
     */
    protected $shippingCountRepository;

    /**
     * IncrementShippingMethodCount constructor.
     * @param ShippingCountRepositoryInterface $shippingCountRepository
     */
    public function __construct(
        ShippingCountRepositoryInterface $shippingCountRepository
    ) {
        $this->shippingCountRepository = $shippingCountRepository;
    }

    /**
     * @param Observer $observer
     * @return $this
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $observer->getOrder();
        $shippingMethod = $order->getShippingMethod();

        $shippingCount = $this->shippingCountRepository->getCountByMethodCode($shippingMethod);
        $currentCount = $shippingCount->getCount();

        if (!$currentCount) {
            //Count doesn't yet exist.
            $shippingCount->setMethodCode($shippingMethod);
            $shippingCount->setCount(1);
        } else {
            $shippingCount->setCount($currentCount + 1);
        }

        $this->shippingCountRepository->save($shippingCount);

        return $this;
    }
}
