<?php
/**
 * @category    AntoineK
 * @package     AntoineK_MediaChooserField
 * @copyright   Copyright (c) 2013 Antoine Kociuba (http://www.antoinekociuba.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author      Antoine Kociuba
 */
class AntoineK_MediaChooserField_Model_Observer
{

    /**
     * Product attributes to update
     */
    const XML_PATH_PRODUCT_ATTRIBUTES = 'global/mediachooser/catalog/product/attributes';

    /**
     * Category attributes to update
     */
    const XML_PATH_CATEGORY_ATTRIBUTES = 'global/mediachooser/catalog/category/attributes';

    /**
     * Add the 'editor' handle if 'mediachooser' field is being used
     *
     * @param Varien_Event_Observer $observer
     * @return AntoineK_MediaChooserField_Model_Observer
     */
    public function updateEditorHandle(Varien_Event_Observer $observer)
    {
        // Check if we are currently in Admin, System -> Configuration area
        if (Mage::app()->getStore()->isAdmin()
            && Mage::app()->getRequest()->getControllerName() == "system_config"
            && Mage::app()->getRequest()->getRouteName() == "adminhtml") {

            // Load system.xml files from all enabled modules
            $config = Mage::getConfig()->loadModulesConfiguration('system.xml');
            $xml = $config->getNode();

            // Grab all 'frontend_type' fields from the generated xml config
            $fieldTypes = $xml->xpath("//sections/*/groups/*/fields/*/frontend_model");

            if (count($fieldTypes)) {
                foreach ($fieldTypes as $node) {
                    // If at least one 'frontend_type' is 'mediachooser'
                    if ($node->asArray() == "mediachooserfield/adminhtml_system_config_mediachooser") {
                        $layout = $observer->getEvent()->getLayout();
                        // Add the 'editor' handle to the layout to automatically include media browser JS files
                        $layout->getUpdate()->addHandle('editor')
                            ->addHandle('adminhtml_browser_js_overload');
                        break;
                    }
                }
            }
        }

        // Check if we are currently in CMS, Widget -> Edit area
        if (Mage::app()->getStore()->isAdmin()
            && Mage::app()->getRequest()->getControllerName() == "widget_instance"
            && Mage::app()->getRequest()->getRouteName() == "adminhtml"
            && Mage::app()->getRequest()->getActionName() == "edit") {

            // Load widget.xml files from all enabled modules
            $config = Mage::getConfig()->loadModulesConfiguration('widget.xml');
            $xml = $config->getNode();

            // Grab all 'type' fields from the generated xml config
            $fieldTypes = $xml->xpath("//*/parameters/*/type");

            if (count($fieldTypes)) {
                foreach ($fieldTypes as $node) {
                    // If at least one 'type' is 'mediachooser'
                    if ($node->asArray() == "mediachooserfield/adminhtml_widget_mediachooser") {
                        $layout = $observer->getEvent()->getLayout();
                        // Add the 'editor' handle to the layout to automatically include media browser JS files
                        $layout->getUpdate()->addHandle('editor')
                            ->addHandle('adminhtml_browser_js_overload');
                        break;
                    }
                }
            }
        }
        return $this;
    }

    /**
     * Set Media Chooser field renderer on defined product form fields
     *
     * @param Varien_Event_Observer $observer
     * @return AntoineK_MediaChooserField_Model_Observer
     */
    public function setMediaChooserFieldRendererOnProductEditForm(Varien_Event_Observer $observer)
    {
        $form   = $observer->getEvent()->getForm();
        $attributes = Mage::getConfig()
            ->getNode(self::XML_PATH_PRODUCT_ATTRIBUTES);

        if ($attributes) {
            $fields = array_keys($attributes->asArray());
            $this->_setMediaChooserFieldRenderer($form, $fields);
        }

        return $this;
    }

    /**
     * Set Media Chooser field renderer on defined category form fields
     *
     * @param Varien_Event_Observer $observer
     * @return AntoineK_MediaChooserField_Model_Observer
     */
    public function setMediaChooserFieldRendererOnCategoryEditForm(Varien_Event_Observer $observer)
    {
        $form   = $observer->getEvent()->getForm();
        $attributes = Mage::getConfig()
            ->getNode(self::XML_PATH_CATEGORY_ATTRIBUTES);

        if ($attributes) {
            $fields = array_keys($attributes->asArray());
            $this->_setMediaChooserFieldRenderer($form, $fields);
        }

        return $this;
    }

    /**
     * Set Media Chooser field renderer on defined form fields
     *
     * @param Varien_Data_Form $form
     * @param array $fields The fields to update
     */
    protected function _setMediaChooserFieldRenderer($form, $fields)
    {
        foreach ($fields as $field) {
            if ($element = $form->getElement($field)) {
                $element->setRenderer(
                    Mage::app()->getLayout()->createBlock('mediachooserfield/adminhtml_catalog_form_renderer_attribute_mediachooser')
                );
            }
        }
    }

}
