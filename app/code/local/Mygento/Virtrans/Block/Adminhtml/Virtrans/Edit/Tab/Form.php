<?php

class Mygento_Virtrans_Block_Adminhtml_Virtrans_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form=new Varien_Data_Form();
        $this->setForm($form);
        $fieldset=$form->addFieldset('virtrans_form',array('legend'=>Mage::helper('virtrans')->__('Тариф Виртранс')));
        if (Mage::registry('virtrans_data')&&array_key_exists('id',Mage::registry('virtrans_data')->getData())) {
            $fieldset->addField('id','hidden',array('label'=>Mage::helper('virtrans')->__('ID'),'name'=>'id','required'=>true));
        }

        $fieldset->addField('city','text',array(
            'label'=>Mage::helper('virtrans')->__('Город'),
            'name'=>'city',
            'class'=>'required-entry',
        ));

        $fieldset->addField('min','text',array(
            'label'=>Mage::helper('virtrans')->__('min сумма,руб.'),
            'name'=>'min',
            'class'=>'required-entry',
        ));

        $fieldset->addField('nacl','text',array(
            'label'=>Mage::helper('virtrans')->__('Сбор за накладную'),
            'name'=>'nacl',
            'class'=>'required-entry',
        ));
        $fieldset->addField('level1','text',array(
            'label'=>Mage::helper('virtrans')->__('до 45 кг'),
            'name'=>'level1',
            'class'=>'required-entry',
        ));
        $fieldset->addField('level2','text',array(
            'label'=>Mage::helper('virtrans')->__('от 45 кг'),
            'name'=>'level2',
            'class'=>'required-entry',
        ));
        $fieldset->addField('level3','text',array(
            'label'=>Mage::helper('virtrans')->__('от 100 кг'),
            'name'=>'level3',
            'class'=>'required-entry',
        ));
        $fieldset->addField('level4','text',array(
            'label'=>Mage::helper('virtrans')->__('от 250 кг'),
            'name'=>'level4',
            'class'=>'required-entry',
        ));
        $fieldset->addField('level5','text',array(
            'label'=>Mage::helper('virtrans')->__('от 500 кг'),
            'name'=>'level5',
            'class'=>'required-entry',
        ));
        $fieldset->addField('level6','text',array(
            'label'=>Mage::helper('virtrans')->__('от 1000 кг'),
            'name'=>'level6',
            'class'=>'required-entry',
        ));
         $fieldset->addField('trans','text',array(
            'label'=>Mage::helper('virtrans')->__('трансферный сбор'),
            'name'=>'trans',
            'class'=>'required-entry',
        ));


        if (Mage::getSingleton('adminhtml/session')->getVirtransData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getVirtransData());
            Mage::getSingleton('adminhtml/session')->setVirtransData(null);
        } elseif (Mage::registry('virtrans_data')) {
            $form->setValues(Mage::registry('virtrans_data')->getData());
        }
        return parent::_prepareForm();
    }

}
