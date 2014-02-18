<?php

class Mygento_FastDelivery_Model_Shipping extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface {

    protected $_code='fastdelivery';
    protected $_isFixed=true;

    public function collectRates(Mage_Shipping_Model_Rate_Request $request) {

        if (!Mage::getStoreConfig('carriers/'.$this->_code.'/active')) {
            return false;
        }
        $result=Mage::getModel('shipping/rate_result');
        $tocity=mb_strtoupper(mb_substr($request->getDestCity(),0,1,'UTF-8'),'UTF-8').mb_substr($request->getDestCity(),1,strlen($request->getDestCity())-1,'UTF-8');
        if ($tocity=='Санкт-Петербург'&&$request->getDestPostcode()=='192029') {
            $show=true;
        } else {
            $show=false;
        }
        if ($show) {
            $method=Mage::getModel('shipping/rate_result_method');
            $method->setCarrier($this->_code);
            $method->setCarrierTitle($this->getConfigData('title'));
            $method->setMethod('free');
            $method->setMethodTitle($this->getConfigData('name'));
            $method->setPrice(0);
            $method->setCost(0);
            $result->append($method);
        } else {
            $error=Mage::getModel('shipping/rate_result_error');
            $error->setCarrier($this->_code);
            $error->setCarrierTitle($this->getConfigData('name'));
            $error->setErrorMessage($this->getConfigData('specificerrmsg'));
            $result->append($error);
        }

        return $result;
    }

    public function getAllowedMethods() {
        return array('fastdelivery'=>$this->getConfigData('name'));
    }

}

?>