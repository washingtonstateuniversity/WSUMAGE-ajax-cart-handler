<?php
class Wsu_Cartajax_Model_Observer{


//public function setDiscount($observer){
//	$quote=$observer->getEvent()->getQuote();
//	$quoteid=$quote->getId();
//	$discountAmount=10;
//	if($quoteid) {
//	
//		foreach ($quote->getAllItems() as $_item){
//			// Array to hold the item's options
//			$result = array();
//			// Load the configured product options
//			$product = $_item->getProduct();
//			$options = $product->getTypeInstance(true)->getOrderOptions($product);
//			$_options = $product->getOptionList();
//			$itemdiscountAmount=0;
//			if (isset($info['options'])){
//				foreach($info['options'] as $key=>$value){
//					foreach($_options as $optionKey => $option) {
//						$sku=$option->getSku();
//						if($key == $option->getId() && $sku == "child_6_12"){
//							$itemdiscountAmount+=10;
//						}
//						if($key == $option->getId() && $sku == "under_5"){
//							$itemdiscountAmount+=25;
//						}
//					}  				  
//				}
//			}
//			$_item->setDiscountAmount($itemdiscountAmount);
//			$_item->setBaseDiscountAmount($itemdiscountAmount)->save();
//		}	
//			
//		if($discountAmount>0) {
//			$total=$quote->getBaseSubtotal();
//			$quote->setSubtotal(0);
//			$quote->setBaseSubtotal(0);
//			
//			$quote->setSubtotalWithDiscount(0);
//			$quote->setBaseSubtotalWithDiscount(0);
//			
//			$quote->setGrandTotal(0);
//			$quote->setBaseGrandTotal(0);
//			
//			
//			$canAddItems = $quote->isVirtual()? ('billing') : ('shipping'); 
//			foreach ($quote->getAllAddresses() as $address) {
//			
//				$address->setSubtotal(0);
//				$address->setBaseSubtotal(0);
//				
//				$address->setGrandTotal(0);
//				$address->setBaseGrandTotal(0);
//				
//				$address->collectTotals();
//				
//				$quote->setSubtotal((float) $quote->getSubtotal() + $address->getSubtotal());
//				$quote->setBaseSubtotal((float) $quote->getBaseSubtotal() + $address->getBaseSubtotal());
//				
//				$quote->setSubtotalWithDiscount(
//					(float) $quote->getSubtotalWithDiscount() + $address->getSubtotalWithDiscount()
//				);
//				$quote->setBaseSubtotalWithDiscount(
//					(float) $quote->getBaseSubtotalWithDiscount() + $address->getBaseSubtotalWithDiscount()
//				);
//				
//				$quote->setGrandTotal((float) $quote->getGrandTotal() + $address->getGrandTotal());
//				$quote->setBaseGrandTotal((float) $quote->getBaseGrandTotal() + $address->getBaseGrandTotal());
//				
//				$quote ->save(); 
//				
//				$quote->setGrandTotal($quote->getBaseSubtotal()-$discountAmount)
//				->setBaseGrandTotal($quote->getBaseSubtotal()-$discountAmount)
//				->setSubtotalWithDiscount($quote->getBaseSubtotal()-$discountAmount)
//				->setBaseSubtotalWithDiscount($quote->getBaseSubtotal()-$discountAmount)
//				->save(); 
//				
//				
//				if($address->getAddressType()==$canAddItems) {
//					//echo $address->setDiscountAmount; exit;
//					$address->setSubtotalWithDiscount((float) $address->getSubtotalWithDiscount()-$discountAmount);
//					$address->setGrandTotal((float) $address->getGrandTotal()-$discountAmount);
//					$address->setBaseSubtotalWithDiscount((float) $address->getBaseSubtotalWithDiscount()-$discountAmount);
//					$address->setBaseGrandTotal((float) $address->getBaseGrandTotal()-$discountAmount);
//					if($address->getDiscountDescription()){
//						$address->setDiscountAmount(-($address->getDiscountAmount()-$discountAmount));
//						$address->setDiscountDescription($address->getDiscountDescription().', Custom Discount');
//						$address->setBaseDiscountAmount(-($address->getBaseDiscountAmount()-$discountAmount));
//					}else {
//						$address->setDiscountAmount(-($discountAmount));
//						$address->setDiscountDescription('Custom Discount');
//						$address->setBaseDiscountAmount(-($discountAmount));
//					}
//					$address->save();
//				}//end: if
//			} //end: foreach
//			//echo $quote->getGrandTotal();
//			
//			/*foreach($quote->getAllItems() as $item){
//				//We apply discount amount based on the ratio between the GrandTotal and the RowTotal
//				$rat=$item->getPriceInclTax()/$total;
//				$ratdisc=$discountAmount*$rat;
//				$item->setDiscountAmount(($item->getDiscountAmount()+$ratdisc) * $item->getQty());
//				$item->setBaseDiscountAmount(($item->getBaseDiscountAmount()+$ratdisc) * $item->getQty())->save();
//			}*/
//		}
//	}
//} 
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
///**
// * @param Varien_Event_Observer $observer
// */
//public function applyDiscount(Varien_Event_Observer $observer) {
//    /* @var $item Mage_Sales_Model_Quote_Item */
//    $item = $observer->getQuoteItem();
//    if ($item->getParentItem()) {
//        $item = $item->getParentItem();
//    }
//
//	$cusOps = $product->getOptions();
//							 
//	$optStr = "";
//	
//	//var_dump($attVal);
//	// loop through the options
//
//	foreach($attVal as $optionKey => $option) {
//		$field=$option->getData();
//		if($field['type']=="field"){
//			$sku=$option->getSku();
//			if($sku="s"){
//				
//			}
//		}else{
//			
//		}
//	}
//
//
//
//
//
//
//
//    // Discounted 25% off
//    $percentDiscount = 0.25; 
//
//    // This makes sure the discount isn't applied over and over when refreshing
//    $specialPrice = $item->getOriginalPrice() - ($item->getOriginalPrice() * $percentDiscount);
//
//    // Make sure we don't have a negative
//    if ($specialPrice > 0) {
//        $item->setCustomPrice($specialPrice);
//        $item->setOriginalCustomPrice($specialPrice);
//        $item->getProduct()->setIsSuperMode(true);
//    }
//}
///**
// * @param Varien_Event_Observer $observer
// */
//public function applyDiscounts(Varien_Event_Observer $observer)
//{
//    foreach ($observer->getCart()->getQuote()->getAllVisibleItems() as $item /* @var $item Mage_Sales_Model_Quote_Item */) {
//         if ($item->getParentItem()) {
//             $item = $item->getParentItem();
//         }
///*
//         // Discounted 25% off
//         $percentDiscount = 0.25; 
//
//         // This makes sure the discount isn't applied over and over when refreshing
//         $specialPrice = $item->getOriginalPrice() - ($item->getOriginalPrice() * $percentDiscount);
//
//         // Make sure we don't have a negative
//         if ($specialPrice > 0) {
//             $item->setCustomPrice($specialPrice);
//             $item->setOriginalCustomPrice($specialPrice);
//             $item->getProduct()->setIsSuperMode(true);
//         }*/
//    }
//}










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
