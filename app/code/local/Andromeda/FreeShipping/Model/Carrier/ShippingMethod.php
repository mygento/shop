<?php
class Andromeda_FreeShipping_Model_Carrier_ShippingMethod extends Mage_Shipping_Model_Carrier_Abstract
{
	protected $_code = 'andromedafreeshipping';

     public function collectRates(Mage_Shipping_Model_Rate_Request $request)  
     {  
		 if (!$this->getConfigFlag('active')) {
            return false;
        }

        $result = Mage::getModel('shipping/rate_result');
        $packageValue = $request->getPackageValueWithDiscount();

//        $this->_updateFreeMethodQuote($request);

        $free = ($request->getFreeShipping())
            || ($packageValue >= $this->getConfigData('free_shipping_subtotal'));

		$method = Mage::getModel('shipping/rate_result_method');

		$method->setCarrier('freeshipping');
		$method->setCarrierTitle($this->getConfigData('title'));

		$method->setMethod('freeshipping');
		$method->setMethodTitle($this->getConfigData('name'));

		$method->setCost('0.00');
	
		if ($free) {
            $method->setPrice('0.00');
        } else {
            $method->setPrice($this->getConfigData('price'));
		}


		$result->append($method);

        return $result;
	}
}