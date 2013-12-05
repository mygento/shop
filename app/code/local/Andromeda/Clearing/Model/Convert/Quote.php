class Andromeda_Clearing_Model_Convert_Quote extends Mage_Sales_Model_Convert_Quote {

	public function paymentToOrderPayment(Mage_Sales_Model_Quote_Payment $payment)
	{
		$orderPayment = parent::paymentToOrderPayment($payment);

		$orderPayment->setInn($payment->getInn())
			->setKpp($payment->getKpp())
			->setBik($payment->getBik())
			->setAccount($payment->getAccount())
			->setPayer($payment->getPayer());
    
		return $orderPayment;
	}
}