<?php
declare(strict_types=1);

namespace Objectsource\ShippingVolumeCap\Cron;

use Magento\Framework\App\ResourceConnection;
use Objectsource\ShippingVolumeCap\Model\ResourceModel\ShippingCount\Collection as ShippingCountCollection;
use \Psr\Log\LoggerInterface;

class ResetShippingCounter
{
    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    /**
     * @var ShippingCountCollection
     */
    protected $shippingCountCollection;

    /**
     * ResetShippingCounter constructor.
     * @param LoggerInterface $logger
     * @param ShippingCountCollection $shippingCountCollection
     */
    public function __construct(
        LoggerInterface $logger,
        ShippingCountCollection $shippingCountCollection
    ) {
        $this->logger = $logger;
        $this->shippingCountCollection = $shippingCountCollection;
    }

    public function execute()
    {
        $this->logger->info(__('Shipping method volume count reset.'));
        $this->shippingCountCollection->setDataToAll('count', 0)->save();
    }
}
