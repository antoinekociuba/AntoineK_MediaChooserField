<?php
/**
 * @category    AntoineK
 * @package     AntoineK_MediaChooserField
 * @copyright   Copyright (c) 2013 Antoine Kociuba (http://www.antoinekociuba.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author      Antoine Kociuba
 */
class AntoineK_MediaChooserField_Block_Adminhtml_Widget_Mediachooser extends Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset_Element
{

    /**
     * Render media chooser buttons and image preview HTML after the element
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        Mage::helper('mediachooserfield')->render($element);
        
        $this->_element = $element;
        return $this->toHtml();
    }
}