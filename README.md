# php_image_search
searches for images that look same or almost same with a specified image

for one match
```php
/*
Were @1param is the image to find
     @2param is the folder/path to search for image that matches param 1
     @3param sum of matches to return
note: @3param can take 2 data types on int(0-9). and can only take string('all') arg
if @3param is '1' it return a (string) of match
else if (int)[2-9] or (string)['all'] it returns an (array) value of matches 
*/

#1 match (lesser time) returns 1 image that matched
    echo find_img::matches('image.png', 'find', 1);
    
#2 match (2x slower) returns 2 image that matched
    var_dump( find_img::matches('image.png', 'find', 2));
    
#3 match (3x slower) returns 3 image that matched
     var_dump( find_img::matches('image.png', 'find', 3));
     
#...

#all match (more time) returns all image that matched
     var_dump( find_img::matches('image.png', 'find', 'all'));
```