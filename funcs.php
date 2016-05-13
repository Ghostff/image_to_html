<?php
class img_to_htm
{
	//@param 1: image name
	//@param 2: col of pixel
	//@param 3: row of pixel
	private static function image_color($image_name, $x, $y, $color)
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
		//convert rgba to hex
		if($color == 'HEX'){
			$nw_colors = str_pad(dechex($colors['red']), 2, "0", STR_PAD_LEFT);
			$nw_colors .= str_pad(dechex($colors['green']), 2, "0", STR_PAD_LEFT);
			$nw_colors .= str_pad(dechex($colors['blue']), 2, "0", STR_PAD_LEFT);
			$nw_colors = '#'.$nw_colors;
		}
		else
			$nw_colors = 'rgba('.implode(',', $colors).',1)';
		return $nw_colors;
	}
	//get the color in each pixel and size of a specified image
	//@param 1 image name
	private static function ttl_pxls($img, $color)
	{
		$m = $new_image = array();
		//assign width and height image getimagesize to to $width and $heeight
		list($width, $height) = getimagesize($img);
		//total number of pixels in image
		for($i = 0; $i < $height; $i++)
			for($k = 0; $k < $width; $k++)
				$new_image[] = self::image_color($img, $k, $i, $color);
		return array('pixel' => $new_image, 'W' => $width, 'H' => $height);
	}
	//make image and span have a corresponding with and height
	private static function align($image_data, $holder, $child, $width, $height, $styl_type)
	{
		//set default property for height, width and oppcaity(when arg is null)
		if(!$width) $width = 1;
		if(!$height) $height = 1;
		
		$img_color 	= $image_data['pixel'];
		$img_height = $image_data['H'];
		$img_width 	= $image_data['W'];
		$img_size  	= $img_height * $img_width;
		$HTML = $parent = $children = $p_tag = $c_tag = $parent_sty = $children_sty = $nw_clas = $new_id = $p_atr = $c_atr = '';
		
		//generate a holder with specified attributes
		foreach($holder as $key => $attr){
			$p_atr = $key;//get container html tag name
			$parent = '<'.$key.' ';
			foreach($attr as $attribute => $value){
				if($attribute == 'id')//geting id if attribute has id
					$new_id = '#'.$value;
				else if($attribute == 'class')//geting class if attribute has class
					$nw_clas = '.'.$value;
				if($attribute == 'style')
					$parent_sty = $value;
				else
					$parent .= $attribute.'="'.$value.'" ';
			}
			if($styl_type == 'IL' || $styl_type == 'inline')
				$parent .= 'style="width:'.$img_width*$width.'px;height:'.$img_height*$height.'px;'.$parent_sty.'">';
			else
				$parent .= 'style="'.$parent_sty.'">';
		}
		//use tag name if no id or class
		if($new_id)
			$p_tag = $new_id;
		else if($nw_clas)
			$p_tag = $nw_clas;
		else
			$p_tag = $p_atr;
		$nw_clas = $new_id = '';
		//generate a holder with specified attributes
		foreach($child as $key => $attr){
			$c_atr = $key;//get conatainer child html tag name
			$children = '<'.$key.' ';
			foreach($attr as $attribute => $value){
				if($attribute == 'id')//geting id if attribute has id
					$new_id = '#'.$value;
				else if($attribute == 'class')//geting class if attribute has class
					$nw_clas = '.'.$value;
					
				if($attribute == 'style')
					$children_sty = $value;
				else
					$children .= $attribute.'="'.$value.'" ';
			}
			if($styl_type == 'IL' || $styl_type == 'inline')
				$children .= 'style="width:'.$width.'px;height:'.$height.'px;float:left;';
			else
				$children .= 'style="';	
		}
		//use tag name if no id or class
		if($new_id)
			$c_tag = $new_id;
		else if($nw_clas)
			$c_tag = $nw_clas;
		else
			$c_tag = $c_atr;

		if($styl_type == 'IL' || $styl_type == 'inline')
			$HTML = $parent;
		else{
			$HTML = '<style>'.$p_tag.'{width:'.$img_width*$width.'px;height:'.$img_height*$height.'px;}'.$p_tag.' '.$c_tag.'{width:'.$width.'px;height:'.$height.'px;float:left;}</style>';
			$HTML .= $parent;
		}
			
		foreach($img_color as $key => $pxl_color)
			$HTML .= $children.'background:'.$pxl_color.';'.$children_sty.'"></'.$c_atr.'>';
		return($HTML.'</'.$p_atr.'>');
	}
	public static function render($img_name, $htm, $width = null, $height = null, $type = null, $color = null, $styl_type = null)
	{
		//debuger remove this line (if image is always specified)
		if(!file_exists($img_name))
			return 'invalid image';
			
		//prevent process from timing out
		set_time_limit(0);
		if($type == 'string')
			return htmlspecialchars(self::align(self::ttl_pxls($img_name, $color), $htm['parent'], $htm['child'],  $width, $height, $styl_type));
		else 
			return self::align(self::ttl_pxls($img_name, $color), $htm['parent'], $htm['child'],  $width, $height, $styl_type);
	}
	
}


?>