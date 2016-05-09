# php_image_search
searches for images that look same or almost same with a specified image

for one match
```php
var_dump(find_img::matches('find_img_that_look_like_me.png', array('find_folder', 'all'), 1));
/*
//Note: acceptable image type: 'png, jpeg and gif'
--------------------BREAKDOWN--------------------
@1param 'image to find a match'
@2param array('folder/dir to search for images that matches @1param', 'type of image to search for')
@3param the count of matches to return

	================== ACCEPTABLE VALUES ========================
	@1param 'image.(png, jpeg or gif)'
	@2param array('image_folder', 'all, png, jpeg or gif')
	@3param (any number, '100%(will return all that is 100% matched)', null or empty)
 
*/
#find an image that is 100% matched and under a jpg format
var_dump(find_img::matches('find_img_that_look_like_me.png', array('find_folder', 'jpg'), 1));
var_dump(find_img::matches('find_img_that_look_like_me.png', array('find_folder', 'jpg'), '100%'));

#find 5 image matches under a jpg format
var_dump(find_img::matches('find_img_that_look_like_me.png', array('find_folder', 'jpg'), 5));
#find 5 image matches under a png format
var_dump(find_img::matches('find_img_that_look_like_me.png', array('find_folder', 'png'), 5));
#find 5 image matches under a gif format
var_dump(find_img::matches('find_img_that_look_like_me.png', array('find_folder', 'gif'), 5));

#find 5 matched images under any format
var_dump(find_img::matches('find_img_that_look_like_me.png', array('find_folder', 'all'), 5));

#find 5 images under any format and 90% matched
var_dump(find_img::matches('find_img_that_look_like_me.png', array('find_folder', 'all'), '90%'));

#find all matches under any image format
var_dump(find_img::matches('find_img_that_look_like_me.png', array('find_folder', 'all')));


-----INDEX.PRO
require_once('funcs.php');
var_dump(find_img::matches('find_img_that_look_like_me.png', array('find_folder', 'all')));
```