<?php
if(isset($_POST['submit'])){
	require_once('funcs.php');
	foreach(find_img::matches($_FILES['selected']['name'], 'find', 3) as $image_matches){
		var_dump($image_matches);
	}
}
?>
<form method="post" action="index.php" enctype="multipart/form-data">
	<input type="file" name="selected">
    <input type="submit" value="uploade" name="submit">
</form>
