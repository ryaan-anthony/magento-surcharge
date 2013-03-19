<?php
class Ip_Surcharge_Model_Resource_Methods
{
	public function toOptionArray()
	{
		 $payments = Mage::getSingleton('payment/config')->getActiveMethods();
		 $methods = array();
		 foreach ($payments as $paymentCode=>$paymentModel) {
			  $paymentTitle = Mage::getStoreConfig('payment/'.$paymentCode.'/title');
			  $methods[$paymentCode] = array(
				  'label'   => $paymentTitle,
				  'value' => $paymentCode,
			  );
		  }
		  return $methods;
	}
}