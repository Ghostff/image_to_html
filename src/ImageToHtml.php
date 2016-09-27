<?php

class ImageToHtml
{
    private static $replace_holder = array();
    
    private static $replacment = false;
    
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
        $hex  = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
        $hex .= str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
        $hex .= str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
        
        return $hex;
    }
    
    /*
    *
    * replace all selected color from image
    * with specified color
    * 
    * if no specified color selected color will
    * become transparent
    *
    * returns null
    * @param color to replace from image
    * @param color replacement
    *
    */
    public static function replace($oldColor, $newColor = null)
    {
        self::$replacment = true;
        $oldColor = strtolower($oldColor);
        self::$replace_holder[$oldColor] = $newColor;
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
                $image[] = static::imageColor($img, $k, $i);
            }
        }
        
        return array(
            'pixel'  => $image, 
            'width'  => $width,
            'height' => $height
        );
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
        $img_height = $data['height'];
        $img_width  = $data['width'];
        
        $parent = '<div id="dHksl">';
        $child  = '<i style="';
        
        $HTML   = '<style>#dHksl';
        $HTML  .= '{width:' . $img_width * $width;
        $HTML  .= 'px;height:' . $img_height * $height;
        $HTML  .= 'px;}#dHksl i{width:' . $width . 'px;';
        $HTML  .= 'height:' . $height . 'px;float:left;}';
        $HTML  .= '</style>' . $parent;
        
        foreach ($img_color as $pxl_color) {
            
            if (self::$replacment) {
                
                foreach (self::$replace_holder as $key => $value) {
                    
                    if ($key == $pxl_color) {
                        $pxl_color = $value;
                    }
                    else {
                        if (strpos($key, '^') !== false) {
                            
                            $pathern = str_replace('^', '\w+', $key);
                            if (preg_match('/^' . $pathern . '$/', $pxl_color)) {
                                $pxl_color = $value;
                            }
                        }
                        elseif (strpos($key, ':') !== false) {
                            
                            $pathern = str_replace(':', '', $key);
                            if (preg_match('/^' . $pathern . '$/', $pxl_color)) {
                                $pxl_color = $value;
                            }    
                        }    
                    }
                }
            }

            
            $HTML .= $child.'background:#'.$pxl_color.';"></i>';
        }
        
        return $HTML . '</div>';
    }
    
    /*
    *
    * list out all the colors a specified image has
    *
    * returns string or array
    * @param image name
    * @param allow single instance of each color (default true)
    * @param return color as array (default false)
    *
    */
    public static function listColors($name = null, $uniq = true, $array = false)
    {
        if ( ! file_exists($name)) {
            return 'image ' . $name . 'Not found';
        }
        
        $colors = null;
        $exist = array();
        $data = static::getPixelColor($name);
        
        foreach ($data['pixel'] as $color) {
            
            if ($uniq) {
                
                if (in_array($color, $exist)) {
                    continue;
                }
                else {
                    $exist[] = $color;    
                }
            }
            
            if ($color == 'ffffff') {
                $new_color = $color . ';text-shadow:0 0 1px #000;';
            }
            else {
                $new_color = $color;    
            }
            $colors .= '<code style="color:#' . $new_color . '">
                            (' . $color . ')&#x025AE;
                       </code><br />';
        }
        
        return ($array)? $exist ?: $data['pixel'] : $colors;
    }
    
    /*
    *
    * calls all required renderings methods
    *
    * returns string of image HTML elements
    * @param pixel width incrementation (default 1)
    * @param pixel height incrementation (default 1)
    *
    */
    public static function render($name, $width = 1, $height = 1)
    {
        if ( ! file_exists($name)) {
            return 'image ' . $name . 'Not found';
        }
        
        return static::align(static::getPixelColor($name), $width, $height);
    } 
}
