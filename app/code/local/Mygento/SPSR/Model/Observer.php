<?php

class Mygento_Spsr_Model_Observer extends Varien_Object {

    protected $_code='spsr';

    public function calculate(Varien_Event_Observer $observer) {
        $result=$observer->getResult();
        $request=$observer->getRequest();

        $model=Mage::getModel('spsr/spsr');
        if (!$model->initSession()) {
            return false;
        }
        $model->getOriginCityId();
        $model->getDestinCityId($request->getDestCity());
        $calc_result=$model->calculate($request->getPackageWeight(),$request->getPackageValue());
        $i=1;
        foreach ($calc_result as $tariff) {
            $method=Mage::getModel('shipping/rate_result_method');
            $method->setCarrier($this->_code);
            $method->setCarrierTitle($this->getConfigData('title'));
            $method->setMethod('free_'.$i++);

            $daysall=explode('-',$tariff->DP);
            if ($daysall[0] == $daysall[1]) {
                $days=$daysall[0].' '.Mage::helper('spsr')->getNumEnding($daysall[0]);
            } else {
                $days=$daysall[0].'—'.$daysall[1].' '.Mage::helper('spsr')->getNumEnding($daysall[1]);
            }
            $method->setFromDate($daysall[0]);
            $method->setToDate($daysall[1]);


            $price=0;

            $method->setMethodTitle(str_replace('Услуги по доставке','',str_replace('"','',$tariff->TariffType)).', '.$days);
            $method->setPrice($price);
            $method->setCost($price);
            $result->append($method);
        }

        foreach ($calc_result as $tariff) {
            $method=Mage::getModel('shipping/rate_result_method');
            $method->setCarrier($this->_code);
            $method->setCarrierTitle($this->getConfigData('title'));
            $method->setMethod($i++);

            $daysall=explode('-',$tariff->DP);
            if ($daysall[0] == $daysall[1]) {
                $days=$daysall[0].' '.Mage::helper('spsr')->getNumEnding($daysall[0]);
            } else {
                $days=$daysall[0].'—'.$daysall[1].' '.Mage::helper('spsr')->getNumEnding($daysall[1]);
            }
            $method->setFromDate($daysall[0]);
            $method->setToDate($daysall[1]);


            $price=intval($tariff->Total_Dost) + intval($tariff->Total_DopUsl) + intval($tariff->Insurance);
            $price=round($price * Mage::getStoreConfig('carriers/spsr/pricecoef'),2);
            $price=round($price / Mage::app()->getStore()->getCurrentCurrencyRate(),1);

            $method->setMethodTitle(str_replace('Услуги по доставке','',str_replace('"','',$tariff->TariffType)).', '.$days);
            $method->setPrice($price);
            $method->setCost($price);
            $result->append($method);
        }


        return $result;
    }

}
