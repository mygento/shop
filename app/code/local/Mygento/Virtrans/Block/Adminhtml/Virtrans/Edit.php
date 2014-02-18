<?php

class Mygento_Virtrans_Block_Adminhtml_Virtrans_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function _construct() {
        parent::_construct();
        $this->_objectId='virtrans';
        $this->_controller='adminhtml_virtrans';
        $this->_blockGroup='virtrans';
        $this->_updateButton('save','label',Mage::helper('virtrans')->__('Сохранить тариф'));
        $this->_updateButton('delete','label',Mage::helper('virtrans')->__('Удалить тариф'));
        $this->_addButton('saveandcontinue',array(
            'label'=>Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'=>'saveAndContinueEdit()',
            'class'=>'save',
                ),-100);
        $this->_formScripts[]="
			function saveAndContinueEdit(){
				editForm.submit($('edit_form').action+'back/edit/');
			}
		";
    }

    public function getHeaderText() {
        if (Mage::registry('virtrans_data')&&Mage::registry('virtrans_data')->getId()) {
            return Mage::helper('virtrans')->__("Редактировать тариф %s",$this->htmlEscape(Mage::registry('virtrans_data')->getId()));
        } else {
            return Mage::helper('virtrans')->__('Добавить тариф');
        }
    }

}