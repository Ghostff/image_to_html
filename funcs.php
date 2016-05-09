<?php
class find_img{
	//@param 1: image name
	//@param 2: col of pixel
	//@param 3: row of pixel
	private static function image_color($image_name, $x, $y, $type)
	{
		//get image type
		$format = strstr($image_name, '.');
		if($format == '.png')
			$image = imagecreatefrompng($image_name);
		else if($format == '.jpeg' || $format == '.jpg')
			$image = imagecreatefromjpeg($image_name);
		else if($format == '.gif')
			$image = imagecreatefromgif($image_name);
		$rgba  = imagecolorat($image, $x, $y);
		$colors = imagecolorsforindex($image, $rgba);
		array_pop($colors);
		return ($type != 'all')? implode(',', $colors) : $colors;
	}
	//get diffrents in multiple arrays
	private static function arr_diff($array1, $array2, $size, $name)
	{
		$new_array = array();
		$new_size = $size;
		for($i = 0; $i < $size; $i++){
			if(implode(',', $array1[$i]) != implode(',', $array2[$i])){
				$new_size--;
			}
		}
		//if image has no match return
		if($new_size == 0)
			return;
		return array($new_size-$size, $name);
	}
	//get the color in each pixel of a specified image
	//@param 1 image name
	private static function get_total_pixels($img)
	{
		$m = $new_image = array();
		//assign width and height image getimagesize to to $width and $heeight
		list($width, $height) = getimagesize($img);
		//total number of pixels in image
		for($i = 0; $i < $height; $i++)
			for($k = 0; $k < $width; $k++)
				$m[] = $i.$k;
	
		foreach($m as $n){
			//split two char and asign them to a string
			list($col, $row) = str_split($n);
			$new_image[] = self::image_color($img, $row, $col, 'all');
		}
		return array('pixel' => $new_image, 'size' => $width * $height);
	}
	//find images the matches specified images
	//@param 1 image protoype name
	//@param 2 path of the image to serch for
	//@param 3 what to resturn 
	//---------args	
		//'all' return all that have atleast one or more matches
		//'1' return 1 image with highest match
		//'2' retrun 2 images with more match and more
	public static function matches($img, $path_to_find, $return)
	{
		$image_match = array();
		$img = self::get_total_pixels($img);
		$i = 0;
		foreach (glob($path_to_find."/*.png") as $_new_image) {
			$new_image = self::get_total_pixels($_new_image);
			$image_matched = self::arr_diff($img['pixel'], $new_image['pixel'], $img['size'], $_new_image, $return);
			if($return == 1 && $image_matched[0] == 0){
				//return only only one match of image
				$image_match = $image_matched;
				break;
			}
			else if($return == 'all'){
				//return all matches of image
				$image_match[] = $image_matched;
			}
			else if(is_numeric($return)){
				//return any specified number of image matches
				$image_match[] = $image_matched[1];
				if($i == $return)
					break;
				$i++;
			}	
		}
		arsort($image_match);
		return array_filter($image_match);
		//return $image_match;
	}
}
?>