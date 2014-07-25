CmsRewrites
===========

Small Magento extension that allows you to generate rewrites rules for cms pages for different stores.

Compatibility
-------------

The extension was tested on Magento CE-1.7.0.2 to CE-1.9.0.1, but most probably works on other versions also.

What it does
------------

This extension provides an UI for generating URL rewrites faster.
The extension makes sense only if you have 2 or more store views on your website.

Let's take the following example.
You have 3 store views in 3 languages.  English (en), French (fr) and German (de).  
You have a page that explains how your store ships the goods. But for SEO purposes you created 3 CMS pages each one available only in one language with a different url key.  

 - 'shipping' for en
 - 'livraison' for fr
 - 'versand' for de

Everything works OK, except when the customer changes the language while visiting one of the pages mentioned above. Then he might get 404 error because the page 'shipping' does not exist in the fr store.

This extension allows you to generate url rewrites for these pages so the en 'shipping' page will change to 'livraison' when changing to fr.

How it does it
-------------

If you go to CMS->CMS pages URL rewrites you will see a screen like below.  

<img src="http://i.imgur.com/X4jsCCA.png" alt="cms rewrites" />

You can add as many URL rewrites at once using the `Add rewrite` top right button.
If you change your mind you can remove any before saving.

Using the example above you will enter the data as follows:

 - Store English: shipping
 - Store French: livraison
 - Store German: versand
 - Redirect: Permanent(301)

Then hit save.
The result is that the following url rewrites will be added to the `core_url_rewrite` table.

|Store|Request Path|Target Path|
|----|-----|-------|
|English|livraison|shipping|
|English|versand|shipping|
|French|shipping|livraison|
|French|versand|livraison|
|German|shipping|versand|
|German|livraison|versand|

Let's take a other example.  For a contact page. The url's should be like this:

 - Store English: contact
 - Store French: contact
 - Store German: kontakt
 - Redirect: Permanent(301)

This will generate the following rewrites

|Store|Request Path|Target Path|
|----|-----|-------|
|English|kontakt|contact|
|French|kontakt|contact|
|German|contact|kontakt|

If you don't want to generate rewrite for a website just leave the field blank.

In addition to what is described above, the extension adds a mass delete action to the url rewrites grid, so you can delete them faster in case you screw something up.

License
---------
This extension is distributed under the <a href="http://opensource.org/licenses/mit-license.php" target="_blank">MIT License</a>

Class rewrites
---------
The extension does not rewrite any core classes.
Thanks @ProxiBlue for explaining how to <a href="http://magento.stackexchange.com/a/8966/146" target="_blank">add a mass action using an observer.</a>

Uninstall
-----------
To uninstall this extension you need to remove the following files and folders

 - `app/etc/modules/Easylife_CmsRewrites.xml`
 - `app/code/community/Easylife/CmsRewrites/`
 - `app/design/adminhtml/default/default/layout/easylife_cmsrewrites.xml`
 - `app/design/adminhtml/default/default/template/easylife_cmsrewrites/`
 - `js/easylife_cmsrewrites/rewrite.js`
 - `app/locale/en_US/Easylife_CmsRewrites.csv`

If you want to remove the urls you generated with this extension you can identify them in the Catalog url rewrites grid by their ID Path. It starts with `cmsrewrite_`.

Issues and Feature Requests
-------------
Please submit any issue or feature request <a href="https://github.com/tzyganu/CmsRewrites/issues">here</a>.