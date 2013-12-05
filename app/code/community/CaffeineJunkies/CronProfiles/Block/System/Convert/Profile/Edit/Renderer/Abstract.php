<?php
/**
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Grid column renderer abstract
 *
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @author     Patrick McKinley <patrick.w.mckinley@gmail.com>
 */
class CaffeineJunkies_CronProfiles_Block_System_Convert_Profile_Edit_Renderer_Abstract
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Gets the configuration from the config.xmls
     * 
     * @param string $root
     * @return mixed
     */
    protected function _getConfigEnums($root = 'global')
    {
        $rootNode = Mage::getConfig()->getNode($root.'/cronprofiles');
        if (!$rootNode) {
            return null;
        }
        $name = $this->_enumType;
        return $rootNode->$name ? $rootNode->$name->children() : null;
    }
    
    /**
     * Renders the column value with translator.
     * 
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        $values = $this->_getConfigEnums();
        if($values->$value->translate)
        {
            $output = Mage::helper($values->$value->translate)->__((string) $values->$value->label);
        }
        else
        {
            $output = (string) $values->$value->label;
        }
        return $output;
    }
}