<?php
/**
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Displays the tabs on the right of the page.
 *
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @author     Patrick McKinley <patrick.w.mckinley@gmail.com>
 */
class CaffeineJunkies_CronProfiles_Block_System_Convert_Profile_Edit_Tabs extends 
    Mage_Adminhtml_Block_System_Convert_Profile_Edit_Tabs
{
    /**
     * Set up the tabs on the left of the screen.
     * 
     * @return CaffeineJunkies_CronProfiles_Block_System_Convert_Profile_Edit_Tabs
     */
    protected function _beforeToHtml()
    {
        $new = !Mage::registry('current_convert_profile')->getId();

        $this->addTab('edit', array(
            'label'     => Mage::helper('adminhtml')->__('Profile Actions XML'),
            'content'   => $this->getLayout()->createBlock('adminhtml/system_convert_profile_edit_tab_edit')->initForm()->toHtml(),
            'active'    => true,
        ));

        if (!$new) {
            $this->addTab('run', array(
                'label'     => Mage::helper('adminhtml')->__('Run Profile'),
                'content'   => $this->getLayout()->createBlock('adminhtml/system_convert_profile_edit_tab_run')->toHtml(),
            ));

            $this->addTab('history', array(
                'label'     => Mage::helper('adminhtml')->__('Profile History'),
                'content'   => $this->getLayout()->createBlock('adminhtml/system_convert_profile_edit_tab_history')->toHtml(),
            ));
            
            $this->addTab('log', array(
                'label'     => Mage::helper('cronprofiles')->__('Profile Log'),
                'content'   => $this->getLayout()->createBlock('cronprofiles/system_convert_profile_edit_tab_log')->toHtml(),
            ));
        }
        //skip the parent, and go to the grandparent instead.
        return Mage_Adminhtml_Block_Widget_Tabs::_beforeToHtml();
    }
}
