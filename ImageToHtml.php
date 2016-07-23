<?php

class ImageToHtml
{
    /*
    *
    * gets the color of a selected pixel
    * from image pixel table
    *
    * returns string of color
    * @param image name for extension extraction
    * @param absolute column
    * @param absolute row
    *
    */
    private static function imageColor($name, $x, $y)
    {
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        
        if ($ext == 'png') {
            $image = imagecreatefrompng($name);
        }
        elseif ($ext == 'jpeg' || $ext == '.jpg') {
            $image = imagecreatefromjpeg($name);
        }
        elseif ($ext == 'gif') {
            $image = imagecreatefromgif($name);
        }
        
        $rgb  = imagecolorat($image, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        $hex = str_pad(dechex($r), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($g), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($b), 2, "0", STR_PAD_LEFT);
        
        return $hex;
    }
    
   /*
    *
    * gets the color of a selected pixel using
    * the imageColor function
    * 
    * get adjusts processing time and memory<br>
    * limit according to image size
    *
    * returns array of image name, hight and width
    * @param selected image name
    *
    */
    private static function getPixelColor($img)
    {    
        $image = array();
        
        list($width, $height) = getimagesize($img);
        
        if ($width * $height > 33760) {
            set_time_limit(0);
            ini_set('memory_limit', '950M');
        }
        
        for ($i = 0; $i < $height; $i++) {
            for ($k = 0; $k < $width; $k++) {
                $image[] = self::imageColor($img, $k, $i);
            }
        }
        
        return array('pixel' => $image, 
                     'W' => $width,
                     'H' => $height);
    }
    
    /*
    *
    * use an i tag to replace every pixel from
    * image table, where the hight and width of 
    * the tag depends on your specefied value
    * this is set to 1 by default.
    * 
    *
    * returns string of rendered image html elements
    * @param array of image name, hight and width
    * @param pixel width incrementation
    * @param pixel height incrementation
    */
    private static function align($data, $width, $height)
    {
        $img_color  = $data['pixel'];
        $img_height = $data['H'];
        $img_width  = $data['W'];
        
        $parent = '<div id="dHksl">';
        $child  = '<i style="';
        $HTML     = '<style>#dHksl';
        $HTML  .= '{width:' . $img_width * $width;
        $HTML  .= 'px;height:' . $img_height * $height;
        $HTML  .= 'px;}#dHksl i{width:' . $width . 'px;';
        $HTML  .= 'height:' . $height . 'px;float:left;}';
        $HTML  .= '</style>' . $parent;
        
        foreach ($img_color as $key => $pxl_color) {
            $HTML .= $child.'background:#'.$pxl_color.';"></i>';
        }
        return $HTML . '</div>';
    }
    
    /*
    *
    * calls all required renderings methods
    *
       * returns string of image HTML elements
    * @param pixel width incrementation default 1
    * @param pixel height incrementation default 1
    */
    public static function render($name, $width = 1, $height = 1)
    {
        if (!file_exists($name)) {
            return 'image ' . $name . 'Not found';
        }
         
        return self::align(self::getPixelColor($name),
                            $width, $height);
    } 
}
