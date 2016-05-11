<?php
class img_to_htm
{
	//@param 1: image name
	//@param 2: col of pixel
	//@param 3: row of pixel
	private static function image_color($image_name, $x, $y)
	{
		//get image type
		$format = strstr($image_name, '.');
		//create new image
		if($format == '.png')
			$image = imagecreatefrompng($image_name);
		else if($format == '.jpeg' || $format == '.jpg')
			$image = imagecreatefromjpeg($image_name);
		else if($format == '.gif')
			$image = imagecreatefromgif($image_name);
		//get index of color in pixels
		$rgba  = imagecolorat($image, $x, $y);
		//get color for index
		$colors = imagecolorsforindex($image, $rgba);
		//remove alpha from array(red, green, blue, alpha)
		array_pop($colors);
		return implode(',', $colors);
	}
	//get the color in each pixel and size of a specified image
	//@param 1 image name
	private static function ttl_pxls($img)
	{
		$m = $new_image = array();
		//assign width and height image getimagesize to to $width and $heeight
		list($width, $height) = getimagesize($img);
		//total number of pixels in image
		for($i = 0; $i < $height; $i++)
			for($k = 0; $k < $width; $k++)
				$new_image[] = self::image_color($img, $k, $i);
		//note the set of 'H' and 'W'
		return array('pixel' => $new_image, 'H' => $width, 'W' => $height);
	}
	//make image and span have a corresponding with and height
	private static function align($image_data, $holder, $child, $width = null, $height = null)
	{
		//set default property for height, width and oppcaity(when arg is null)
		if(!$width) $width = 1;
		if(!$height) $height = 1;
		
		$img_color 	= $image_data['pixel'];
		$img_height = $image_data['H'];
		$img_width 	= $image_data['W'];
		$img_size  	= $img_height * $img_width;
		$HTML = $parent = $children = $parent_tag = $children_tag = $parent_sty = $children_sty = '';
		
		var_dump($img_height, $img_width, $img_size);
		//generate a holder with specified attributes
		foreach($holder as $key => $attr){
			$parent_tag = $key;//get container html tag name
			$parent = '<'.$key.' ';
			foreach($attr as $attribute => $value)
				if($attribute == 'style')
					$parent_sty = $value;
				else
					$parent .= $attribute.'="'.$value.'" ';
			$parent .= 'style="width:'.$img_size*$width/(10).'px;height:'.$img_size*$height/(10).'px;'.$parent_sty.'">';
		}
		//generate a holder with specified attributes
		foreach($child as $key => $attr){
			$children_tag = $key;//get conatainer child html tag name
			$children = '<'.$key.' ';
			foreach($attr as $attribute => $value)
				if($attribute == 'style')
					$children_sty = $value;
				else
					$children .= $attribute.'="'.$value.'" ';
			$children .= 'style="width:'.$img_width*$width/(10).'px;height:'.$img_height*$height/(10).'px;float:left; text-align:center;';
		}
		$HTML = $parent;
		foreach($img_color as $key => $pxl_color)
			$HTML .= $children.'background:rgba('.$pxl_color.',1.0);'.$children_sty.'"></'.$children_tag.'>';
		return($HTML);
	}
	public static function render($img_name, $htm, $width, $height, $type)
	{
		//debuger remove this line (if image is always specified)
		if(!file_exists($img_name))
			return 'invalid image';
			
		//prevent process from timing out
		set_time_limit(0);
		if($type == 'string')
			return htmlspecialchars(self::align(self::ttl_pxls($img_name), $htm['parent'], $htm['child'],  $width, $height));
		else 
			return self::align(self::ttl_pxls($img_name), $htm['parent'], $htm['child'],  $width, $height);
	}
	
}


?>