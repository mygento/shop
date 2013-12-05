<?php
/**
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Displays the grid for the log items..
 *
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @author     Patrick McKinley <patrick.w.mckinley@gmail.com>
 */
class CaffeineJunkies_CronProfiles_Block_System_Convert_Profile_Edit_Tab_Log extends 
	Mage_Adminhtml_Block_Widget_Grid
{
	/**
	 * Constructor - sets up all the grid elements, and the default sort.
	 */
    public function __construct()
    {
        parent::__construct();
        $this->setId('log_grid');
        $this->setDefaultSort( 'logged_at', 'desc');
        $this->setUseAjax(true);
    }

	/**
	 * Prepare the collection of log items
	 * 
	 * @return CaffeineJunkies_CronProfiles_Block_System_Convert_Profile_Edit_Tab_Log
	 */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('cronprofiles/profile_log_collection')
            ->addFieldToFilter('profile_id', Mage::registry('current_convert_profile')->getId());
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

	/**
	 * Prepare the column headers, with translation.
	 * 
	 * @return CaffeineJunkies_CronProfiles_Block_System_Convert_Profile_Edit_Tab_Log
	 */
    protected function _prepareColumns()
    {
        $this->addColumn('log_type', array(
            'header'    => Mage::helper('cronprofiles')->__('Message Type'),
            'index'     => 'log_type',
            'width'		=> '150px',
            'filter'    => 'cronprofiles/system_convert_profile_edit_filter_type',
            'renderer'  => 'cronprofiles/system_convert_profile_edit_renderer_type',
        ));
        
        $this->addColumn('action_code', array(
            'header'    => Mage::helper('cronprofiles')->__('Log Action'),
            'index'     => 'action_code',
            'width'		=> '150px',
            'filter'    => 'cronprofiles/system_convert_profile_edit_filter_action',
            'renderer'  => 'cronprofiles/system_convert_profile_edit_renderer_action',
        ));

        $this->addColumn('logged_at', array(
            'header'    => Mage::helper('cronprofiles')->__('Logged At'),
            'type'      => 'datetime',
            'index'     => 'logged_at',
            'width'     => '150px',
        ));

        $this->addColumn('logged_data', array(
            'header'    => Mage::helper('cronprofiles')->__('Output'),
            'index'     => 'logged_data',
        ));

        return parent::_prepareColumns();
    }

	/**
	 * Return the path that is used for updating the grid.
	 * 
	 * @return string
	 */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/log', array('_current' => true));
    }
}