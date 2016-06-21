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
        if ($format == '.png') {
            $image = imagecreatefrompng($image_name);
        }
        elseif ($format == '.jpeg' || $format == '.jpg') {
            $image = imagecreatefromjpeg($image_name);
        }
        elseif ($format == '.gif') {
            $image = imagecreatefromgif($image_name);
        }
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
        $new_image = array();
        //assign returned array(2) to width and height
        list($width, $height) = getimagesize($img);
        
        //prevent process timing out and maxing out memory
        if ($width*$height > 33760) {
            set_time_limit(0);
            ini_set('memory_limit', '950M');
        }
        //loop through col and rows of pixels to get color output(00, 01, 02, 03, 04...)
        for ($i = 0; $i < $height; $i++) {
            for ($k = 0; $k < $width; $k++) {
                $new_image[] = self::image_color($img, $k, $i);
            }
        }
        //pixel conatains all the colors gotten from pixel while W and H is the image width and height
        return array('pixel' => $new_image, 'W' => $width, 'H' => $height);
    }
    //make image and span have a corresponding with and height
    private static function align($image_data, $width = null, $height = null)
    {
        //set default property for height, width (for null args)
        if (!$width) {
            $width = 1;
        }
        if (!$height) {
            $height = 1;
        }
        $img_color     = $image_data['pixel'];//array of all colors found in each pixel
        $img_height = $image_data['H'];//int of image height
        $img_width     = $image_data['W'];//int of image width
        
        $parent = '<div id="dHksl">';
        $child    = '<i style="';
        $HTML = '<style>#dHksl{width:'.$img_width*$width.'px;height:'.$img_height*$height;
        $HTML .= 'px;}#dHksl i{width:'.$width.'px;height:'.$height.'px;float:left;}</style>';
        $HTML .= $parent;
        foreach ($img_color as $key => $pxl_color) {
            $HTML .= $child.'background:#'.$pxl_color.';"></i>';
        }
        return($HTML.'</div>');
    }
    public static function render($img_name, $width = null, $height = null, $type = null)
    {
        //debuger: remove this line (if image is always specified)
        if (!file_exists($img_name)) {
            return 'image ' . $img_name . 'Not found';
        }    
        if ($type == 'string') {
            return htmlspecialchars(self::align(self::ttl_pxls($img_name),  $width, $height));
        }
        else {
            return self::align(self::ttl_pxls($img_name), $width, $height);
        }
    }
    
}

?>
