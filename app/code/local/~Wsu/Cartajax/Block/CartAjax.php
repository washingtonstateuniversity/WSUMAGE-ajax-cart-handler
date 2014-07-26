<?php
class Wsu_Cartajax_Block_Cartajax extends Mage_Core_Block_Template {
	public function _prepareLayout() {
		return parent::_prepareLayout();
    }
    
     public function getCartajax() { 
        if (!$this->hasData('cartajax')) {
            $this->setData('cartajax', Mage::registry('cartajax'));
        }
        return $this->getData('cartajax');
    }
}
