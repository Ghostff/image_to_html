
<?php
//Note: acceptable image type: 'png, jpeg and gif'
require_once('funcs.php');
$image_attribute = array('parent' => array('div' => array('id' => 'did')), 
				         'child'  => array('span' => array('class' => 'scl'))
						);

echo img_to_htm::render('1013763_640150972771788_9133588341940027691_n.jpg', $image_attribute, null, null, 'html');
?>

