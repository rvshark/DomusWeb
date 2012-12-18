<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
<?php
	require_once("../../config.php");
    require_once("lib_forum.php");
    require_once("lib.php");
	include("style.css.php");
	
	$id   				= optional_param('id', 0, PARAM_INT);
	$courseid   		= optional_param('courseid', 0, PARAM_INT);
	$myforumid   		= optional_param('myforumid', 0, PARAM_INT);
	$discussion   		= optional_param('discussion', 0, PARAM_INT);
	$css = "<style type='text/css'>
				body{
					background:#dedede;
				}
				</style>
				";
		echo $css;
	$sql = "select id,text from mdl_myforum_notes where userid=$USER->id and course=$courseid and forum=$myforumid";
	
	$note = get_record_sql($sql);
	echo "<form action='post.php' method='POST'>	
			<input type='hidden' name='acc' value='notesadd'>
			<input type='hidden' name='id' value='$id'>
			<input type='hidden' name='idnote' value='$note->id'>
			<input type='hidden' name='courseid' value='$courseid'>
			<input type='hidden' name='forumid' value='$myforumid'>
			<textarea id='text' name='text' cols=50 rows=10>$note->text</textarea>
			<input type='submit' name='submit' value='salvar'>
		</form>";
?>