# php_image_to_html
 converts image to html  [PITH SITE](http://ghostff.com/oop/?Php_Image_To_Html=php)


for one match
```php

/*
OKAY DONT JUST RUN THE CODE. DELETE EVERY OTHER ECHO AND LEAVE JUST ONE DEFAULT OR WITH CUSTOM PREFRENCE
Sample:
*/
require_once('funcs.min.php');
echo img_to_htm::render('images/test.png');

/*
******************************Note: acceptable images type: 'png, jpeg and gif'**********************************
FUNC.MIN USE
@1param images name with path
@2param width(leave empty or null to use default width)
@3param height(leave empty or null to use default height)
@4param return type ('string' return html character) leave null or empty to exeute returned html
*/
require_once('funcs.min.php');
//return rendered image with default attribute
echo img_to_htm::render('images/test.png');
//return rendered image with default width multiplied by 4
echo img_to_htm::render('images/test.png', 4);
//return rendered image with default height multiplied by 4
echo img_to_htm::render('images/test.png', null, 4);
//return rendered image with default width and height multiplied by 4
echo img_to_htm::render('images/test.png', 4, 4);
//return rendered image (raw string) with default attribute
echo img_to_htm::render('images/test.png', null, null. 'string');
//return rendered image (raw string) with default width and height multiplied by 4
echo img_to_htm::render('images/test.png', 4, 4, 'string');


/*
******************************Note: acceptable images type: 'png, jpeg and gif'**********************************
MINI USE
@1param images name with path
@2param add attribute to conatiner and child element  (dont change parent and child key name*)
--------more
	change div to any html tag if you dont wonna use div as parrent holder (free to modify attribute) NOTE: more attribute more process
	change span to any html tag if you dont wonna use span as child  (free to modify attribute) NOTE: more attribute more process
@3param width(leave empty or null to use default width)
@4param height(leave empty or null to use default height)
@5param return type ('string' return html character) leave null or empty to exeute returned html
@6param color format acceptabele value 'HEX' (leave empty to use RGBA)
@7param style type acceptabe values 'IL' or inline(write style inside tags style attribut) (leave empty to use style tag)
*/
require_once('funcs.php');
$image_attribute = array('parent' => array('div' => array('id' => 'did', 'style' => 'border:1px solid #000;')), //container
						 'child'  => array('span' => array('class' => 'scl', 'data-id' => 'nw_datat_id'))//child
						);
//return rendered image with default attribute
echo img_to_htm::render('any_image.jpg', $image_attribute);
//return rendered image with default width multiplied by 4
echo img_to_htm::render('images/test.png', $image_attribute, 4);
//return rendered image with default height multiplied by 4
echo img_to_htm::render('images/test.png', $image_attribute, null, 4);
//return rendered image with default width and height multiplied by 4
echo img_to_htm::render('images/test.png', $image_attribute, 4, 4);
//return rendered image (raw string) with default attribute
echo img_to_htm::render('images/test.png', $image_attribute, null, null. 'string');
//return rendered image (raw string) with default width and height multiplied by 4
echo img_to_htm::render('images/test.png', $image_attribute, 4, 4, 'string');
//return rendered image with default attribute and HEX format of background color(less load for browser)
echo img_to_htm::render('images/test.png', $image_attribute, null, null, null, 'HEX');
//return rendered image with default attribute and inline style type(more load for browser)
echo img_to_htm::render('images/test.png', $image_attribute, null, null, null, null, 'IL');
```