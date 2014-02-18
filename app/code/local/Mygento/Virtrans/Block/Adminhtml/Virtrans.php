<?php

class Mygento_Virtrans_Block_Adminhtml_Virtrans extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function _construct() {
        $this->_controller='adminhtml_virtrans';
        $this->_blockGroup='virtrans';
        $this->_headerText=Mage::helper('virtrans')->__('Управление тарифами');
        $this->_addButtonLabel=Mage::helper('virtrans')->__('Добавить тариф');
        parent::_construct();
    }

}
