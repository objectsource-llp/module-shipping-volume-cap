<?php

namespace Objectsource\ShippingVolumeCap\Api\Data;

interface ShippingCountInterface
{
    /**
     * @param int $count
     */
    public function setCount(int $count): void;

    /**
     * @return string|null
     */
    public function getMethodCode(): ?string;

    /**
     * @param string $methodCode
     */
    public function setMethodCode(string $methodCode): void;

    /**
     * @return int|null
     */
    public function getCount(): ?int;
}
