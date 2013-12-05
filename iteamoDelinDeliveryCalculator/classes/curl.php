<?
/**
 * Curl
 * Implements the functions of CURL lib
 * @version 1.0
 * @author alex
 */
class curl {

    public static $cookieFile = 'cookie.txt';
    public static $userAgent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1;';
    public static $compression = 'gzip';
    public static $timeOut = 25;
    
    // Cookie is required to show in yandex search result 20
    public static $cookie = '';
    public static $cachePath = '/FRCache/curl/';
    public static $useCache = false;

    public function curl() {}

    public static function getHTML($url, $arPost = array(), $addCookie = '', $sleep = 'random', $withHeader = false) {

      // Checking cache      
      if (self::$useCache) 
      {
        $cacheFile = $_SERVER['DOCUMENT_ROOT'] . curl::$cachePath . md5($url);
        if (file_exists($cacheFile))
          return join(file($cacheFile));      
        // die($cacheFile . '  !!!!!');
      }

      // CURL processing
      if (!$ch = curl_init())
        die("Couldn't initialize a cURL handle");

      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      if ($withHeader)
        curl_setopt($ch, CURLOPT_HEADER, 1);
      else
        curl_setopt($ch, CURLOPT_HEADER, 0);
      //curl_setopt($ch, CURLOPT_COOKIEFILE, curl::$cookieFile);
      //curl_setopt($ch, CURLOPT_COOKIEJAR, curl::$cookieFile);
      if ($addCookie)
        curl::$cookie .= $addCookie;
      curl_setopt($ch, CURLOPT_COOKIE, curl::$cookie);
      curl_setopt($ch, CURLOPT_AUTOREFERER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, curl::$timeOut);
      curl_setopt($ch, CURLOPT_ENCODING , curl::$compression);
      curl_setopt($ch, CURLOPT_USERAGENT, curl::$userAgent);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_FAILONERROR, 1);

      if (!empty($arPost)) {
          foreach ($arPost as $key => $val)
            $request[] = $key.'='.urlencode($val);
          //curl_setopt ($ch ,CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', $request));
      }

      $html = curl_exec($ch);
      curl_close($ch);
      
      if ($sleep) {
        $sleep = 2;
        if ($sleep == 'random' && (stripos($url, 'yandex') || stripos($url, 'rambler')))
          $sleep = rand(2, 7);
        else
          $sleep = 2;
        sleep($sleep);
      }
        
      // Cache file writing      
      if (self::$useCache)
        if (!empty($html) && !stripos($_SERVER['SERVER_NAME'], '.')) 
        {
          $cacheFile = fopen($cacheFile, 'w+');
          fwrite($cacheFile, $html);
          fclose($cacheFile);
        }      
      
      return $html;
      

    }

    public static function getFILE ($url, $filename, $use_cache = true) {

      if ($use_cache && file_exists($filename))
        return true;

      if (!$ch = curl_init($url))
        die("Couldn't initialize a cURL handle");

      if (!$fp = fopen($filename, "w")) {
              die('File error: Can not create file: '.$filename.' ( '.$url.' )');
      } else {
          curl_setopt($ch, CURLOPT_FILE, $fp);
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_TIMEOUT, curl::$timeOut);
          curl_exec($ch);
          if (curl_error($ch))
            return false;
          curl_close($ch);
          fclose($fp);
      }

      return true;

    }

}
