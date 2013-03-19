<?php 

class Ip_Surcharge_Model_Total_Quote extends Mage_Sales_Model_Quote_Address_Total_Abstract
{

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);
		
        if (($address->getAddressType() == 'billing')) {
            return $this;
        }
		
		if($surcharge = Mage::helper('surcharge')->getSurcharge($address->getQuote())){
			$this->_addAmount(Mage::app()->getStore()->convertPrice($surcharge));
			$this->_addBaseAmount($surcharge);
		}

        return $this;
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        if (($address->getAddressType() == 'billing')) {
			
            if ($surcharge = Mage::helper('surcharge')->getSurcharge($address->getQuote())) {
                $address->addTotal(array(
                    'code'  => 'surcharge',
                    'title' => Mage::helper('surcharge')->getLabel(),
                    'value' => $surcharge
                ));
            }
        }

        return $this;
    }
	
}