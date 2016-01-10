<?php

class Ryaan_Surcharge_Helper_Quote extends Ryaan_Surcharge_Helper_Data
{
    /**
     * Get the surcharge amount from quote
     * @param Mage_Sales_Model_Quote
     * @return int|mixed
     */
	public function getSurcharge(Mage_Sales_Model_Quote $quote)
	{		
		$amount = 0;

		if($this->isEnabled()){
            $amount = $this->getAmount();
            $amount += $this->canApplyAdditional() ? $this->getAdditional($quote) : 0;
		}

		return $amount;
	}

    /**
     * @param Mage_Sales_Model_Quote
     * @return float|int
     */
	protected function getAdditional(Mage_Sales_Model_Quote $quote)
	{
		$amount = 0;

		foreach($quote->getAllItems() as $item){
			$qty = $this->getItemQty($item);
			$product = $this->loadProduct($item);
            $surcharge = $this->getProductSurcharge($product);
			$amount += ($surcharge * $qty);
		}

		return $amount;
	}

    /**
     * @param Mage_Sales_Model_Quote_Item
     * @return int
     */
	protected function getItemQty(Mage_Sales_Model_Quote_Item $item)
    {
        return $item->getQty() ? : ($item->getQtyOrdered() ? $item->getQtyOrdered() : 1);
    }

    /**
     * @param Mage_Sales_Model_Quote_Item
     * @return Mage_Catalog_Model_Product
     */
    protected function loadProduct(Mage_Sales_Model_Quote_Item $item)
    {
        $product = $this->getProductModel();

        $product->load($item->getProductId());

        return $product;
    }

    /**
     * @return Mage_Catalog_Model_Product
     */
    protected function getProductModel()
    {
        return Mage::getModel('catalog/product');
    }
	
}
