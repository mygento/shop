<?php

class Mygento_Dellin_Model_Observer extends Varien_Object {

    public function calculate($request,$result,$request_array,$arrivalLabel,$code,$label,$todoors=false,$insurance=false) {


        if ($insurance===true) {
            $request_array['statedValue']=intval(Mage::getStoreConfig('carriers/dellin/insval'))*$request->getPackageValue()/100;
        }
        if ($todoors===true) {
            $request_array['arrivalDoor']='1';
        } else {
            $request_array['arrivalDoor']='0';
        }





        $model=Mage::getModel('dellin/dellin');
        $xml_result=$model->calculateDelivery($request_array);
        $price=intval($xml_result->price);

        Mage::helper('dellin')->AddLog('XML request price-> '.$price);
        if ($xml_result->error) {
            Mage::helper('dellin')->AddLog('XML request error-> '.$xml_result->error);
        }







        $method=Mage::getModel('shipping/rate_result_method');
        $method->setCarrier('dellin');
        $method->setCarrierTitle(Mage::getStoreConfig('carriers/dellin/title'));
        $method->setMethod($code);
        $method->setMethodTitle(Mage::getStoreConfig('carriers/dellin/name').' '.$arrivalLabel.' '.$label);
        $method->setPrice($price);
        $method->setCost($price);
        $result->append($method);



        $method=Mage::getModel('shipping/rate_result_method');
        $method->setCarrier('dellin');
        $method->setCarrierTitle(Mage::getStoreConfig('carriers/dellin/title'));
        $price=0;
        $method->setMethod($code.'_free');
        $method->setMethodTitle(Mage::getStoreConfig('carriers/dellin/name').' '.$arrivalLabel.' '.$label);
        $method->setPrice($price);
        $method->setCost($price);
        $result->append($method);

        return $result;
    }

    public function addship(Varien_Event_Observer $observer) {
        $result=$observer->getResult();
        $request=$observer->getRequest();
        $model=Mage::getModel('dellin/dellin');

        $arrival_data=$model->findRecieverId(mb_strtoupper(mb_substr($request->getDestCity(),0,1,'UTF-8'),'UTF-8').mb_substr($request->getDestCity(),1,strlen($request->getDestCity())-1,'UTF-8'));
        if ($arrival_data===false) {
            return false;
        }
        $arrivalLabel=$arrival_data['arrivalLabel'];
        $arrivalPoint=$arrival_data['arrivalPoint'];

        $derivalPoint=$model->findSenderId();

        if (strlen($arrivalPoint)<=1&&strlen($derivalPoint)<=1) {
            Mage::helper('dellin')->AddLog('Empty derival and arrival codes');
            return false;
        }

        $request_array=array();
        $request_array['request']='xmlResult';
        $request_array['derivalPoint']=$derivalPoint;
        $request_array['arrivalPoint']=$arrivalPoint;
        $request_array['sizedWeight']=$observer->getWeight();
        $request_array['sizedVolume']=$observer->getVolume();
        $request_array['derivalDoor']='1';
        $request_array['packages']=$this->getConfigData('packaging');


        $result=$this->calculate($request,$result,$request_array,$arrivalLabel,'1','Доставка до двери, со страховкой',true,true);
        $result=$this->calculate($request,$result,$request_array,$arrivalLabel,'2','Доставка до двери, без страховки',true,false);
        $result=$this->calculate($request,$result,$request_array,$arrivalLabel,'3','Со страховкой',false,true);
        $result=$this->calculate($request,$result,$request_array,$arrivalLabel,'4','Без страховки',false,false);









        return $result;
    }

}
