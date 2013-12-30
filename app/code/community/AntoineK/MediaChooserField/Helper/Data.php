<?php
/**
 * @category    AntoineK
 * @package     AntoineK_MediaChooserField
 * @copyright   Copyright (c) 2013 Antoine Kociuba (http://www.antoinekociuba.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author      Antoine Kociuba
 */
class AntoineK_MediaChooserField_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Render Media Chooser HTML (buttons and image preview) and set it after the form element HTML
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return Varien_Data_Form_Element_Abstract
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {

        if (Mage::getSingleton('admin/session')->isAllowed('cms/media_gallery')) {

            $layout = $element->getForm()->getParent()->getLayout();
            $id = $element->getForm()->getHtmlIdPrefix() . $element->getHtmlId();
            $imagePreview = '';

            if ($url = $element->getValue()) {
                if(!preg_match("/^http\:\/\/|https\:\/\//", $url)) {
                    $url = Mage::getBaseUrl('media') . $url;
                }

                $imagePreview = '<a href="' . $url . '" style="text-decoration: none;"'
                    . ' onclick="imagePreview(\'' . $id . '_image\'); return false;">'
                    . ' <img src="' . $url . '" id="' . $id . '_image" title="' . $element->getValue() . '"'
                    . ' alt="' . $element->getValue() . '" height="30" class="small-image-preview v-middle"/>'
                    . ' </a>';
            }

            $selectButtonId = 'add-image-' . mt_rand();
            $chooserUrl = Mage::getUrl('adminhtml/cms_wysiwyg_images_chooser/index', array('target_element_id' => $id));
            $label = ($element->getValue()) ? $this->__('Change Image') : $this->__('Select Image');


            // Select/Change Image Button
            $chooseButton = $layout->createBlock('adminhtml/widget_button')
                ->setType('button')
                ->setClass('add-image')
                ->setId($selectButtonId)
                ->setLabel($label)
                ->setOnclick('MediabrowserUtility.openDialog(\'' . $chooserUrl . '\')')
                ->setDisabled($element->getReadonly())
                ->setStyle('display:inline;margin-top:7px');

            // Remove Image Button
            $removeButton = $layout->createBlock('adminhtml/widget_button')
                ->setType('button')
                ->setClass('delete')
                ->setLabel($this->__('Remove Image'))
                ->setOnclick('document.getElementById(\''. $id .'\').value=\'\';'
                    . ' if(document.getElementById(\''. $id .'_image\'))document.getElementById(\''. $id .'_image\').parentNode.remove();'
                    . ' document.getElementById(\''. $selectButtonId .'\').innerHTML=\'<span><span><span>'.$this->__('Select Image').'</span></span></span>\'')
                ->setDisabled($element->getReadonly())
                ->setStyle('margin-top:7px');


            $wrapperStart = '<div id="buttons_' . $id . '" class="buttons-set" style=" width: 325px;">';
            $wrapperEnd = '</div>';

            // Add our custom HTML after the form element
            $element->setAfterElementHtml($wrapperStart . $imagePreview . $chooseButton->toHtml() . $removeButton->toHtml() . $wrapperEnd);
        }

        return $element;
    }
}