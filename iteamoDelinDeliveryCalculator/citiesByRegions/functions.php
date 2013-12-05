<?// ITEAMO . CITIES BY REGIONS <<< ?>
<?// INIT <<<
setlocale(LC_ALL, "ru_RU.UTF8");   
// >>> INIT?>
<?
  /**
   * getRegions
   */ 
  function getRegions()
  {
    static $arRegions;
    if (!$arRegions) 
    {
      $cacheKey = 'DIRECTORY_REGIONS_STORE' . Mage::app()->getStore()->getId();
      if (Mage::app()->useCache('config'))       
        $arRegions = Mage::app()->loadCache($cacheKey);
              
      $arRegions = array();
      if (empty($arRegions))
      {   
        $arRegions = Mage::helper('directory')->getRegionJson();
        $arRegions = Mage::helper('core')->jsonDecode($arRegions);
      }        
      
      if (Mage::app()->useCache('config'))       
        Mage::app()->saveCache($arRegions, $cacheKey, array('config'));      
    }  
    return $arRegions;
  }
  /**
   * getCitiesByRegions
   */     
  function getCitiesByRegions($arRegionsFromBase = array()) 
  {
    $fileName = 'russianCitiesByRegions.php';    
    static $arCitiesByRegions = array();
    
    $arCurrentFilePathInfo = pathinfo(__FILE__);    
    $dataFilePath = $arCurrentFilePathInfo['dirname'] . '/' . $fileName;
    $arData = file($dataFilePath);        
                       
    if (!$arCitiesByRegions) 
    {
      $cacheKey = 'DIRECTORY_REGIONS_BY_CITIES_STORE' . Mage::app()->getStore()->getId();
      if (Mage::app()->useCache('config'))       
        $arCitiesByRegions = Mage::app()->loadCache($cacheKey);
      
      $arCitiesByRegions = array();
      if (empty($arCitiesByRegions))
      {   
        $arRegion = array(
          'id' => 'no',
          'name' => 'Остальные',
        );        
        foreach($arData as $line)        
          if (stripos('prefix' . $line, '+')) 
          {          
            $arNewRegion['name'] = str_ireplace('+', '', $line);
            $arNewRegion['name'] = str_ireplace('обл.', '', $arNewRegion['name']);
            $arNewRegion['name'] = str_ireplace('Республика', '', $arNewRegion['name']);
            $arNewRegion['name'] = str_ireplace('республика', '', $arNewRegion['name']);                         
            $arNewRegion['name'] = trim($arNewRegion['name']);
            
            foreach($arRegionsFromBase['RU'] as $regionIdFromBase => $arRegionFromBase)
              if (stripos('prefix' . $arNewRegion['name'], $arRegionFromBase['name'])
                  || stripos('prefix' . $arRegionFromBase['name'], $arNewRegion['name']))
                  {                     
                    $arRegion = array(
                      'id' => $regionIdFromBase,
                      'name' => $arRegionFromBase['name'],  
                    );
                  }                                  
          } else
            $arCitiesByRegions[$arRegion['id']]['arCities'][$line] = $line;            
        $arCitiesByRegions = Mage::helper('core')->jsonEncode($arCitiesByRegions);        
      }
              
      if (Mage::app()->useCache('config'))       
        Mage::app()->saveCache($arCitiesByRegions, $cacheKey, array('config'));      
    }         
    // DEBUG <<<
    // print_r($arRegionsFromBase);
    // print_r($arCitiesByRegions);
    // >>> DEBUG 
    return $arCitiesByRegions;          
  }
  // ----- //
?>  
<?// >>> ITEAMO . CITIES BY REGIONS ?>  