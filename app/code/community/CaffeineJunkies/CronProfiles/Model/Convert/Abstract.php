<?php
/**
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * CronProfile Convert Abstract, some useful helper methods, primarily for logging.
 *
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @author     Patrick McKinley <patrick.w.mckinley@gmail.com>
 */
class CaffeineJunkies_CronProfiles_Model_Convert_Abstract extends 
    Mage_Dataflow_Model_Convert_Container_Abstract
{
    /**
     * Cached batch model/
     * @var Mage_Dataflow_Model_Batch
     */
    protected $_batchModel;
    
    /**
     * Stored helpers for later use
     * @var array
     */
    protected $_helpers = array();
    
    /**
     * Default action code for storing logs
     * @var string
     */
    protected $_actionCode = 'cronprofiles';
    
    /**
     * Default helper
     * @var string
     */
    protected $_defaultHelper = 'cronprofiles';
    
    /**
     * Io Adaptor types
     * @var string
     */
    const FILE = 'file';
    const FTP = 'ftp';
    const SFTP = 'sftp';
    
    /**
     * Get an instance of an Io Adaptor - currently only works with file.
     * 
     * @param string $path
     * @param string $type
     * @return Varien_Io_Abstract
     */
    protected function _getIoAdaptor($path, $type = self::FILE)
    {
        $_ioClass = "Varien_Io_".ucfirst($type);
        $_ioAdaptors = new $_ioClass();
        $path = $_ioAdaptors->getDestinationFolder($path);
        if (preg_match('#^'.preg_quote(DS, '#').'#', $path) ||
            preg_match('#^[a-z]:'.preg_quote(DS, '#') .'#i', $path)) 
        {
            $path = $_ioAdaptors->getCleanPath($path);
        }
        else
        {
            $baseDir = Mage::getBaseDir();
            $path = $_ioAdaptors->getCleanPath($baseDir . DS . trim($path, DS));
        }
        
        $_ioAdaptors->checkAndCreateFolder($path);
        $_ioAdaptors->open(
            array(
                'path' => $path
            )
        );
        return $_ioAdaptors;
    }
    
    /**
     * Get the current batch model instance
     * 
     * @return Mage_Dataflow_Model_Batch
     */
    protected function _getBatchModel()
    {
        if(!$this->_batchModel)
        {
            $this->_batchModel = Mage::getSingleton('dataflow/batch');;
        }
        return $this->_batchModel;
    }
    
    /**
     * Get an instance of a helper class
     * 
     * @param string $helper
     * @return Mage_Core_Helper_Abstract
     */
    protected function _getHelper($helper = null)
    {
        if(is_null($helper))
        {
            $helper = $this->_defaultHelper;
        }
        if(!isset($this->_helpers[$helper]))
        {
            $this->_helpers[$helper] = Mage::helper($helper);
        }
        return $this->_helpers[$helper];
    }
    
    /**
     * Throw an error, and log.
     * 
     * @param string $message
     * @param mixed $profile
     * @return CaffeineJunkies_CronProfiles_Model_Convert_Abstract
     */
    protected function _throwError($message, $profile = null)
    {
        $this->_logMessage($message, $profile, CaffeineJunkies_CronProfiles_Model_Profile_Log::TYPE_ERROR);
        Mage::throwException($message);
        return $this;
    }
    
    /**
     * Throw a notice, and log.
     * 
     * @param string $message
     * @param mixed $profile
     * @return CaffeineJunkies_CronProfiles_Model_Convert_Abstract
     */
    protected function _throwNotice($message, $profile = null)
    {
        $this->_logMessage($message, $profile, CaffeineJunkies_CronProfiles_Model_Profile_Log::TYPE_NOTICE);
        $this->addException($message);
        return $this;
    }
    
    /**
     * Log a message.
     * 
     * @param string $message
     * @param mixed $profile
     * @param string $type
     * @return CaffeineJunkies_CronProfiles_Model_Convert_Abstract
     */
    protected function _logMessage($message, $profile = null, $type = CaffeineJunkies_CronProfiles_Model_Profile_Log::TYPE_MESSAGE)
    {
        if(is_null($profile))
        {
            $profile = $this->_getBatchModel()->getProfileId();
        }
        $this->_getHelper('cronprofiles')->addEntry($this->_actionCode, $profile, $message, $type);
        return $this;
    }
    
    /**
     * Get the filesize of a desired file
     * 
     * @param string $path
     * @param string $file
     * @param int $precision
     * @return string
     */
    public function getFileSize($path, $file, $precision = 2) {
        $bytes = $this->getRawSize($path, $file);
        return $this->formatSize($bytes, $precision);
    }
    
    /**
     * Get the raw filesize in bytes
     * 
     * @param string $path
     * @param string $file
     * @return string
     */
    protected function getRawSize($path, $file)
    {
        return filesize($path.'/'.$file);
    }
    
    /**
     * Format the number of bytes into human readable form.
     * 
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    protected function formatSize($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
    
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
    
        $bytes /= pow(1024, $pow);
    
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}