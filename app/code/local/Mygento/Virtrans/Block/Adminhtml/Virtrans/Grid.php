<?php

class Mygento_Virtrans_Block_Adminhtml_Virtrans_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function _construct() {
        parent::_construct();
        $this->setId('virtransGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection=Mage::getModel('virtrans/virtrans')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('id',array(
            'header'=>Mage::helper('virtrans')->__('ID'),
            'align'=>'left',
            'width'=>'30px',
            'index'=>'id',
        ));

        $this->addColumn('city',array(
            'header'=>Mage::helper('virtrans')->__('Город'),
            'align'=>'left',
            'index'=>'city',
        ));

        $this->addColumn('min',array(
            'header'=>Mage::helper('virtrans')->__('min сумма,руб.'),
            'index'=>'min',
        ));

        $this->addColumn('nacl',array(
            'header'=>Mage::helper('virtrans')->__('Сбор за накладную'),
            'align'=>'left',
            'index'=>'nacl',
        ));

        $this->addColumn('level1',array(
            'header'=>Mage::helper('virtrans')->__('до 45 кг'),
            'align'=>'left',
            'index'=>'level1',
        ));

        $this->addColumn('level2',array(
            'header'=>Mage::helper('virtrans')->__('от 45 кг'),
            'align'=>'left',
            'index'=>'level2',
        ));

        $this->addColumn('level3',array(
            'header'=>Mage::helper('virtrans')->__('от 100 кг'),
            'align'=>'left',
            'index'=>'level3',
        ));

        $this->addColumn('level4',array(
            'header'=>Mage::helper('virtrans')->__('от 250 кг'),
            'align'=>'left',
            'index'=>'level4',
        ));

        $this->addColumn('level5',array(
            'header'=>Mage::helper('virtrans')->__('от 500 кг'),
            'align'=>'left',
            'index'=>'level5',
        ));

        $this->addColumn('level6',array(
            'header'=>Mage::helper('virtrans')->__('от 1000 кг'),
            'align'=>'left',
            'index'=>'level6',
        ));


        $this->addColumn('trans',array(
            'header'=>Mage::helper('virtrans')->__('трансферный сбор'),
            'align'=>'left',
            'index'=>'trans',
        ));

        //other columns here
        $this->addColumn('action',array(
            'header'=>Mage::helper('virtrans')->__('Action'),
            'width'=>'50',
            'type'=>'action',
            'getter'=>'getId',
            'actions'=>array(
                array(
                    'caption'=>Mage::helper('virtrans')->__('Edit'),
                    'url'=>array('base'=>'*/*/edit'),
                    'field'=>'id'
                )
            ),
            'filter'=>false,
            'sortable'=>false,
            'index'=>'stores',
            'is_system'=>true,
        ));
        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit',array('id'=>$row->getId()));
    }

}
