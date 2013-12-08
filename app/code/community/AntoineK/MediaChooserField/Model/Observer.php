<?php

/**
 * @category    AntoineK
 * @package     AntoineK_MediaChooserField
 * @copyright   Copyright (c) 2013 Antoine Kociuba (http://www.antoinekociuba.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author      Antoine Kociuba
 */
class AntoineK_MediaChooserField_Model_Observer {

    /**
     * Add the 'editor' handle if 'mediachooser' field is being used
     *
     * @return AntoineK_MediaChooserField_Model_Observer
     */
    public function updateEditorHandle(Varien_Event_Observer $observer) {
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
                        $layout->getUpdate()->addHandle('editor');
                        break;
                    }
                }
            }
        }
        return $this;
    }

}