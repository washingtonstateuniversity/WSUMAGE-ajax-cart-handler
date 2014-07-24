<?php
class Wsu_CartAjax_Helper_Data extends Mage_Core_Helper_Abstract {
	
	
	public function setCustomOption($productId, $title, array $optionData, array $values = array()) {
		Mage::app()->getStore()->setId(Mage_Core_Model_App::ADMIN_STORE_ID);
		if (!$product = Mage::getModel('catalog/product')->load($productId)) {
			throw new Exception('Can not find product: ' . $productId);
		}
 
		$defaultData = array(
			'type'			=> 'field',
			'is_require'	=> 0,
			'price'			=> 0,
			'price_type'	=> 'fixed',
		);
 
		$data = array_merge($defaultData, $optionData, array(
													'product_id' 	=> (int)$productId,
													'title'			=> $title,
													'values'		=> $values,
												));
 
		$product->setHasOptions(1)->save();										
		$option = Mage::getModel('catalog/product_option')->setData($data)->setProduct($product)->save();
 
		return $option;
	}

	
	
	
}
