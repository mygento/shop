<?php
/**
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Log Resource Model
 *
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @author     Patrick McKinley <patrick.w.mckinley@gmail.com>
 */
class CaffeineJunkies_CronProfiles_Model_Mysql4_Profile_Log extends 
    Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('cronprofiles/profile_log', 'log_id');
    }

    /**
     * Make sure the logged-at date is set.
     * 
     * @param Mage_Core_Model_Abstract
     * @return CaffeineJunkies_CronProfiles_Model_Mysql4_Profile_Log
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getLoggedAt()) {
            $object->setLoggedAt($this->formatDate(time()));
        }
        parent::_beforeSave($object);
        return $this;
    }
    
    /**
     * Remove all log entries older than the specified time.
     * 
     * @param timestamp
     * @return int
     */
    public function removeOlderThan($logTimeout)
    {
        $logTimeout = date("Y-m-d H:i:s" , strtotime("-{$logTimeout} days"));
        $table = Mage::getSingleton('core/resource')->getTableName('cronprofiles/profile_log');
        $connection = $this->_getWriteAdapter();

        $condition = $connection->quoteInto('logged_at < ?', $logTimeout);
        return $connection->delete($table, $condition);
    }
}