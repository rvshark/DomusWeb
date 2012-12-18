<?php
	
	require_once("../../config.php");
    require_once("lib_forum.php");
    require_once("lib.php");
	//require_once($CFG->themedir."/".$CFG->theme."/styles.php");
	$id   				= optional_param('id', 0, PARAM_INT);
	$discussion   		= optional_param('discussion', 0, PARAM_INT);
	
	$css = "<style type='text/css'>
			  body{
				width:600px;
				background:#dedede;
			  }
			</style>";
	echo $css;
	//print_header("", "","", "", "", true, "", "");
	
	if ($discussion==""){ exit;}
	
	$posts = myforum_get_posts($id,$discussion);

	
?>