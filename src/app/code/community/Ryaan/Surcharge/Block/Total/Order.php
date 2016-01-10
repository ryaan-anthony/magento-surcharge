<?php

class Ryaan_Surcharge_Block_Total_Order extends Mage_Core_Block_Template
{

//    /** @var Varien_Object */
//    protected $source;
//
//    /**
//     * Get data (totals) source model
//     *
//     * @return Varien_Object
//     */
//    public function getSource()
//    {
//        return $this->source;
//    }

    /**
     * Add this total to parent
     */
    public function initTotals()
    {
        /** @var Mage_Sales_Block_Order_Totals $parent */
        $parent = $this->getParentBlock();

        $order = $parent->getOrder();

        $this->source  = $parent->getSource();

        $surcharge = $order->getSurcharge();

        if ($surcharge > 0) {

            $total = new Varien_Object(array(
                'code' => 'surcharge',
                'field' => 'surcharge',
                'value' => $surcharge,
                'label' => $this->__('Surcharge')
            ));

            $parent->addTotalBefore($total, 'shipping');

        }

        return $this;
    }

}
