<?php
/**
 * @category    AntoineK
 * @package     AntoineK_MediaChooserField
 * @copyright   Copyright (c) 2013 Antoine Kociuba (http://www.antoinekociuba.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author      Antoine Kociuba
 */
require_once 'Mage/Adminhtml/controllers/Cms/Wysiwyg/ImagesController.php';

class AntoineK_MediaChooserField_Adminhtml_Cms_Wysiwyg_Images_ChooserController extends Mage_Adminhtml_Cms_Wysiwyg_ImagesController
{

    /**
     * Fire when select image.
     *
     * @return void
     */
    public function onInsertAction()
    {
        $helper = Mage::helper('cms/wysiwyg_images');
        $storeId = $this->getRequest()->getParam('store');

        $filenameParam = $this->getRequest()->getParam('filename');
        $filename = $helper->idDecode($filenameParam);

        Mage::helper('catalog')->setStoreId($storeId);
        $helper->setStoreId($storeId);

        // Generate and return the wysiwyg image link  (i.e. wysiwyg/YOUR_FILE_NAME.YOUR_FILE_EXTENSION)
        $fileUrl = $helper->getCurrentUrl() . $filename;
        $mediaPath = str_replace(Mage::getBaseUrl('media'), '', $fileUrl);

        $this->getResponse()->setBody($mediaPath);
    }

}