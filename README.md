AntoineK_MediaChooserField
==========================


The Media Chooser form element is an alternative to the default Image form element. It relies on the native ```Mediabrowser``` JS implementation and offers much more ease to upload, delete, organise and select your images across the media folder.

1 - Press the 'Select Image' button.


![magento-media-chooser-field-1](http://www.antoinekociuba.com/wp-content/uploads/2014/03/magento-media-chooser-field111.png)
-----



2 - Pick up or upload the image you want.


![magento-media-chooser-field-2](http://www.antoinekociuba.com/wp-content/uploads/2014/03/magento-media-chooser-field2.png)
-----


3 - You are done!


![magento-media-chooser-field-3](http://www.antoinekociuba.com/wp-content/uploads/2014/03/magento-media-chooser-field3.png)
-----

## System/Config form field

It is ready to be used on the 'System -> Configuration' admin area.
Just declare your frontend_type and frontend_model as below, on your system.xml file:

```
<frontend_type>text</frontend_type>
<frontend_model>mediachooserfield/adminhtml_system_config_mediachooser</frontend_model>
```

For example:

```
<test_field>
    <label>Test field</label>
    <frontend_type>text</frontend_type>
    <frontend_model>mediachooserfield/adminhtml_system_config_mediachooser</frontend_model>
    <sort_order>10</sort_order>
    <show_in_default>1</show_in_default>
    <show_in_website>1</show_in_website>
    <show_in_store>1</show_in_store>
</test_field>
```

## Custom admin module form field

You can also use that form element directly from your custom module admin area.
However, you will need to declare that new form element on your module form class, in the ```_prepareForm``` method like:

```
$fieldset = $form->addFieldset('my_fieldset', array('legend'=> $this->__('Mi Fieldset')));

$fieldset->addType('mediachooser','AntoineK_MediaChooserField_Data_Form_Element_Mediachooser');

$fieldset->addField('my_media_chooser_field', 'mediachooser', array(
    'name'      => 'my_media_chooser_field',
    'label'     => $this->__('My Media Chooser Field'),
    'title'     => $this->__('My Media Chooser Field'),
));
```

The line ```$fieldset->addType('mediachooser','AntoineK_MediaChooserField_Data_Form_Element_Mediachooser');``` adds a new form element type.
You can then simply use the media chooser form element by entering the ```mediachooser``` type.

You will also need to include manually necessary JS/CSS files.
To do so, just add ```<update handle="editor" />``` and ```<update handle="adminhtml_browser_js_overload" />``` inside your admin layout xml file, for example:

```
<adminhtml_yourmodulename_yourcontrollername_edit>
      <update handle="editor" />
      <update handle="adminhtml_browser_js_overload" />
</adminhtml_yourmodulename_yourcontrollername_edit>
```

The ```editor``` handle automatically includes necessary JS/CSS files such as flexuploader.js, browser.js etc...
You can check what it does exactly on the ```app/design/adminhtml/default/default/layout/main.xml``` file, around the line 168 (Magento 1.7.0.2).

The ```adminhtml_browser_js_overload``` overload the insert method of Mediabrowser (browser.js) to dispatch a custom event.
This event will be responsible to update the image preview and button label.

## Widget form field

Like the System/Config method, just declare your widget type as below, on your widget.xml file:

```
<type>mediachooserfield/adminhtml_widget_mediachooser</type>
```

For example:

```
<test_field>
    <label>Test field</label>
    <type>mediachooserfield/adminhtml_widget_mediachooser</type>
</test_field>
```

## Category/Product form field

Edit Observer.php setMediaChooserFieldRenderer method and define field(s) you want to use with the Media Chooser.

For example:

```
$yourField = $form->getElement('your_field');
if ($yourField) {
    $yourField->setRenderer(
        Mage::app()->getLayout()->createBlock('mediachooserfield/adminhtml_catalog_form_renderer_attribute_mediachooser')
    );
}
```

## How-To use on the frontend

When you select an image from the media browser, the value returned is formated like ```wysiwyg/yourfilename.yourfileextension```.
So when you will reuse that value on the frontend, you would need to prefix it with ```Mage::getBaseUrl('media')``` in order to get a working and conventional URL.

Enjoy! ;-)
