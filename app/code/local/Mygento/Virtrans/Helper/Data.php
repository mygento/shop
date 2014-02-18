<?php

class Mygento_Virtrans_Helper_Data extends Mage_Core_Helper_Abstract {

    public function AddLog($text) {
        if (Mage::getStoreConfig('virtrans/general/debug')) {
            Mage::log($text,null,'virtrans.log');
        }
    }

}

?>