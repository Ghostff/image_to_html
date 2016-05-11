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
	private static function get_total_pixels($img)
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
	private static function align($image_data, $holder, $child, $width = null, $height = null, $opacity = null)
	{
		//set default property for height, width and oppcaity(when arg is null)
		if(!$width) $width = 1;
		if(!$height) $height = 1;
		if(!$opacity) $opacity = 1;
		$img_color 	= $image_data['pixel'];
		$img_height = $image_data['H'];
		$img_width 	= $image_data['W'];
		$img_size  	= $img_height * $img_width;
		
		var_dump($img_height, $img_width, $img_size);
		$HTML = $parent = $children = $parent_tag = $children_tag = $parent_sty = $children_sty = '';
		//generate a holder with specified attributes
		foreach($holder as $key => $attr){
			$parent_tag = $key;//get container html tag name
			$parent = '<'.$key.' ';
			foreach($attr as $attribute => $value)
				if($attribute == 'style')
					$parent_sty = $value;
				else
					$parent .= $attribute.'="'.$value.'" ';
			$parent .= 'style="width:'.$img_size*$width.'px;height:'.$img_size*$height.'px;'.$parent_sty.'">';
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
			$children .= 'style="width:'.$img_width*$width.'px;height:'.$img_height*$height.'px;float:left; text-align:center;';
		}
		$HTML = $parent;
		foreach($img_color as $key => $pxl_color){
			//var_dump($pxl_color);
			$HTML .= $children.'background:rgba('.$pxl_color.','.$opacity.');'.$children_sty.'">'.$key.'</'.$children_tag.'>';
		}
			
/*		var_dump($img_height, $img_width, $img_size);	
		var_dump($HTML);*/	
		echo($HTML);
		
		//$html = ;
	}
	public static function v($image_name)
	{
		//prevent process from timing out
		set_time_limit(0);
		self::align(self::get_total_pixels($image_name),
					array('div' => array('id' => 'hid', 'class' => 'hclas')), 
					array('span' => array('class' => 'sclas', )), 
					40,
					2,
					1);
		//var_dump(self::get_total_pixels($image_name)); 'style' => 'border:1px solid #fff;'
	}
	
}


?>