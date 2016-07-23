# php_image_to_html
 converts image to html  [PITH SITE](http://ghostff.com/oop/?Php_Image_To_Html=php)


for one match
```php

require_once('ImageToHtml.php');
echo ImageToHtml::render('images/test.png');

/*
******************************Note: acceptable images type: 'png, jpeg and gif'**********************************

//return rendered image with default attribute
echo ImageToHtml::render('images/test.png');
//return rendered image with default width multiplied by 4
echo ImageToHtml::render('images/test.png', 4);
//return rendered image with default height multiplied by 4
echo ImageToHtml::render('images/test.png', null, 4);
//return rendered image with default width and height multiplied by 4
echo ImageToHtml::render('images/test.png', 4, 4);


```