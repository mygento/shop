<?php

class Mygento_Virtrans_Model_Mysql4_Virtrans_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('virtrans/virtrans');
    }

}