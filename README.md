AntoineK_MediaChooserField
==========================


The Media Chooser form element is an alternative to the default Image form element. It relies on the native ```Mediabrowser``` JS implementation and offers much more ease to upload, delete, organise and select your images across the media folder.

It is ready to be used on the 'System -> Configuration' admin area.
Just declare your frontend_type as below, on your system.xml file:

```
<frontend_type>mediachooser</frontend_type>
```

For example:

```
<test_field>
    <label>Test field</label>
    <frontend_type>mediachooser</frontend_type>
    <sort_order>10</sort_order>
    <show_in_default>1</show_in_default>
    <show_in_website>1</show_in_website>
    <show_in_store>1</show_in_store>
</test_field>
```

You can also use that form element directly from your custom module admin area.
However, you will have to include manually necessary JS/CSS files.

To do so, you just need to add ```<update handle="editor" />``` inside your admin layout xml file, for example:

```
<adminhtml_yourmodulename_yourcontrollername_edit>
      <update handle="editor" />
</adminhtml_yourmodulename_yourcontrollername_edit>
```

The editor handle automatically include necessary JS/CSS files such as flexuploader.js, browser.js etc...
You can check what it does exactly on the ```app/design/adminhtml/default/default/layout/main.xml``` file, around the line 168.



When you select an image from the media browser, the value returned is formated like ```wysiwyg/yourfilename.yourfileextension```.
So when you will reuse that value on the frontend, you would need to prefix it with ```Mage::getBaseUrl('media')``` in order to keep and respect an absolute URL.

Enjoy!
