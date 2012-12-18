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
	$css = "<style type='text/css'>
			body{
				background:#dedede;
			}
			</style>
			";
	echo $css;
	if ($id==0) exit;
	if ($courseid==0) exit;
	if ($myforumid==0) exit;
	if ($discussion==0) exit;
	
	echo "<h3 class='tema'>Bibliografia</h3>";
	
	$sql = "select 1 as ok from mdl_myforum_posts where discussion=$discussion and userid=$USER->id";
	$res = get_record_sql($sql);
	
	
	
	
	
	$sql = "select * from mdl_myforum_biblio where discussion=$discussion and forum=$myforumid and course=$courseid";
	$rs = get_records_sql($sql);
	$txt="";
	
	foreach($rs as $row){
		
		$usr = get_record("user", "id", $row->userid);
		$fullname = $usr->firstname.' '.$usr->lastname;
		$editar = "";
		if ($USER->id==$usr->id){
			$editar = "<a href='javascript:void(0)' onclick='parent.location.href=\"biblio.php?acc=biblio_edit&idbiblio=$row->id&id=$id&courseid=$courseid&myforumid=$myforumid&discussion=$discussion\"'>Editar</a>";
		}
		$by = new object;
		$fullname = '<a href="'.$CFG->wwwroot.'/user/view.php?id='.$usr->id.'&amp;course='.$courseid.'">'.$fullname.'</a>';
		$txt .= $row->text."; por $fullname $editar<br>";
	}
	echo "<div class='fonte_forum'>";
		if($res->ok==1){
			echo "<a class='link' href='javascript:void(0)' onclick='parent.location.href=\"biblio.php?acc=biblio_add&id=$id&courseid=$courseid&myforumid=$myforumid&discussion=$discussion\"'>Adicionar</a><br>";
		}
		echo $txt; 
	echo "</div>";
?>