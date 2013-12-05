class Andromeda_Clearing_Model_Convert_Order extends Mage_Sales_Model_Convert_Order {

	public function paymentToQuotePayment(Mage_Sales_Model_Order_Payment $payment, $quotePayment=null)
	{
		$quotePayment = parent::paymentToQuotePayment($payment, $quotePayment);

		$quotePayment->setInn($payment->getInn())
			->setKpp($payment->getKpp())
			->setBik($payment->getBik())
			->setAccount($payment->getAccount())
			->setPayer($payment->getPayer());
    
		return $quotePayment;
	} 
}