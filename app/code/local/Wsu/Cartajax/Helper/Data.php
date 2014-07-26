<?php
class Wsu_Cartajax_Helper_Data extends Mage_Core_Helper_Abstract {
	
	public function productHasCustomOption($productId, $title) {
		Mage::app()->getStore()->setId(Mage_Core_Model_App::ADMIN_STORE_ID);
		if (!$product = Mage::getModel('catalog/product')->load($productId)) {
			throw new Exception('Can not find product: ' . $productId);
		}
 		if($product->hasOptions()) {
			$options = $Product->getOptions();
	        foreach ($options as  $option){
				if($option->getTitle()==$title){
					return $option;
					break;	
				}
			}
		}
		return false;
		
	}
		
	public function setCustomOption($productId, $title, $optionData= array(), $values = array()) {
		Mage::app()->getStore()->setId(Mage_Core_Model_App::ADMIN_STORE_ID);
		if (!$product = Mage::getModel('catalog/product')->load($productId)) {
			throw new Exception('Can not find product: ' . $productId);
		}
		$has_op = $this->productHasCustomOption($productId, $title);
 		if($has_op===false) {
			$defaultData = array(
				'product_id' => (int)$productId,
				'type'			=> 'field',
				'title'			=> $title,
				'is_require'	=> 0,
				'price'			=> 0,
				'price_type'	=> 'fixed',
			);
			$data = array_merge($defaultData, $optionData);
			$typeOpArray=array();
			if($data['type']=='field'){
				if($values!==false){
					$typeOpArray=array_merge($typeOpArray,$values);	
				}
			}else{
				$typeOpArray['values']=$values;	
			}
			$co_data = array_merge($data, $typeOpArray);
			$product->setHasOptions(1)->save();										
			$option = Mage::getModel('catalog/product_option')->setData($co_data)->setProduct($product)->save();
			return $option;
		}
		return $has_op;
	}

	
	
	
}
