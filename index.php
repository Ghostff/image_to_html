<style>i{background:rgba(23,168,40,0.5);border:1px solid #17A828;color:#147e21;border-radius:3px;padding:0 5px;}</style>
<?php
if(isset($_POST['submit'])){
	require_once('funcs.php');
	foreach(find_img::matches($_FILES['selected']['name'], array('find', 'all')) as $image_matches){
		echo '<code> <i>'.$image_matches[1].'</i> is <i>'.$image_matches[0].'</i> matched with uploaded image</code><p />';
	}
}
?>
<form method="post" action="index.php" enctype="multipart/form-data">
	<input type="file" name="selected">
    <input type="submit" value="upload" name="submit">
</form>
