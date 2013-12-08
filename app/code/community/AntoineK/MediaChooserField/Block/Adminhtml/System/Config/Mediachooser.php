<?php

/**
 * @category    AntoineK
 * @package     AntoineK_MediaChooserField
 * @copyright   Copyright (c) 2013 Antoine Kociuba (http://www.antoinekociuba.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author      Antoine Kociuba
 */
class AntoineK_MediaChooserField_Block_Adminhtml_System_Config_Mediachooser extends Mage_Adminhtml_Block_System_Config_Form_Field {

    /**
     * Generates media chooser field with links to media gallery and fullscreen view
     *
     * @param Varien_Data_Form_Element_Abstract
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {

        $field = new AntoineK_MediaChooserField_Data_Form_Element_Mediachooser;

        $data = array(
            'name'      => $element->getName(),
            'html_id'   => $element->getId(),
        );

        $field->setData($data);
        $field->setValue($element->getValue());
        $field->setForm($element->getForm());
        $field->addClass('input-text');

        return $field->getElementHtml();
    }

    /**
     * Add some JS to render in order to disable buttons if inherit checkbox is checked
     * Thx Hervé G. ;-) - Twitter : @vrnet
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html = parent::render($element);

        $html .= '
            <script type="text/javascript">
            //<![CDATA[
                var inheritCheckbox = $(\'' . $element->getId() . '_inherit\');
                if(inheritCheckbox && inheritCheckbox.checked) {
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
