<?php
/**
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

//include the controller we wish to extend.
require_once 'Mage/Adminhtml/controllers/System/Convert/ProfileController.php';

/**
 * Displays the grid for the log items..
 *
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @author     Patrick McKinley <patrick.w.mckinley@gmail.com>
 */
class CaffeineJunkies_CronProfiles_System_Convert_ProfileController extends 
    Mage_Adminhtml_System_Convert_ProfileController
{
    /**
     * Profile log grid loader.
     */
    public function logAction() {
        $this->_initProfile();
        $this->getResponse()->setBody($this->getLayout()->createBlock('cronprofiles/system_convert_profile_edit_tab_log')->toHtml());
    }
}