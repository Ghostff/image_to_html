<?php

/*
******************************Note: acceptable image type: 'png, jpeg and gif'**********************************
MINI USE
@1param image name with path
@2param width(leave empty or null to use default width)
@3param height(leave empty or null to use default height)
@4param return type ('string' return html character) leave null or empty to exeute returned html
*/
require_once('funcs.min.php');
//return rendered image with default attribute
echo img_to_htm::render('image/test.png');
//return rendered image with default width multiplied by 4
echo img_to_htm::render('image/test.png', 4);
//return rendered image with default height multiplied by 4
echo img_to_htm::render('image/test.png', null, 4);
//return rendered image with default width and height multiplied by 4
echo img_to_htm::render('image/test.png', 4, 4);
//return rendered image (raw string) with default attribute
echo img_to_htm::render('image/test.png', null, null. 'string');
//return rendered image (raw string) with default width and height multiplied by 4
echo img_to_htm::render('image/test.png', 4, 4, 'string');
?>

