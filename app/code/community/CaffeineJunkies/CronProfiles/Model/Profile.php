<?php
/**
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Profile Model - 
 *
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @author     Patrick McKinley <patrick.w.mckinley@gmail.com>
 */
class CaffeineJunkies_CronProfiles_Model_Profile extends Mage_Dataflow_Model_Profile
{
    /**
     * Make sure the enable-cron boolean is formatted correctly
     * 
     * @return CaffeineJunkies_CronProfiles_Model_Profile
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        if($this->getEnableCronTmp() && $this->getEnableCronTmp() == 1)
        {
            $this->setEnableCron(1);
        }
        else
        {
            $this->setEnableCron(0);
        }
    }
    
    /**
     * Run profile - Overridden to account for the profile_history model expecting a session var.
     *
     * @return CaffeineJunkies_CronProfiles_Model_Profile
     */
    public function run()
    {
        /**
         * Save history
         */
        $_phistory = Mage::getModel('dataflow/profile_history')
            ->setProfileId($this->getId());
        
        if($this->getRunAsUserId())
        {
            $_phistory->setUserId($this->getRunAsUserId());
        }
        $_phistory->setActionCode('run')
            ->save();

        /**
         * Prepare xml convert profile actions data
         */
        $xml = '<convert version="1.0"><profile name="default">'.$this->getActionsXml().'</profile></convert>';
        $profile = Mage::getModel('core/convert')
            ->importXml($xml)
            ->getProfile('default');
        /* @var $profile Mage_Dataflow_Model_Convert_Profile */

        try {
            $batch = Mage::getSingleton('dataflow/batch')
                ->setId(null)
                ->setProfileId($this->getId())
                ->setStoreId($this->getStoreId())
                ->save();
            $this->setBatchId($batch->getId());

            $profile->setDataflowProfile($this->getData());
            $profile->run();
        }
        catch (Exception $e) {
            echo $e;
        }

        $this->setExceptions($profile->getExceptions());
        return $this;
    }

}