<?
// ITEAMO . DELIN DELIVERY CALCULATOR <<<
// INIT <<<
  ini_set('error_reporting', E_ALL &~E_STRICT &~E_NOTICE);
  ini_set('display_errors', '1');
// >>> INIT 
// FORMATS <<<
/* 
----------------------------------------------------
  $newdata[] = array (
    'pk' => 'delin',
    'website_id' => '1',
    'dest_country_id' => 'RU',
    'dest_region_id' => $request->getDestRegionId(),
    'dest_city' => '', // $request->getDestCity()
    'dest_zip' => '',
    'dest_zip_to' => '',
    'condition_name' => 'package_weight',
    'condition_from_value' => '0.0000',
    'condition_to_value' => '2000000.0000',
    'price' => '100.0000',
    'cost' => '0.0000',
    'delivery_type' => 'Деловые линии (автоперевозки до терминала)', //Деловые линии (автоперевозки до двери)
  );
----------------------------------------------------  
  $arRequest = array(
    'derivalPoint' => '', // код города отправки;
    'arrivalPoint' => '', // код города прибытия;
    'derivalDoor' => '', // считать доставку от двери;
    'arrivalDoor' => '', // считать доставку до двери;
    'sizedWeight' => '', // вес габаритной части груза;
    'sizedVolume' => '', // объем габаритной части груза;
    'arrivalDoor' => '1',  
  )
  http://public.services.dellin.ru/calculatorService2/index.html?request=xmlResult&derivalPoint=0x805900112FDD658311DA3BC904F59A69&arrivalPoint=0x81F600112FDD658311DA7152AB69D666&sizedWeight=234&sizedVolume=3    
----------------------------------------------------
// */       
// >>> FORMATS
  
class iteamoDelinDeliveryCalculator 
{
public $arRequestParamsByMethodName = array(
  'Деловые линии (автоперевозки до терминала)' => array(),
  'Деловые линии (автоперевозки до двери)' => array('arrivalDoor' => 1),   
);
private $boolTest = false;
/**
 *
 */ 
public function __construct() 
{
  $this->modulePath = self::getModulePath();  
  require_once($this->modulePath . '/classes/iteamoMagentoHelpFunction.php');
  $this->getCitiesCodesList();
}
// MAGENTO FUNCTIONS <<< =======================================================
/**
 *
 */
public function init($arMagentoDeliveryMethods = array(), $objRequest = object, $boolTest = false) 
{   
  $arMethodKeyByName = array();
  $arRequestObj = $this->getObjRequestArray($objRequest);
  $this->boolTest = $boolTest; 
  
  // LOG <<<    
    // self::log($arData = $GLOBAL, $key = '$GLOBAL', $file = __FILE__);
  // >>> LOG    
  
  $cacheKey = md5(var_export($arRequestObj, true));
  if (!stripos('prefix' . $_SERVER['REQUEST_URI'], 'admin'))    
    if (isset($_SESSION['iteamoDelinDeliveryCalculator']['arCache'][$cacheKey])) 
      return $_SESSION['iteamoDelinDeliveryCalculator']['arCache'][$cacheKey];
  
  // UPGRADING <<<      
  foreach ($arMagentoDeliveryMethods as $key => $arMagentoDeliveryMethod)  
    if (in_array($arMagentoDeliveryMethod['delivery_type'], array_keys($this->arRequestParamsByMethodName)))
    {
      $arResult = $this->calculateMagentoAdapter($arRequestObj, $arMagentoDeliveryMethod);
      $arMagentoDeliveryMethods[$key]['price'] = $arResult['price'];
      $arMagentoDeliveryMethods[$key]['arRequest'] = $arResult['arRequest'];
      $arMethodKeyByName[$arMagentoDeliveryMethod['delivery_type']] = $key;
    }
  // >>> UPGRADING 
    
  // ADDING <<<
  if (($arRequestObj['derivalCity'] != $arRequestObj['destinationCity']) || ($arRequestObj['derivalRegion'] != $arRequestObj['destinationRegion']))
  foreach(array_keys($this->arRequestParamsByMethodName) as $methodName)
    if (!isset($arMethodKeyByName[$methodName]))
    {
      $arMagentoDeliveryMethod = array(
        'pk' => 'delin',
        'website_id' => '1',
        'dest_country_id' => 'RU',
        'dest_region_id' => $arRequestObj['destinationRegionId'],
        'dest_city' => $arRequestObj['destCity'], 
        'dest_zip' => '',
        'dest_zip_to' => '',
        'condition_name' => 'package_weight',
        'condition_from_value' => '0.0000',
        'condition_to_value' => '2000000.0000',
        'price' => '0.0000',
        'cost' => '0.0000',
        'delivery_type' => $methodName,        
      );
      $arResult = $this->calculateMagentoAdapter($arRequestObj, $arMagentoDeliveryMethod);       
      
      $arMagentoDeliveryMethod['price'] = $arResult['price'];
      $arMagentoDeliveryMethod['arRequest'] = $arResult['arRequest'];      
      $arMagentoDeliveryMethods[] = $arMagentoDeliveryMethod; 
    }      
  // >>> ADDING 
  
  $_SESSION['iteamoDelinDeliveryCalculator']['arCache'][$cacheKey] 
    = $_SESSION['iteamoDelinDeliveryCalculator']['arCache']['arLast'] =  $arMagentoDeliveryMethods;
    
  return $arMagentoDeliveryMethods;
}  
/**
 *
 */
public function getObjRequestArray($objRequest = object)
{
  if (!$this->boolTest)
    $arRequestObj = array(
      'derivalRegionId' => Mage::getStoreConfig(Mage_Shipping_Model_Shipping::XML_PATH_STORE_REGION_ID, Mage::app()->getStore()),
      'derivalRegion' => $this->getRegionById(Mage::getStoreConfig(Mage_Shipping_Model_Shipping::XML_PATH_STORE_REGION_ID, Mage::app()->getStore())),     
      'derivalCity' => Mage::getStoreConfig(Mage_Shipping_Model_Shipping::XML_PATH_STORE_CITY, Mage::app()->getStore()),
      
      'destinationRegionId' => $objRequest->getDestRegionId(),
      'destinationRegion' => $this->getRegionById($objRequest->getDestRegionId()),
      'destinationCity' => $objRequest->getDestCity(),       
    );
  else
    $arRequestObj = array(
      'derivalRegionId' => Mage::getStoreConfig(Mage_Shipping_Model_Shipping::XML_PATH_STORE_REGION_ID, Mage::app()->getStore()),
      'derivalRegion' => $this->getRegionById(Mage::getStoreConfig(Mage_Shipping_Model_Shipping::XML_PATH_STORE_REGION_ID, Mage::app()->getStore())),     
      'derivalCity' => Mage::getStoreConfig(Mage_Shipping_Model_Shipping::XML_PATH_STORE_CITY, Mage::app()->getStore()),
      
      'destinationRegionId' => 1,
      'destinationRegion' => 'Архангельская область',
      'destinationCity' => 'Архангельск',       
    );  
  return $arRequestObj;
} 
/**
 *
 */ 
public function getCartItems()
{
  $arCart['arItems'] = array();
  $cartHelper = Mage::helper('checkout/cart');
  $objItems = $cartHelper->getCart()->getItems();

  foreach ($objItems as $item) 
  {    
    // GET NAME <<<
      $arItem['name'] = $item->getName();
    // >>> GET NAME      
      
    // GET PRODUCT ID <<<      
      $arItem['productId'] = $item->getProductId();      
    // >>> GET PRODUCT ID

    // GET QUANTITY <<<      
      $arItem['quantity'] = $item->getQty();
    // >>> GET QUANTITY
    
    // GET WEIGHT <<<      
      $arItem['weight'] = $item->getWeight();
    // >>> GET WEIGHT
          
    // GET VOLUME <<<      
      // TODO:       
      $arItem['volume'] = Mage::getModel('catalog/product')
                            ->load($arItem['productId'])                            
                            ->getAttribute('volume');
                            
      // FOR TEST 
      $arItem['volume'] = 0.001;                            
    // >>> GET VOLUME
    
    $arCart['arItems'][] = $arItem;
  }
  // LOG <<<    
    self::log($arData = $arCart['arItems'], $key = '$arCart[arItems]', $file = __FILE__);
  // >>> LOG  
  return $arCart['arItems'];
}
/**
 *
 */
public function getCartParams() 
{
  $arCartParams = array(
    'weight' => 0,
    'volume' => 0,
  );
  $arCartItems = $this->getCartItems();
  foreach($arCartItems as $arItem)
  {
    $arCartParams['weight'] += $arItem['weight'] * $arItem['quantity'];
    $arCartParams['volume'] += $arItem['volume'] * $arItem['quantity'];
  }
  
  // FIXING BUG IN ADMIN SECTION <<<
  if ($arCartParams['weight'] == 0)
    $arCartParams['weight'] = 100;
  if ($arCartParams['volume'] == 0)
    $arCartParams['volume'] = 0.01;
  // >>> FIXING BUG IN ADMIN SECTION       
  return $arCartParams;
}
/**
 *
 */
public function getRegionById($regionId = '') 
{  
  $arRegion = iteamoMagentoHelpFunction::dbGet($query = 'SELECT name FROM directory_country_region_name WHERE locale = "ru_RU" and region_id = ' . $regionId);
  return $arRegion['name'];  
} 
// >>> MAGENTO FUNCTIONS ======================================================= 
// GET CITY CODE <<< =======================================================
/**
 *
 */
public function getCitiesCodesList() 
{    
  require_once($this->modulePath . '/classes/xmlToArray.php');  
  $path = $this->modulePath . '/data/citiesXml.php';
  $citiesXml = join(file($path));
  $this->arCities = xmlToArray::parse($citiesXml);      
}
/**
 *
 */
public function getCityCodeBy($region = '', $city = '')
{
  // DEBUG <<< 
    // print_r($this->arCities['data']['_c']['cities']['_c']['city']);
  // >>> DEBUG
  
  foreach ($this->arCities['data']['_c']['cities']['_c']['city'] as $arCityXml)
  {
    $arCity['name'] = $arCityXml['_c']['name']['_v'];
    $arCity['code'] = $arCityXml['_c']['id']['_v'];
    
    $region = str_ireplace('область', '', $region);
    $region = str_ireplace('обл', '', $region);
    $region = str_ireplace('.', '', $region);
    $region = str_ireplace('край', '', $region);
    
    if (stripos('prefix' . $region, $arCity['name']) || stripos('prefix' . $city, $arCity['name'])
        || stripos('prefix' . $arCity['name'], $region) || stripos('prefix' . $arCity['name'], $city))
      return $arCity['code'];
  }
}
// >>> GET CITY CODE =======================================================
// CALCULATION <<< =======================================================
/**
 *
 */ 
public function calculateMagentoAdapter($arRequestObj = array(), $arMagentoDeliveryMethod = array()) 
{  
  $arRequest = array();    
  $arRequest['derivalPoint'] = $this->getCityCodeBy($region = $arRequestObj['derivalRegion'], $city = $arRequestObj['derivalCity']);    
  $arRequest['arrivalPoint'] = $this->getCityCodeBy($region = $arRequestObj['destinationRegion'], $city = $arRequestObj['destinationCity']);  
  
  $arCartParams = $this->getCartParams();
  $arRequest['sizedWeight'] = $arCartParams['weight'];
  $arRequest['sizedVolume'] = $arCartParams['volume'];  
  
  $arRequest = array_merge($arRequest, $this->arRequestParamsByMethodName[$arMagentoDeliveryMethod['delivery_type']]);   
  
  return $this->calculate($arRequest);
} 
/**
 *
 */
public function calculate($arRequest = array()) 
{    
  require_once($this->modulePath . '/classes/curl.php');
  require_once($this->modulePath . '/classes/xmlToArray.php');  
  
  $queryLink = 'http://public.services.dellin.ru/calculatorService2/index.html?request=xmlResult';
  foreach($arRequest as $key => $value)
    $queryLink .= '&'. $key . '=' . $value;
    
  $result = curl::getHTML($queryLink);  
  $arResult = xmlToArray::parse($result);
  $arResult['price'] = $arResult['data']['_c']['data']['_c']['price']['_v'];   
  $arResult['price'] = ($arResult['price'] > 0)?$arResult['price']:0.0;
  
  // DEBUG <<<    
    // echo '$arRequest: '; print_r($arRequest); echo '<hr>';
    // echo '$queryLink: '; print_r($queryLink); echo '<hr>';
    // echo '$arResult: '; print_r($arResult); echo '<hr>';
  // >>> DEBUG
   
  // LOG <<<
    $arRequest['queryLink'] = $queryLink;
    self::log($arData = $arRequest, $key = '$arRequest' . '_Price' . $arResult['price'], $file = __FILE__);
  // >>> LOG
  
  $arResult['arRequest'] = $arRequest;
  
  return $arResult;
}
// >>> CALCULATION =======================================================  
// HELP METHODS <<< =======================================================
/**
 *
 */
static public function getModulePath() 
{   
  return dirname(__FILE__);
}
/**
 *
 */
static public function log($arData = array(), $key = '', $file = '') 
{                     
  $path = self::getModulePath() . '/logs/' . $key . '.php';
  $log = fopen($path, 'w+');
    fwrite($log, $key . '/n/r');
    fwrite($log, $file . '/n/r');
    fwrite($log, var_export($arData, true));
  fclose($log);                
} 
// >>> HELP METHODS =======================================================
}

// TEMP <<<
  // $product = Mage::getModel('catalog/product')->load(93);
  // $attribute = $product->getResource()->getAttribute("Volume");
  // print_r($attribute);  
// >>> TEMP  
// >>> ITEAMO . DELIN DELIVERY CALCULATOR 