<?php
	require_once('funcs.php');
	foreach(find_img::matches('image.png', 'find', 3) as $image_matches){
		var_dump($image_matches);
	}
?>

