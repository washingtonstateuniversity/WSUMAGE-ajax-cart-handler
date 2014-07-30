<?php
require_once 'Mage/Checkout/controllers/CartController.php';
class Wsu_Cartajax_CartajaxController extends Mage_Checkout_CartController {
	public function addAction() {

		$params = $this->getRequest()->getParams();
		
		if($params['cartAjaxUsed'] == 1){
			$response = array();
			$response['params_to_use'] = $params;
			try {
				$cart   = $this->_getCart();
					
				/** @var \Mage_Catalog_Model_Product $product_model */
				$product_model = Mage::getModel('catalog/product');
				
				/** @var \Mage_Checkout_Model_Cart $cart */
				$cart = Mage::getSingleton('checkout/cart');
				$cart->init();
				//$cart->truncate();

				
				$products = $params['products'];
	
				foreach($products as $p_id){

					$product = $product_model->load($p_id);
					
					$product_params = array(
						'product' => $p_id,
						'qty' => $params['product'][$p_id]['qty'],
						'options'=>array()
						/*'options' => array(
							34 => "value",
							35 => "other value",
							53 => "some other value"
						)*/
					);
					
					if ($product->getTypeId() != 'configurable') {
						// add to the additional options array
						$additionalOptions = array();
						if ($additionalOption = $product->getCustomOption('additional_options')){
							$additionalOptions = (array) unserialize($additionalOption->getValue());
						}
						foreach($params['product'][$p_id]['options'] as $named=>$value){
							if($named!=="{%d%}" && !is_array($value)){
									$additionalOptions[] = array(
										'label' => $named,
										'value' => $value,
									);
							}else{
								foreach ($value as $key => $subvalue){
									if($key!=="{%d%}" && !is_array($subvalue)){
										$additionalOptions[] = array(
											'label' => $key,
											'value' => $subvalue,
										);
									}else{
										foreach ($subvalue as $subkey => $_subvalue){
											if($subkey!=="{%d%}" && !is_array($_subvalue)){
												$additionalOptions[] = array(
													'label' => $key."_".$subkey,
													'value' => $_subvalue,
												);
											}
										}	
									}
								}								
								/*
								$options = 	array( 'type' => 'field', 'price' => 0, 'price_type' => 'fixed' );
								$values = false;
								try {
									$option = Mage::helper('cartajax')->setCustomOption($p_id, $named, $options, $values);
									$product_params['options'][$option->getId()] = $value;
								} catch (Exception $e) {
									echo $e->getMessage();
								}*/
							}
						}
					}		
					
					
					
					
					// add the additional options array with the option code additional_options
					$product_params['options']['additional_options']=serialize($additionalOptions);
					
					
					
					
					

					
					$product_params['super_attribute'] = array("foo" =>"bar");
					
					if (isset($product_params['qty'])) {
						$filter = new Zend_Filter_LocalizedToNormalized(
							array('locale' => Mage::app()->getLocale()->getLocaleCode())
						);
						$product_params['qty'] = $filter->filter($product_params['qty']);
					}
	
					//$product = $this->_initProduct();
					//$related = $this->getRequest()->getParam('related_product');
					
					$cart->addProduct($p_id, $product_params);
					if (!empty($related)) {
						//$cart->addProductsByIds(explode(',', $related));
					}
	
					/**
					 * @todo remove wishlist observer processAddToCart
					 
					Mage::dispatchEvent('checkout_cart_add_product_complete',
						array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
					);*/
				}
				$cart->save();
				$this->_getSession()->setCartWasUpdated(true);
			
				/*ob_start();
				$quote = Mage::getSingleton('checkout/session')->getQuote();
				$cartItems = $quote->getAllVisibleItems();
				var_dump($cartItems);
				$a=ob_get_contents();
				ob_end_clean();
	
				$response['var_dump']=$a;
	
				$this->getResponse()->setBody($a);
				return;*/
			
			
			


				if (!$cart->getQuote()->getHasError()){
					$message = $this->__('%s was added to your shopping cart.', Mage::helper('core')->htmlEscape($product->getName()));
					$response['status'] = 'SUCCESS';
					$response['message'] = $message;
					//New Code Here
					/*$this->loadLayout();
					$toplink = $this->getLayout()->getBlock('top.links')->toHtml();
					$sidebar_block = $this->getLayout()->getBlock('cart_sidebar');
					Mage::register('referrer_url', $this->_getRefererUrl());
					$sidebar = $sidebar_block->toHtml();
					$response['toplink'] = $toplink;
					$response['sidebar'] = $sidebar;*/
					$response['checkout'] = $checkout_link = Mage::helper('checkout/url')->getCheckoutUrl();
				}
			} catch (Mage_Core_Exception $e) {
				$msg = "";
				if ($this->_getSession()->getUseNotice(true)) {
					$msg = $e->getMessage();
				} else {
					$messages = array_unique(explode("\n", $e->getMessage()));
					foreach ($messages as $message) {
						$msg .= $message.'<br/>';
					}
				}

				$response['status'] = 'ERROR';
				$response['message'] = $msg;
			} catch (Exception $e) {
				$response['status'] = 'ERROR';
				$response['message'] = $this->__('Cannot add the item to shopping cart. err:').$e;
				Mage::logException($e);
			}
			//var_dump($response);
			//return;
			$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
			return;
		}else{
			return parent::addAction();
		}
	}
	
	


	function saveProductOption($product) {
	
		$store = Mage::app()->getStore()->getId();
		$opt = Mage::getModel('catalog/product_option');
		$opt->setProduct($product);
		$option = array(
			'is_delete' => 0,
			'is_require' => false,
			'previous_group' => 'text',
			'title' => 'Delivery Date',
			'type' => 'field',
			'price_type' => 'fixed',
			'price' => '0.0000'
		);
		$opt->addOption($option);
		$opt->saveOptions();
		Mage::app()->setCurrentStore(Mage::getModel('core/store')->load(Mage_Core_Model_App::ADMIN_STORE_ID));
		$product->setHasOptions(1);
		$product->save();
	
		$options = $product->getOptions();
		if ($options) {
			foreach ($options as $option) {
				if ($option->getTitle() == 'Delivery Date') {
					$optionID = $option->getOptionId();
				}
			}
		}
		Mage::app()->setCurrentStore(Mage::getModel('core/store')->load($store));
		return $optionID;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function optionsAction(){
		$productId = $this->getRequest()->getParam('product_id');
		// Prepare helper and params
		$viewHelper = Mage::helper('catalog/product_view');

		$params = new Varien_Object();
		$params->setCategoryId(false);
		$params->setSpecifyOptions(false);

		// Render page
		try {
			$viewHelper->prepareAndRender($productId, $this, $params);
		} catch (Exception $e) {
			if ($e->getCode() == $viewHelper->ERR_NO_PRODUCT_LOADED) {
				if (isset($_GET['store'])  && !$this->getResponse()->isRedirect()) {
					$this->_redirect('');
				} elseif (!$this->getResponse()->isRedirect()) {
					$this->_forward('noRoute');
				}
			} else {
				Mage::logException($e);
				$this->_forward('noRoute');
			}
		}
	}
}
