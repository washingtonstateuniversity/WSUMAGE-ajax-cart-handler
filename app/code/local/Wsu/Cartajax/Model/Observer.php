<?php
class Wsu_Cartajax_Model_Observer{


	public function catalogProductLoadAfter(Varien_Event_Observer $observer) {
		// set the additional options on the product
		$action = Mage::app()->getFrontController()->getAction();
		if ($action->getFullActionName() == 'checkout_cart_add'){
			// assuming you are posting your custom form values in an array called extra_options...
			if ($options = $action->getRequest()->getParam('extra_options')){
				$product = $observer->getProduct();
	
				// add to the additional options array
				$additionalOptions = array();
				if ($additionalOption = $product->getCustomOption('additional_options')){
					$additionalOptions = (array) unserialize($additionalOption->getValue());
				}
				foreach ($options as $key => $value){
					$additionalOptions[] = array(
						'label' => $key,
						'value' => $value,
					);
				}
				// add the additional options array with the option code additional_options
				$observer->getProduct()->addCustomOption('additional_options', serialize($additionalOptions));
			}
		}
	}

	public function salesConvertQuoteItemToOrderItem(Varien_Event_Observer $observer) {
		$quoteItem = $observer->getItem();
		if ($additionalOptions = $quoteItem->getOptionByCode('additional_options')) {
			$orderItem = $observer->getOrderItem();
			$options = $orderItem->getProductOptions();
			$options['additional_options'] = unserialize($additionalOptions->getValue());
			$orderItem->setProductOptions($options);
		}
	}
	public function checkoutCartProductAddAfter(Varien_Event_Observer $observer) {
		$action = Mage::app()->getFrontController()->getAction();
		if ($action->getFullActionName() == 'sales_order_reorder') {
			$item = $observer->getQuoteItem();
			$buyInfo = $item->getBuyRequest();
			if ($options = $buyInfo->getExtraOptions()) {
				$additionalOptions = array();
				if ($additionalOption = $item->getOptionByCode('additional_options')) {
					$additionalOptions = (array) unserialize($additionalOption->getValue());
				}
				foreach ($options as $key => $value) {
					$additionalOptions[] = array(
						'label' => $key,
						'value' => $value,
					);
				}
				$item->addOption(array(
					'code' => 'additional_options',
					'value' => serialize($additionalOptions)
				));
			}
		}
	}

}
