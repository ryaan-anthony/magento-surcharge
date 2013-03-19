<?php

class Ip_Surcharge_Helper_Data extends Mage_Core_Helper_Abstract
{
	
	public function getSurcharge($quote)
	{		
		$amount = 0;
		if($this->isEnabled()){
			$payment = $quote->getPayment();
			if($payment && in_array($payment->getMethodInstance()->getCode(), $this->getMethods())){
				$flat = $this->getFlat();
				if($this->skipFreeShipping() && $this->isFreeShipping($quote)){
					$flat = 0;
				}
				$amount = $this->getAdditional($quote) + $flat;
			} elseif($this->applyToAll()){
				$amount = $this->getAdditional($quote);
			}
		}
		return $amount;
	
	}
	
	public function isFreeShipping($quote)
	{
		return $quote->getShippingAddress()->getShippingMethod() == "freeshipping_freeshipping";
	}
	
	public function getAdditional($quote)
	{
		$amount = 0;
		$attributes = $this->getAttributes();
		foreach($quote->getAllItems() as $item){
			$qty = ($item->getQty() ? $item->getQty() : ($item->getQtyOrdered() ? $item->getQtyOrdered() : 1));
			$product = Mage::getModel("catalog/product")->load($item->getProductId());
			foreach($attributes as $attribute){
				$surcharge = (float)$product->getData($attribute);
				$amount += ($surcharge * $qty);
			}
		}
		return $amount;
	}

	public function skipFreeShipping()
	{
		return Mage::getStoreConfig('ip_section/ip_surcharge/ip_surcharge_freeship');
	}
	
	public function getFlat()
	{
		return Mage::getStoreConfig('ip_section/ip_surcharge/ip_surcharge_amt');
	}

	public function applyToAll()
	{
		return Mage::getStoreConfig('ip_section/ip_surcharge/ip_surcharge_additional');
	}

	public function getLabel()
	{
		return Mage::getStoreConfig('ip_section/ip_surcharge/ip_surcharge_label');
	}
	
	public function isEnabled()
	{	
		return Mage::getStoreConfig('ip_section/ip_surcharge/ip_surcharge_enabled');
	}
	
	public function getMethods()
	{
		return explode(',', Mage::getStoreConfig('ip_section/ip_surcharge/ip_surcharge_method'));	
	}
	
	public function getAttributes()
	{
		return explode(',', Mage::getStoreConfig('ip_section/ip_surcharge/ip_surcharge_attribute'));	
	}
	
}

?>