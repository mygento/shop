<?
// ITEAMO . CORRECTED <<<
// Описываем новый класс, наследующий стандартный класс
// app/code/core/Mage/Sales/Model/Order.php
class Andromeda_Sales_Model_Order extends Mage_Sales_Model_Order
{
    /**
     * Retrieve shipping method
     *
     * @param bool $asObject return carrier code and shipping method data as object
     * @return string|Varien_Object
     */
    public function getShippingMethod($asObject = false)
    {        
        // ITEAMO . CORRECTION <<<
          // $shippingMethod = parent::getShippingMethod();
          $shippingMethod = $this->getData('shipping_method');
        // >>> ITEAMO . CORRECTION
          
        if (!$asObject) {
            return $shippingMethod;
        } else {
            list($carrierCode, $method) = explode('_', $shippingMethod, 2);
            return new Varien_Object(array(
                'carrier_code' => $carrierCode,
                'method'       => $method
            ));
        }
    }
}
// >>> ITEAMO . CORRECTED
