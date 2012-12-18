<?php
	
	require_once("../../config.php");
    require_once("lib_forum.php");
    require_once("lib.php");
	include("style.css.php");
	$id   				= optional_param('id', 0, PARAM_INT);
	$courseid   		= optional_param('courseid', 0, PARAM_INT);
	$myforumid   		= optional_param('myforumid', 0, PARAM_INT);
	$discussion   		= optional_param('discussion', 0, PARAM_INT);
	
	if ($id) {
        if (! $cm = get_record("course_modules", "id", $id)) {
            error("Course Module ID was incorrect");
        }
    
        if (! $course = get_record("course", "id", $cm->course)) {
            error("Course is misconfigured");
        }
    
        if (! $myforum = get_record("myforum", "id", $cm->instance)) {
            error("Course module is incorrect");
        }

    } else {
        if (! $myforum = get_record("myforum", "id", $a)) {
            error("Course module is incorrect");
        }
        if (! $course = get_record("course", "id", $myforum->course)) {
            error("Course is misconfigured");
        }
        if (! $cm = get_coursemodule_from_instance("myforum", $myforum->id, $course->id)) {
            error("Course Module ID was incorrect");
        }
    }
	
	//print_header("", "","", "", "", true, "", "");
	$sql = "select * from mdl_myforum_concepts where course=$courseid and forum=$myforumid and discussion=$discussion";
	
	$conceitos = get_records_sql($sql);
	$css = "<style type='text/css'>
			body{
				background:#dedede;
			}
			</style>
			";
	echo $css;
	$modcontext = get_context_instance(CONTEXT_MODULE, $cm->id);
	
	
	$context = get_record("context", "instanceid", $courseid, "contextlevel", 50);
	$ok=0;
	if($role = get_record("role_assignments", "contextid", $context->id, "userid", $USER->id, "roleid", 3)){
		$ok=1;
	}
	if ($discussion==0) exit;
	//if ($conceitos) {
		echo "<ul class='menu'><b>Conceitos</b>";
		foreach ($conceitos as $conceito) {
			$url = "concept_view.php?&id=$id&idconcept=$conceito->id&discussion=$discussion";
			if ($ok==1){
				$url = "concept.php?acc=concept_edit&id=$id&idconcept=$conceito->id&discussion=$discussion";
			}
			echo "<li >";
			echo "<a  href='javascript:void(0)' onclick='javascript:window.open(\"$url\",name,\"width=1000, height=600,scrollbars=1\")'>";
				echo $conceito->title."<br>";
			echo "</a>";
			echo "</li>";
		}
			
		echo "</ul>";
	//}
	if ($ok==1){
		echo "<a class='link' href='javascript:void(0)' onclick='javascript:window.open(\"concept.php?acc=concept_add&id=$id&discussion=$discussion\",name,\"width=1000, height=600,scrollbars=1\")'>Adicionar</a>";
	}
	
	
?>