<?php
class Wsu_CartAjax_Block_Ajax extends Mage_Core_Block_Template {
	public function _prepareLayout() {
		return parent::_prepareLayout();
    }
    
     public function getCartAjax() { 
        if (!$this->hasData('cartajax')) {
            $this->setData('cartajax', Mage::registry('cartajax'));
        }
        return $this->getData('cartajax');
    }
}
