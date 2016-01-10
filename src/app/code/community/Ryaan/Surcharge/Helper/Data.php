<?php

class Ryaan_Surcharge_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Get surcharge totals from configured attributes
     * @param Mage_Catalog_Model_Product
     * @return float|int
     */
    protected function getProductSurcharge(Mage_Catalog_Model_Product $product)
    {
        $amount = 0;

        $attributes = $this->getAttributes();

        foreach($attributes as $attribute){
            $surcharge = (float)$product->getData($attribute);
            $amount += $surcharge;
        }

        return $amount;
    }

    public function isEnabled()
    {
        return Mage::getStoreConfig('sales/surcharge/enabled');
    }

    public function getLabel()
    {
        return Mage::getStoreConfig('sales/surcharge/label');
    }

	public function getAmount()
	{
		return Mage::getStoreConfig('sales/surcharge/amount');
	}

	public function canApplyAdditional()
	{
		return Mage::getStoreConfig('sales/surcharge/additional');
	}

	public function getAttributes()
	{
		return explode(',', Mage::getStoreConfig('sales/surcharge/attributes'));
	}
	
}
