<?php

class Mygento_Virtrans_Adminhtml_VirtransController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()->_setActiveMenu('virtrans/virtrans')->_addBreadcrumb(Mage::helper('adminhtml')->__('Virtrans Manager'),Mage::helper('adminhtml')->__('Virtrans Manager'));
        return $this;
    }

    public function indexAction() {
        $this->_initAction()->renderLayout();
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function editAction() {
        $id=$this->getRequest()->getParam('id');
        $model=Mage::getModel('virtrans/virtrans')->load($id);
        if ($model->getId()||$id==0) {
            $data=Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
            Mage::register('virtrans_data',$model);
            $this->loadLayout();
            $this->_setActiveMenu('virtrans/virtrans');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Virtrans Manager'),Mage::helper('adminhtml')->__('Virtrans Manager'));
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('virtrans/adminhtml_virtrans_edit'))->_addLeft($this->getLayout()->createBlock('virtrans/adminhtml_virtrans_edit_tabs'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('virtrans')->__('Virtrans does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function saveAction() {
        if ($data=$this->getRequest()->getPost()) {
            $model=Mage::getModel('virtrans/virtrans');
            $model->setData($data)->setId($this->getRequest()->getParam('id'));
            try {
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('virtrans')->__('Virtrans was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit',array('id'=>$model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit',array('id'=>$this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('virtrans')->__('Unable to find Virtrans to save'));
        $this->_redirect('*/*/');
    }

}
