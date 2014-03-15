<?php
/**
 * @category    AntoineK
 * @package     AntoineK_MediaChooserField
 * @copyright   Copyright (c) 2013 Antoine Kociuba (http://www.antoinekociuba.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author      Antoine Kociuba
 */
class AntoineK_MediaChooserField_Block_Adminhtml_Catalog_Form_Renderer_Attribute_Mediachooser extends Mage_Adminhtml_Block_Catalog_Form_Renderer_Fieldset_Element
{

    /**
     * Render media chooser buttons and image preview HTML after the element
     * Add some JS in order to disable buttons if inherit checkbox is checked
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $element = Mage::helper('mediachooserfield')->render($element);

        $html = parent::render($element);

        $html .= '
            <script type="text/javascript">
            //<![CDATA[
                var inheritCheckbox = $(\'' . $element->getId() . '_inherit\');
                if(inheritCheckbox && inheritCheckbox.checked) {url_key
                    $$(\'#buttons_' . $element->getId() . ' button\').each(function(el) {
                        el.addClassName(\'disabled\');
                        el.setAttribute(\'disabled\', \'disabled\');
                    });
                    $(\'' . $element->getId() . '\').addClassName(\'disabled\').disable();
                }
            //]]>
            </script>
        ';

        return $html;
    }

}