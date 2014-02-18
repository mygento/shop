<?php

class Mygento_Virtrans_Block_Adminhtml_Virtrans_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('virtrans_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('virtrans')->__('Редактирование тарифа'));
    }

    protected function _beforeToHtml() {
        $this->addTab('form_section',array(
            'label'=>Mage::helper('virtrans')->__('Редактирование тарифа'),
            'title'=>Mage::helper('virtrans')->__('Редактирование тарифа'),
            'content'=>$this->getLayout()->createBlock('virtrans/adminhtml_virtrans_edit_tab_form')->toHtml(),
        ));
        return parent::_beforeToHtml();
    }

}