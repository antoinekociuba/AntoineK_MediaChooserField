<?php
/**
 * @category    AntoineK
 * @package     AntoineK_MediaChooserField
 * @copyright   Copyright (c) 2013 Antoine Kociuba (http://www.antoinekociuba.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author      Antoine Kociuba
 */
class AntoineK_MediaChooserField_Data_Form_Element_Mediachooser extends Varien_Data_Form_Element_Text
{
    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
    }

    public function getElementHtml()
    {

        return parent::getElementHtml() . $this->_getButtonsHtml();
    }

    /**
     * Return Media Chooser bottom buttons HTML
     *
     * @return string
     */
    protected function _getButtonsHtml()
    {
        $buttonsHtml = '<div id="buttons_' . $this->getHtmlId() . '" class="buttons-set">';
        $buttonsHtml .= $this->_getPluginButtonsHtml(true);
        $buttonsHtml .= '</div>';

        return $buttonsHtml;
    }

    /**
     * Prepare Html buttons for Media Chooser features
     *
     * @param bool $visible Display buttons or not
     * @return string
     */
    protected function _getPluginButtonsHtml($visible = true)
    {
        $buttonsHtml = '';
        $buttonsHtml .= $this->_getButtonHtml(array(
            'title' => $this->translate('Select an image'),
            'onclick' => "MediabrowserUtility.openDialog('" . 
                Mage::getUrl('adminhtml/cms_wysiwyg_images_chooser/index', array(
                    'target_element_id' => $this->getHtmlId()
                )) . ((null !== $this->getConfig('store_id')) ? ('store/' . $this->getConfig('store_id') . '/') : '') . "')",
            'class' => 'add-image',
            'style'     => $visible ? 'margin-top:8px;' : 'display:none;'
        ));

        $fieldValue = $this->getValue();
        if(is_object($fieldValue)){
            $fieldValue = $fieldValue->asArray();
        }
        
        if ((bool)$fieldValue && !empty($fieldValue)) {
            $mediaUrl = Mage::getBaseUrl('media');

            $buttonsHtml .= $this->_getButtonHtml(array(
                'title' => $this->translate('Open in fullscreen'),
                'onclick' => 'window.open(\''.$mediaUrl.'\'+document.getElementById(\''.$this->getHtmlId().'\').value)',
                'class' => 'show-hide',
                'style'     => $visible ? 'margin-top:8px;' : 'display:none;'
            ));
        }

        return $buttonsHtml;
    }

    /**
     * Return custom button HTML
     *
     * @param array $data Button params
     * @return string
     */
    protected function _getButtonHtml($data)
    {
        $html = '';
        if ($data['class'] != 'add-variable plugin') {
            $html .= '<button type="button"';
            $html.= ' class="scalable ' . (isset($data['class']) ? $data['class'] : '') . '"';
            $html.= isset($data['onclick']) ? ' onclick="' . $data['onclick'] . '"' : '';
            $html.= isset($data['style']) ? ' style="' . $data['style'] . '"' : '';
            $html.= isset($data['id']) ? ' id="' . $data['id'] . '"' : '';
            $html.= '>';
            $html.= isset($data['title']) ? '<span>' . $data['title'] . '</span>' : '';
            $html.= '</button>';
        }
        return $html;
    }

    /**
     * Media Chooser config retriever
     *
     * @param string $key Config var key
     * @return mixed
     */
    public function getConfig($key = null)
    {
        if (!($this->_getData('config') instanceof Varien_Object)) {
            $config = new Varien_Object();
            $this->setConfig($config);
        }
        if ($key !== null) {
            return $this->_getData('config')->getData($key);
        }
        return $this->_getData('config');
    }

    /**
     * Translate string using defined helper
     *
     * @param string $string String to be translated
     * @return string
     */
    public function translate($string)
    {
        if ($this->getConfig('translator') instanceof Varien_Object) {
            return $this->getConfig('translator')->__($string);
        }
        return $string;
    }

}
