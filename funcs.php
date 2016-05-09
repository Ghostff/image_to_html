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
	//calcuate image match percentage
	private static function cal_perc($decrease, $original)
	{
		$percentage = $decrease / $original * 100;
		return round($percentage, 0).'%';
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
		return array(self::cal_perc($new_size, $size), $name);
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
	//@param 1 (string) image protoype name
	//@param 2 (array)	directory to search for image and they image format to search for
	//------args
		//1st element
			//path/dir to search for image matches
		//2nd element
			//image formats to search for in path/dir specified in 1st element
				//'jpg' searches for match in jpg or jpeg images type alone
				//'png' searches for match in png images type alone
				//'gif' searches for match in gif images type alone
				//'all' searches for match in all images type (jpg, png, gif)
	//@param 3 (int, null, string) length of matches to return 
	//---------args	
		//(int) ----args
				//if 0 function return nothing
				//if 1 function returns 1 image with highest match
				//if 2 or more function retrun 2 or more images with matches(this is random)
		//(null) ---args
				//if empty or null function returns all macthes from specified dir
		//(string)--args
				//if '100%' function return all image with 100% match
				//if '68%' function return all image with 68% match
	public static function matches($img, $pat_nd_fmt, $return = null)
	{
		$image_match = array();
		$img = self::get_total_pixels($img);
		$i = 0;
		//check match type
		$pat_nd_fmt[1] = ($pat_nd_fmt[1] == 'all')? glob($pat_nd_fmt[0]."/*.{png,jpg,jpeg,gif}", GLOB_BRACE) : glob($pat_nd_fmt[0]."/*.png");
		foreach ($pat_nd_fmt[1] as $_new_image) {
			$new_image = self::get_total_pixels($_new_image);
			$image_matched = self::arr_diff($img['pixel'], $new_image['pixel'], $img['size'], $_new_image, $return);
			if($return == 1 && $image_matched[0] == '100%'){
				//return only only one match of image
				$image_match = array($image_matched);
				break;
			}
			else if($return === null){
				//return all matches of image
				$image_match[] = $image_matched;
			}
			else if(is_int($return) &&  $return != 0){
				//return any specified number of image matches
				$image_match[] = $image_matched;
				if($i == $return)
					break;
				$i++;
			}
			else if(is_string($return) && $image_matched[0] == '100%'){
				//return any specified number of image matches
				$image_match[] = $image_matched;
				if($i == $return)
					break;
				$i++;
			}
			else
				die('invalid arg');
		}
		arsort($image_match);
		return array_filter($image_match);
		//return $image_match;
	}
}
?>