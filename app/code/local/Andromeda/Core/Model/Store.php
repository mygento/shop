<?
// ITEAMO . CORRECTED <<<
// Описываем новый класс, наследующий стандартный класс, контролирующий работу с ценой
// app/code/core/Mage/Core/Model/Store.php
class Andromeda_Core_Model_Store extends Mage_Core_Model_Store
{
	public function formatPrice($price, $includeContainer = true) 
	{ 
		if($this->getCurrentCurrency()) { 
			$priceReturn = $this->getCurrentCurrency()->format($price, array(), $includeContainer); 

			if(preg_match('/руб/i', $priceReturn)) 
			{
				// ITEAMO . FRONTEND PRICE PRECTISION FORMAT SETTING . CORRECTED <<<
				  // TEST <<<
				    // echo '<hr>' . print_r($GLOBALS) . '<hr>';
				    // echo '<hr>' . print_r($_REQUEST) . '<hr>';
				    // echo '<hr>' . print_r($this) . '<hr>';				    
				  // >>> TEST
          $precision = 0;
				  // /*
          if (stripos($_SERVER['REQUEST_URI'], 'siltek'))
				  {
            $precision = 2;
          }
          // */
          return $this->getCurrentCurrency()->format($price, array('precision' => $precision), $includeContainer);
        // >>> ITEAMO . FRONTEND PRICE PRECTISION FORMAT SETTING . CORRECTED  
			} else { 
				return $priceReturn; 
			} 
		} 
    	return $price; 
  	}
}
?>