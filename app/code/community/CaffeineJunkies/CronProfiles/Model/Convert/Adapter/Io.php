<?php
/**
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Io Adaptor for reading files from a given pattern which increases numerically.
 * mainly for use when a file has been split with Separate process.
 *
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @author     Patrick McKinley <patrick.w.mckinley@gmail.com>
 */
class CaffeineJunkies_CronProfiles_Model_Convert_Adapter_Io extends 
    Mage_Dataflow_Model_Convert_Adapter_Io
{
    /**
     * Default action code
     * @var string
     */
    protected $_actionCode = 'io';
    
    /**
     * Default helper
     * @var string
     */
    protected $_defaultHelper = 'cronprofiles';
    
    /**
     * Load data from the first file that is found matching the pattern.
     *
     * @return CaffeineJunkies_CronProfiles_Model_Convert_Adapter_Io
     */
    public function load()
    {
        
        if(false == $this->getVar('is_split', false))
        {
            return parent::load();
        }
        if (!$this->getResource()) {
            return $this;
        }
        
        $destFile = $this->_getBatchModel()->getIoAdapter()->getFile(true);

        $filenamePattern = $this->getVar('filename_pattern');
        $pad = $this->getVar('number_buffer');
        
        $result = false;
        $_fileCount = 1;
        while($result == false && $_fileCount < str_pad(9, $pad, 9, STR_PAD_LEFT))
        {
            $_numberString = str_pad($_fileCount, $pad, '0', STR_PAD_LEFT);
            $newFilename = str_replace('{count}', $_numberString, $filenamePattern);
            $result = $this->getResource()->read($newFilename, $destFile);
            $_fileCount++;
        }
        
        if(false === $result)
        {
            $message = $this->_getHelper()->__('Could not find file matching pattern: %s', $filenamePattern);
            //$this->_throwError($message); - surpressed due to a huge amount of entries in the logs
            Mage::throwException($message); // we still want to show it on a manual import run though.
        }
        else
        {
            $filename = $this->getResource()->pwd() . '/' . $newFilename;
            $message = $this->_getHelper()->__('Identified file: %s', $newFilename);
            $this->_logMessage($message);
            $message = $this->_getHelper()->__('Loaded successfully: %s', $filename);
            $this->_throwNotice($message);
        }

        if($this->getVar('rm_on_load', false))
        {
            $this->getResource()->rm($newFilename);
        }

        $this->setData($result);
        return $this;
    }
    
    /**
     * Get the current match model
     * 
     * @return Mage_Dataflow_Model_Batch
     */
    protected function _getBatchModel()
    {
        return Mage::getSingleton('dataflow/batch');
    }
    
    /**
     * Get a helper
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
     * Thow an error, and log it
     * 
     * @param string $message
     * @param mixed $profile
     * @return CaffeineJunkies_CronProfiles_Model_Convert_Adapter_Io
     */
    protected function _throwError($message, $profile = null)
    {
        $this->_logMessage($message, $profile, CaffeineJunkies_CronProfiles_Model_Profile_Log::TYPE_ERROR);
        Mage::throwException($message);
        return $this;
    }
    
    /**
     * Thow a notice, and log it
     * 
     * @param string $message
     * @param mixed $profile
     * @return CaffeineJunkies_CronProfiles_Model_Convert_Adapter_Io
     */
    protected function _throwNotice($message, $profile = null)
    {
        $this->_logMessage($message, $profile, CaffeineJunkies_CronProfiles_Model_Profile_Log::TYPE_NOTICE);
        $this->addException($message);
        return $this;
    }
    
    /**
     * Log a message
     * 
     * @param string $message
     * @param mixed $profile
     * @param string $type
     * @return CaffeineJunkies_CronProfiles_Model_Convert_Adapter_Io
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
}