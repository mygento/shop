<?php
/**
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Profile Log Model
 *
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @author     Patrick McKinley <patrick.w.mckinley@gmail.com>
 */
class CaffeineJunkies_CronProfiles_Model_Profile_Log extends Mage_Core_Model_Abstract
{
    /**
     * Basic message types
     * @var string
     */
    const TYPE_MESSAGE = 'message';
    const TYPE_NOTICE = 'notice';
    const TYPE_ERROR = 'error';
    
    protected function _construct()
    {
        $this->_init('cronprofiles/profile_log');
    }

    /**
     * Ensure that the profile ID is set, using the current profile
     * 
     * @return CaffeineJunkies_CronProfiles_Model_Profile_Log
     */
    protected function _beforeSave()
    {
        if (!$this->getProfileId()) {
            $profile = Mage::registry('current_convert_profile');
            if ($profile) {
                $this->setProfileId($profile->getId());
            }
        }

        parent::_beforeSave();
        return $this;
    }
}