<?php
require_once("../../config.php");

require_course_login($course, true, $cm);

$id = optional_param('id', 0, PARAM_INT);    // Course Module ID

if($id)
{
	$_SESSION["Course"] = $id;
}
?>







