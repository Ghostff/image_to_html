<?php
//NOT WORKING
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
		$rgb  = imagecolorat($image, $x, $y);
		//get RGB (red, green, blue)
		$r = ($rgb >> 16) & 0xFF;
		$g = ($rgb >> 8) & 0xFF;
		$b = $rgb & 0xFF;
		//Convert RGB to Hex
	    $hex = str_pad(dechex($r), 2, "0", STR_PAD_LEFT);
	    $hex .= str_pad(dechex($g), 2, "0", STR_PAD_LEFT);
	    $hex .= str_pad(dechex($b), 2, "0", STR_PAD_LEFT);
		return $hex;
	}
	//get the color in each pixel and size of a specified image
	//@param 1 image name
	private static function ttl_pxls($img)
	{
		$m = $new_image = array();
		//assign width and height image getimagesize to to $width and $heeight
		list($width, $height) = getimagesize($img);
		$i = $k = 0;
		if($width*$height > 4671)
			session_start();
		//total number of pixels in image
		$i = (@!$_SESSION['last'][0]) ? 0 : $_SESSION['last'][0];
		for($i; $i < $height; $i++){
			$k = (@!$_SESSION['last'][1])? 0 : $_SESSION['last'][1];
			for($k; $k < $width; $k++){
				if(session_id())
					$_SESSION['last'] = array($i, $k);
				$new_image[] = self::image_color($img, $k, $i);
			}
		}
		return array('pixel' => $new_image, 'W' => $width, 'H' => $height);
	}
	//make image and span have a corresponding with and height
	private static function align($image_data, $width = null, $height = null)
	{
		//set default property for height, width and oppcaity(when arg is null)
		if(!$width) $width = 1;
		if(!$height) $height = 1;
		
		$img_color 	= $image_data['pixel'];
		$img_height = $image_data['H'];
		$img_width 	= $image_data['W'];

		$parent = '<div id="dHksl">';
		$child	= '<i style="';
		$HTML = '<style>#dHksl{width:'.$img_width*$width.'px;height:'.$img_height*$height.'px;}#dHksl i{width:'.$width.'px;height:'.$height.'px;float:left;}</style>';
		$HTML .= $parent;
		foreach($img_color as $key => $pxl_color)
			$HTML .= $child.'background:#'.$pxl_color.';"></i>';
		
/*		if(@$_SESSION['last'])
			unset($_SESSION['last']);*/
		return($HTML.'</div>');
	}
	public static function render($img_name, $width = null, $height = null, $type = null)
	{
		//debuger remove this line (if image is always specified)
		if(!file_exists($img_name))
			return 'invalid image';
			
		//prevent process from timing out
		set_time_limit(0);
		if($type == 'string')
			return htmlspecialchars(self::align(self::ttl_pxls($img_name),  $width, $height));
		else 
			return self::align(self::ttl_pxls($img_name), $width, $height);
	}
	
}

?>
