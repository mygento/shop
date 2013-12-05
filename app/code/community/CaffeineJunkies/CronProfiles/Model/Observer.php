<?php
/**
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * CronProfiles Observer
 *
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @author     Patrick McKinley <patrick.w.mckinley@gmail.com>
 */
class CaffeineJunkies_CronProfiles_Model_Observer extends
    Mage_Core_Model_Abstract
{
    /**
     * Time interval between cron runs.(in minutes)
     * @var int
     */
    protected $_minutes = 5;
    
    /**
     * Run the profiles setup for cron on the right schedule
     * 
     * @param Varien_Event_Observer $observer
     * @return CaffeineJunkies_CronProfiles_Model_Observer
     */
    public function runScheduledProfiles($observer)
    {
        //if the module is active, run the crons.
        if(Mage::getStoreConfig('admin/cronprofiles/active'))
        {
            //run all the cronjobs that are in the next five minutes.
            $now = time();
            
            $scheduleAheadFor = $now + ($this->_minutes*60);
            
            $profiles = Mage::getResourceModel('dataflow/profile_collection')
                ->addFieldToFilter('enable_cron', array('eq'=>'1'))->load();
                
            $schedule = Mage::getModel('cron/schedule');
            
            $profilesToRun = array();
            
            foreach($profiles as $profile)
            {
                if(is_null($profile->getCronExpr()) || $profile->getRunAsUserId() == '')
                {
                    continue;
                }
                
                $schedule->setCronExpr($profile->getCronExpr());
                
                for($time = $now; $time < $scheduleAheadFor; $time += 60)
                {
                    $ts = strftime('%Y-%m-%d %H:%M:00', $time);
                    
                    if ($schedule->trySchedule($ts)) {
                        // time does match cron expression
                        $profilesToRun[] = $profile;
                    }
                }
            }
            
            // run profiles after the list has been compiled - to make sure that the list is complete.
            if(count($profilesToRun) > 0)
            {
                foreach($profilesToRun as $profile)
                {
                    $profile->run();
                }
            }
            
            //clear the logs
            if($logTimeout = Mage::getStoreConfig('admin/cronprofiles/log_timeout'))
            {
                $logResource = Mage::getResourceModel('cronprofiles/profile_log');
                $logResource->removeOlderThan($logTimeout);
            }
        }
        
        return $this;
    }
}