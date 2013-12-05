<?php
class Andromeda_SelfDelivery_Model_Carrier_ShippingMethod extends Mage_Shipping_Model_Carrier_Abstract
{
	protected $_code = 'selfdelivery';

     public function collectRates(Mage_Shipping_Model_Rate_Request $request)  
     {  
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $result = Mage::getModel('shipping/rate_result');

//Saint-Petersburg
		{
            $method = Mage::getModel('shipping/rate_result_method');

            $method->setCarrier('selfdelivery');
            $method->setCarrierTitle($this->getConfigData('title'));

            $method->setMethod('spb');
			$method->setMethodTitle($this->getConfigData('spb'));

			$method->setPrice(0);
			$method->setCost(0);
			$result->append($method);
		}
        return $result;
	 }
}