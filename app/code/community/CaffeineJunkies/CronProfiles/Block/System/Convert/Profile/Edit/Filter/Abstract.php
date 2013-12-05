<?php
/**
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Grid filter abstract
 *
 * @category   CaffeineJunkies
 * @package    CaffeineJunkies_CronProfiles
 * @author     Patrick McKinley <patrick.w.mckinley@gmail.com>
 */
class CaffeineJunkies_CronProfiles_Block_System_Convert_Profile_Edit_Filter_Abstract
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Abstract
{
    /**
     * This gets the log type items from the config.xmls
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
        return $rootNode->{$this->_enumType} ? $rootNode->{$this->_enumType}->children() : null;
    }
    
    /**
     * Generates the dropdown for the filtering in the grid.
     * 
     * @return string
     */
    public function getHtml()
    {
        $values = $this->_getValuesAsArray();
        $value = $this->getValue();

        $html  = '<select name="' . ($this->getColumn()->getName() ? $this->getColumn()->getName() : $this->getColumn()->getId()) . '" ' . $this->getColumn()->getValidateClass() . '>';
        foreach ($values as $k => $v) {
            $html .= '<option value="'.$k.'"' . ($value == $k ? ' selected="selected"' : '') . '>'.$v.'</option>';
        }
        $html .= '</select>';
        return $html;
    }
    
    /**
     * Turns the configuration elements into an array for the html generator.
     * 
     * @return array
     */
    protected function _getValuesAsArray($emptyFirst = true)
    {
        $_configItems = $this->_getConfigEnums();
        
        $values = array();
        if($emptyFirst)
        {
            $values[''] = '';
        }
        
        foreach($_configItems as $code=>$node)
        {
            if($node->translate)
            {
                $values[$code] = Mage::helper($node->translate)->__((string) $node->label);
            }
            else
            {
                $values[$code] = (string) $node->label;
            }
        }
        return $values;
    }
}