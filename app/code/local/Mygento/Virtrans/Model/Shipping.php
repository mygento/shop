<?php

class Mygento_Virtrans_Model_Shipping extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface {

    protected $_code='virtrans';
    protected $_isFixed=true;

    public function collectRates(Mage_Shipping_Model_Rate_Request $request) {

        if (!Mage::getStoreConfig('carriers/'.$this->_code.'/active')) {
            return false;
        }
        if (''==$request->getDestCity()) {
            return false;
        }
        if (0>$request->getPackageWeight()) {
            return false;
        }
        $weight=$request->getPackageWeight();
        $tocity=mb_strtoupper(mb_substr($request->getDestCity(),0,1,'UTF-8'),'UTF-8').mb_substr($request->getDestCity(),1,strlen($request->getDestCity())-1,'UTF-8');
        $collection=Mage::getModel('virtrans/virtrans')->getCollection();
        $collection->addFieldToFilter('city',$tocity);
        $collection->load();
        if (count($collection)==0) {
            return false;
        }
        $virt=$collection->getFirstItem();
        $price=$virt->getNacl();
        if ($weight<45) {
            $price+=$weight*$virt->getLevel1();
        }
        if ($weight>=45&&$weight<100) {
            $price+=$weight*$virt->getLevel2();
        }
        if ($weight>=100&&$weight<250) {
            $price+=$weight*$virt->getLevel3();
        }
        if ($weight>=250&&$weight<500) {
            $price+=$weight*$virt->getLevel4();
        }
        if ($weight>=500&&$weight<1000) {
            $price+=$weight*$virt->getLevel5();
        }
        if ($weight>1000) {
            $price+=$weight*$virt->getLevel6();
        }
        $price+=$virt->getTrans();
        $price+=1500;
        if ($price<$virt->getMin()) {
            $price=$virt->getMin();
        }
        $result=Mage::getModel('shipping/rate_result');
        $method=Mage::getModel('shipping/rate_result_method');
        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));
        $method->setMethod($this->_code);
        $method->setMethodTitle($this->getConfigData('name'));
        $method->setPrice($price);
        $method->setCost($price);
        $result->append($method);


        $method=Mage::getModel('shipping/rate_result_method');
        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));
        $method->setMethod($this->_code.'_free');
        $method->setMethodTitle($this->getConfigData('name'));
        $method->setPrice(0);
        $method->setCost(0);
        $result->append($method);


        return $result;
    }

    public function getAllowedMethods() {
        return array('virtrans'=>$this->getConfigData('name'));
    }

}
