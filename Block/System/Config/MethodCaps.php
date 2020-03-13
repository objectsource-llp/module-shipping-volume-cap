<?php
declare(strict_types=1);

namespace Objectsource\ShippingVolumeCap\Block\System\Config;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class Ranges
 */
class MethodCaps extends AbstractFieldArray
{
    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $this->addColumn('carrier_code', ['label' => __('Carrier Code'), 'class' => 'required-entry']);
        $this->addColumn('method_code', ['label' => __('Method Code'), 'class' => 'required-entry']);
        $this->addColumn('volume_cap', ['label' => __('Volume Cap'), 'class' => 'required-entry validate-number']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }
}
