<?php
/**
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Main CronProfiles helper - this contains methods for the log items.
 *
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @author     Patrick McKinley <patrick.w.mckinley@gmail.com>
 */
class CaffeineJunkies_CronProfiles_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * The profile id currently in use.
     * @var int
     */
    protected $_profileId;
    
    /**
     * The action code currently in use.
     * @var string
     */
    protected $_actionCode;

    /**
     * Adds a plain old message to the log.
     * 
     * @param string $data
     * @param string $actionCode
     * @param mixed $profile
     * @return CaffeineJunkies_CronProfiles_Helper_Data
     */
    public function addMessage($data, $actionCode = null, $profile = null)
    {
        return $this->addEntry($actionCode, $profile, $data, $type = CaffeineJunkies_CronProfiles_Model_Profile_Log::TYPE_MESSAGE);
    }

    /**
     * Adds a notice to the log, more important than a message, but less so than an error.
     * 
     * @param string $data
     * @param string $actionCode
     * @param mixed $profile
     * @return CaffeineJunkies_CronProfiles_Helper_Data
     */
    public function addNotice($data, $actionCode = null, $profile = null)
    {
        return $this->addEntry($actionCode, $profile, $data, $type = CaffeineJunkies_CronProfiles_Model_Profile_Log::TYPE_NOTICE);
    }

    /**
     * Adds a error to the log.
     * 
     * @param string $data
     * @param string $actionCode
     * @param mixed $profile
     * @return CaffeineJunkies_CronProfiles_Helper_Data
     */
    public function addError($data, $actionCode = null, $profile = null)
    {
        return $this->addEntry($actionCode, $profile, $data, $type = CaffeineJunkies_CronProfiles_Model_Profile_Log::TYPE_ERROR);
    }

    /**
     * Assign the profile id to the helper for default usage
     * 
     * @param int
     * @return CaffeineJunkies_CronProfiles_Helper_Data
     */
    public function setProfileId($_profileId)
    {
        $this->_profileId = $_profileId;
        return $this;
    }

    /**
     * Assign the action code to the helper for default usage
     * 
     * @param string
     * @return CaffeineJunkies_CronProfiles_Helper_Data
     */
    public function setActionCode($_actionCode)
    {
        $this->_actionCode = $_actionCode;
        return $this;
    }

    /**
     * Gets the currently assigned profile id
     * 
     * @return int
     */
    public function getProfileId()
    {
        return $this->_profileId;
    }

    /**
     * Gets the currently assigned action code
     * 
     * @return string
     */
    public function getActionCode()
    {
        return $this->_actionCode;
    }

    /**
     * Adds an entry to the log.
     * 
     * @param string $actionCode
     * @param mixed $profile
     * @param string $data
     * @param string $type
     * @return CaffeineJunkies_CronProfiles_Helper_Data
     */
    public function addEntry($actionCode, $profile, $data, $type = CaffeineJunkies_CronProfiles_Model_Profile_Log::TYPE_MESSAGE)
    {
        if(is_null($profile))
        {
            $profile = $this->getProfileId();
            if(!$profile)
            {
                Mage::throwError($this->__('No profile specified for logging.'));
            }
        }
        if(is_null($actionCode))
        {
            $actionCode = $this->getActionCode();
            if(!$actionCode)
            {
                Mage::throwError($this->__('No action code specified for logging.'));
            }
        }
        $log = Mage::getModel('cronprofiles/profile_log');
        $log->setActionCode($actionCode);
        if(is_object($profile))
        {
            $profile = $profile->getId();
        }
        $log->setProfileId($profile);
        $log->setLoggedData($data);
        $log->setLogType($type);
        $log->save();
        return $this;
    }
}