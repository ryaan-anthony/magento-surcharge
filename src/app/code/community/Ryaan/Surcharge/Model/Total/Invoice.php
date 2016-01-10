<?php 

class Ryaan_Surcharge_Model_Total_Invoice extends Mage_Sales_Model_Order_Invoice_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Invoice $invoice)
    {
        $order = $invoice->getOrder();
        $surcharge = $order->getBaseSurcharge();
        $baseSurcharge = $order->getBaseSurcharge();

		if($baseSurcharge){
            $invoice->setGrandTotal($invoice->getGrandTotal() + $surcharge);
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $baseSurcharge);
		}

        return $this;
    }
	
}
