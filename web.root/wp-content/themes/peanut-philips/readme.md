#Peanut Theme Adaptation
This sample is a "child theme" deriving from the "philips" theme which supplies the requisite JQuery and Bootstrap support. 
Supporting 'action' code is found under ```plugins/peanut/peanut.php``` and the ```Tops/wordpress/TViewModel``` class found in
```plugins/peanut/src/tops```
##JQuery and Bootstrap 
To support Peanut, your theme must include the JQuery library 
as well as Bootstrap styles and javascript including modals. 

The 'philips' theme provides this in ```philips\functions.php```.   

```php
function philips_scripts() {
    // other code removed for clarity in the example
    	wp_enqueue_script( 'philips-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), '20120206', true );
}
```

##Template and Function Changes for Peanut

The sample includes some files that are typical for a Wordpress child theme:
```functions.php, screenshot.png and style.css```. 
Although required for the theme, these are not specific to Peanut. 
Your theme must include two simple adaptations for Peanut. 

Any CMS for Peanut must include a custom theme or "child theme" (sub-theme in Drupal) that provides templates for:
1. Insertion of the <service-messages> component container, just preceding the content section.  See ```Tops\wordpress\TViewModel::RenderMessageElements()```
and the template file ```template-parts/content-page.php```

1. Insertion of the view model start up script at the end of the page, immediately following the ```<\body>``` tag.
 See ```Tops\wordpress\TViewModel::RenderStartScript()``` and the template file
 ```footer.php```.
