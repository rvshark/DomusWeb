<?php
	
    require_once("../../config.php");
    require_once("lib.php");
	echo "<div style='width:200px;'>";
	$courses = get_courses('where c.visible=0');
	foreach ($courses as $course) {
		echo "<a href='javascript:void(0)'>";
			echo $course->fullname;
		echo "</a><br>";
	}
	echo "</div>";
?>