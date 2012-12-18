<?php // $Id: preview.php,v 1.4 2007/01/27 23:23:44 skodak Exp $ preview for insert image dialog

    require("../config.php");

    $id = optional_param('id', SITEID, PARAM_INT);
    $imageurl = required_param('imageurl', PARAM_RAW);
    $imagerror = optional_param('error');
	
    require_login($id);
    require_capability('moodle/course:managefiles', get_context_instance(CONTEXT_COURSE, $id));
	
	$pos = strrpos( $imageurl, ".");
	if ($pos === false)
	 	$imagerror = 1;
	else{
	 $ext = strtolower(trim(substr( $imageurl, $pos)));
	 $imgExts = array(".gif", ".jpg", ".jpeg", ".png", ".tiff", ".tif", ".pmg");
	 
	 if(!in_array($ext, $imgExts))
	 	$imagerror = 1;
	}

    @header('Content-Type: text/html; charset=utf-8');
	if($imagerror != 1){
    	$imagetag = clean_text('<img src="'.htmlSpecialChars(stripslashes_safe($imageurl)).'" alt="" />');
	}else
		$imagetag = clean_text('');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php echo get_string('preview') ?></title>
<style type="text/css">
 body { margin: 2px; }
</style>
</head>
<body bgcolor="#ffffff">

<?php echo $imagetag ?>

</body>
</html>
