<?php
declare(strict_types=1);

namespace Objectsource\ShippingVolumeCap\Plugin;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Quote\Model\Quote\Address\RateResult\Error;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\ResourceModel\Order\Collection as OrderCollection;
use Magento\Shipping\Model\Rate\Result;
use Magento\Store\Model\ScopeInterface;
use Objectsource\ShippingVolumeCap\Api\ShippingCountRepositoryInterface;
use ShipperHQ\Shipper\Model\Carrier\Shipper;

class ApplyVolumeCap
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var SerializerInterface
     */
    protected $serializer;
    /**
     * @var ShippingCountRepositoryInterface
     */
    protected $shippingCountRepository;

    /**
     * ApplyVolumeCap constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param SerializerInterface $serializer
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        SerializerInterface $serializer,
        ShippingCountRepositoryInterface $shippingCountRepository
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
        $this->shippingCountRepository = $shippingCountRepository;
    }

    /**
     * @param Shipper $subject
     * @param $result
     * @return bool|Result|Error
     */
    public function afterCollectRates(Shipper $subject, $result)
    {
        if (! $this->scopeConfig->isSetFlag('volume_cap/config/enable', ScopeInterface::SCOPE_WEBSITE)) {
            return $result;
        }

        if (! $result instanceof Result) {
            return $result;
        }

        $methodCaps = $this->serializer->unserialize(
            $this->scopeConfig->getValue('volume_cap/config/method_caps', ScopeInterface::SCOPE_WEBSITE)
        );

        $ratesToRemove = [];

        foreach ($methodCaps as $methodCap) {
            $shippingMethodCode = $this->getShippingMethodCode($methodCap);
            $currentCount = $this->getCurrentCount($shippingMethodCode);

            if ($currentCount >= $methodCap['volume_cap']) {
                //Shipping method is to be excluded from $results array.
                $ratesToRemove[] = $shippingMethodCode;
            }
        }

        if (!empty($ratesToRemove)) {
            $this->removeShippingRates($result, $ratesToRemove);
        }

        return $result;
    }

    /**
     * @param string $methodCode
     * @return int
     */
    protected function getCurrentCount(string $methodCode)
    {
        $countModel = $this->shippingCountRepository->getCountByMethodCode($methodCode);

        if ($countModel->getCount() > 0) {
            return $countModel->getCount();
        }

        return 0;
    }

    /**
     * @param array $methodCap
     * @return string
     */
    protected function getShippingMethodCode(array $methodCap)
    {
        return 'shq' . $methodCap['carrier_code'] . '_' . $methodCap['method_code'];
    }

    /**
     * @param Result $result
     * @param array $ratesToRemove
     * @return Result
     */
    protected function removeShippingRates(Result $result, array $ratesToRemove)
    {
        $rates = $result->getAllRates();
        $result->reset();

        foreach ($rates as $key => $rate) {
            $shipperCode = $rate->getData('carrier') . '_' . $rate->getData('method');

            $search = array_search($shipperCode, $ratesToRemove);
            if ($search === false) {
                $result->append($rate);
            }
        }

        return $result;
    }
}
