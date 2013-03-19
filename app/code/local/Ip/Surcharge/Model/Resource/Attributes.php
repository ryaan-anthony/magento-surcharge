<?php
class Ip_Surcharge_Model_Resource_Attributes
{
	public function toOptionArray()
	{
		$attrs = array();
		$attributes = Mage::getResourceModel('catalog/product_attribute_collection')
			->addVisibleFilter();		
		foreach ($attributes as $attribute){
			if($attribute->getBackendType() == 'decimal'){
				$attrs[] = array(
					'label'   => $attribute->getFrontendLabel(),
					'value' => $attribute->getAttributeCode()
				);
			}			
		}		
		return $attrs;
	}
}