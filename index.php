<?php
require_once('funcs.php');
foreach(find_img::matches('file.png', 'find', 1) as $key => $image_matches){
	var_dump($image_matches);
}
?>
