<?
// ITEAMO . MAGENTO HELP FUNCTIONS <<<
class iteamoMagentoHelpFunction 
{
/**
 *
 */ 
static public function dbGet($query = '')
{
  $arResult = array();
  $cacheKey = md5($query);
  $cacheOn = true;        
  if ((empty($_SESSION['iteamoCache'][$cacheKey]) && !empty($query)) || !$cacheOn)            
  {
    $db = Mage::getSingleton('core/resource')->getConnection('core_read');          
    $_SESSION['iteamoCache'][$cacheKey] = $arResult = $db->query($query)->fetch();        
  } elseif (!empty($_SESSION['iteamoCache'][$cacheKey])) $arResult = $_SESSION['iteamoCache'][$cacheKey];        
  return $arResult;
}
}
// >>> ITEAMO . MAGENTO HELP FUNCTIONS 