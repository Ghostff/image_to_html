<?php
$img = 'file1.png';
function dubuger()
{
	echo htmlspecialchars('$colors = image_color($img, '.$row.','.$col.');
				echo \'<div style="width:40px; height:40px; border:1px solid #000; background:rgba(\'.$colors.\',1.00);"></div>'.$col.','.$row.'\';');
		echo '<br>';
}
//@param 1: image name
//@param 2: col of pixel
//@param 3: row of pixel
function image_color($image_name, $x, $y){
	$image = imagecreatefrompng($image_name);
	$rgba = imagecolorat($image, $x, $y);
	$colors = imagecolorsforindex($image, $rgba);
	array_pop($colors);
	return implode(',', $colors);
}
function get_total_pixels($img)
{
	$m = array();
	$new_image = '';
	//assign width and height image getimagesize to to $width and $heeight
	list($width, $height) = getimagesize($img);
	//total number of pixels in image
	//if image width is bigger than the height
	if($width > $height){
		for($i = 0; $i < $width; $i++)
			for($k = 0; $k < $height; $k++)
				$m[] = $i.$k;
	}//if height is bigger than width
	else{
		for($i = 0; $i < $height; $i++)
			for($k = 0; $k < $width; $k++)
				$m[] = $i.$k;
	}
	$new_image = '<div style="width:'.$width.'px; height: '.$height.'px; border:1px solid #000;">';
	foreach($m as $n){
		list($col, $row) =  str_split($n);
		$bg = image_color($img, $row, $col);
		$new_image .= '<div style="background:rgba('.$bg.', 1); width:1px; height:1px; float:left;"></div>';
		
	}
	$new_image .'<div>';
	return $new_image;
}
echo get_total_pixels($img);
?>
<!--<div style="width:40px; height:40px; border:1px solid #000; background:rgba(<?php echo $colors; ?>,1.00);"></div>-->