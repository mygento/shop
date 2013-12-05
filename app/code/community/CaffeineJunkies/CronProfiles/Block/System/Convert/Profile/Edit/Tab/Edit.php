<?php
/**
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Extends the core tab to add the cron elements.
 *
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @author     Patrick McKinley <patrick.w.mckinley@gmail.com>
 */
class CaffeineJunkies_CronProfiles_Block_System_Convert_Profile_Edit_Tab_Edit extends 
	Mage_Adminhtml_Block_System_Convert_Profile_Edit_Tab_Edit
{
	/**
	 * Generates the form
	 * 
	 * @return CaffeineJunkies_CronProfiles_Block_System_Convert_Profile_Edit_Tab_Edit
	 */
    public function initForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('_edit');

        $model = Mage::registry('current_convert_profile');

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('adminhtml')->__('General Information')));
        
    	$fieldset->addField('name', 'text', array(
            'name' => 'name',
            'label' => Mage::helper('adminhtml')->__('Profile Name'),
            'title' => Mage::helper('adminhtml')->__('Profile Name'),
            'required' => true,
        ));
        
        $values = array('NULL'=>'-- '.Mage::helper('cronprofiles')->__('Select One').' --');
        $users = Mage::getResourceModel('admin/user_collection');
        foreach($users as $i=>$user)
        {
        	$values[$user->getUserId()] = $user->getFirstname().' '.$user->getLastname();
        }
        
        $checked = 0;
        if($model->getEnableCron() == 1)
        {
        	$checked = 1;
        }
        $model->setEnableCronTmp(1);
        
        $fieldset->addField('enable_cron_tmp','checkbox', array(
        	'name'		=>	'enable_cron_tmp',
            'label'		=>	Mage::helper('cronprofiles')->__('Enable Cronjob'),
            'value'		=>	1,
            'checked'	=>	$checked,
        ));
        
    	$fieldset->addField('run_as_user_id', 'select', array(
            'name' => 'run_as_user_id',
            'label' => Mage::helper('cronprofiles')->__('Run as User'),
            'title' => Mage::helper('cronprofiles')->__('Run as User'),
            'values' => $values
        ));
    	$fieldset->addField('cron_expr', 'text', array(
            'name' => 'cron_expr',
            'label' => Mage::helper('cronprofiles')->__('Cron Expression'),
            'title' => Mage::helper('cronprofiles')->__('Cron Expression'),
        ));

    	$fieldset->addField('actions_xml', 'textarea', array(
            'name' => 'actions_xml',
            'label' => Mage::helper('adminhtml')->__('Actions XML'),
            'title' => Mage::helper('adminhtml')->__('Actions XML'),
            'style' => 'width:500px; height:400px',
            'required' => true,
        ));

        $form->setValues($model->getData());

        $this->setForm($form);

        return $this;
    }
}