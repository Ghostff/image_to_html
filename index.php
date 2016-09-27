
<?php

require_once 'src/ImageToHtml.php';

echo 'before edit';

echo ImageToHtml::render('images/test.png');



ImageToHtml::replace('c71414', '999999');
ImageToHtml::replace('fff^+', 'ADA700'); //or (custom regex) ImageToHtml::replace('fe0:\w+', '333');

//ImageToHtml::replace('0:[1|2|0]0\w+', 'efefef');

/*
* replaces colors like this:
* (0106ff)
* (0007ff)
* (0206fd)
* (0004fd)
*
* with efefef
*/

//echo ImageToHtml::listColors('images/test.png');
//var_dump( ImageToHtml::listColors('images/test.png', true, true));

echo 'after edit';
echo ImageToHtml::render('images/test.png');


