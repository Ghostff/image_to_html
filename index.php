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
//
echo img_to_htm::render('test.png');
//
echo img_to_htm::render('test.png', 4, 4);
?>

