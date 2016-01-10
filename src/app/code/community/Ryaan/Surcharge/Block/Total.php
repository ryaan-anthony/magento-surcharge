<?php

class Ryaan_Surcharge_Block_Total extends Mage_Core_Block_Template
{
    /**
     * Add this total to parent
     */
    public function initTotals()
    {
        /** @var Mage_Sales_Block_Order_Totals $parent */
        $parent = $this->getParentBlock();

        $order = $parent->getOrder();

        $surcharge = $order->getSurcharge();

        if ($surcharge > 0) {
            $total = new Varien_Object([
                'code' => 'surcharge',
                'field' => 'surcharge',
                'value' => $surcharge,
                'label' => $this->__('Surcharge')
            ]);
            $parent->addTotalBefore($total, 'shipping');
        }

        return $this;
    }

}
