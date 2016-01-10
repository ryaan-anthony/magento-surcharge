<?php 

class Ryaan_Surcharge_Model_Total_Quote extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    /**
     * @var Ryaan_Surcharge_Helper_Quote
     */
    protected $helper;

    /**
     * Initialize the class
     * @param array
     */
    public function __construct(array $args = [])
    {
        list($this->helper) = $this->checkTypes(
            $this->nullCoalesce($args, 'helper', Mage::helper('surcharge/quote'))
        );
    }

    /**
     * Return the value at field in array if it exists. Otherwise, use the
     * default value.
     * @param  array
     * @param  string|int
     * @param  mixed
     * @return mixed
     */
    protected function nullCoalesce(array $arr, $field, $default)
    {
        return isset($arr[$field]) ? $arr[$field] : $default;
    }

    /**
     * Validate constructor parameters.
     * @param Ryaan_Surcharge_Helper_Quote
     * @return array
     */
    protected function checkTypes(
        Ryaan_Surcharge_Helper_Quote $helper
    ) {
        return func_get_args();
    }

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);
		
        if (($address->getAddressType() == 'billing')) {
            return $this;
        }

        $baseSurcharge = $this->helper->getSurcharge($address->getQuote());

		if($baseSurcharge){
            $surcharge = Mage::app()->getStore()->convertPrice($baseSurcharge);
            $address->setSurcharge($surcharge);
            $address->setBaseSurcharge($baseSurcharge);
			$this->_addAmount($surcharge);
			$this->_addBaseAmount($baseSurcharge);
		}

        return $this;
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        if (($address->getAddressType() == 'billing')) {

            $surcharge = $this->helper->getSurcharge($address->getQuote());

            if ($surcharge) {
                $address->addTotal([
                    'code'  => 'surcharge',
                    'title' => $this->helper->getLabel(),
                    'value' => $surcharge
                ]);
            }
        }

        return $this;
    }
	
}
