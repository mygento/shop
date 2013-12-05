<?php
/**
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Log collection
 *
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @author     Patrick McKinley <patrick.w.mckinley@gmail.com>
 */
class CaffeineJunkies_CronProfiles_Model_Mysql4_Profile_Log_Collection extends
    Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('cronprofiles/profile_log');
        parent::_construct();
    }
}