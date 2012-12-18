<?php
	
	require_once("../../config.php");
    require_once("lib_forum.php");
    require_once("lib.php");
	include("style.css.php");
	$id   				= optional_param('id', 0, PARAM_INT);
	$courseid   		= optional_param('courseid', 0, PARAM_INT);
	$myforumid   		= optional_param('myforumid', 0, PARAM_INT);
	$discussion   		= optional_param('discussion', 0, PARAM_INT);
	
	//print_header("", "","", "", "", true, "", "");
	$sql = "select * from mdl_myforum_discussions where course=$courseid and forum=$myforumid";

	$topicos = get_records_sql($sql);
	$css = "<style type='text/css'>
			body{
				background:#dedede;
			}
			</style>
			";
	echo $css;
	
	echo "<ul class='menu'><b>T&oacute;picos</b>";
	foreach ($topicos as $topico) {
		echo "<li>";
		echo "<a  href='javascript:void(0)' onclick='parent.frame_resp.location.href=\"respostas.php?id=$id&discussion=$topico->id\"; parent.frame_bibli.location.href=\"bibliografia.php?id=$id&courseid=$courseid&myforumid=$myforumid&discussion=$topico->id\"'>";
			echo $topico->name."<br>";
		echo "</a>";
		echo "</li>";
	}
	echo "</ul>";
	
	
?>