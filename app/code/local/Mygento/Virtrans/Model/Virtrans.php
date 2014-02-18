<?php

class Mygento_Virtrans_Model_Virtrans extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('virtrans/virtrans');
    }

}
