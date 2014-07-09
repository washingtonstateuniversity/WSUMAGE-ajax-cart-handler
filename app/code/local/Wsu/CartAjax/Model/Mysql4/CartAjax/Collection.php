<?php
class Wsu_CartAjax_Model_Mysql4_CartAjax_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {
    public function _construct() {
        parent::_construct();
        $this->_init('cartajax/cartajax');
    }
}
