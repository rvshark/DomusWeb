<?php
	require_once("../../config.php");
    require_once("lib_forum.php");
    require_once("lib.php");
	include("style.css.php");
	
	$acc   				= optional_param('acc', 0, PARAM_TEXT);
	$id   				= optional_param('id', 0, PARAM_INT);
	$idconcept			= optional_param('idconcept', 0, PARAM_INT);
	$courseid   		= optional_param('courseid', 0, PARAM_INT);
	
	
	
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
	
	/*******************CABECALHO******************************/
	if ($course->category) {
        $navigation = "<a href=\"../../course/view.php?id=$course->id\">$course->shortname</a> ->";
    } else {
        $navigation = '';
    }

    $strmyforums = get_string("modulenameplural", "myforum");
    $strmyforum  = get_string("modulename", "myforum");

    print_header("$course->shortname: $myforum->name", "$course->fullname",
                 "$navigation <a href=index.php?id=$course->id>$strmyforums</a> -> $myforum->name", 
                  "", "", true, update_module_button($cm->id, $course->id, $strmyforum), 
                  navmenu($course, $cm)); 
	//print_header("", "","", "", "", true, "", "");
    /*******************CABECALHO******************************/
	
	
	

	
	$concept = get_record("myforum_concepts", "id", $idconcept);
	echo "<div style='width:95%; border:0px solid #f00; margin-left:25px; padding-bottom:20px;' align=''>";
		echo "<div align='center'><b>".$concept->title."</b></div>";
		echo "<br>";
		echo $concept->text;
	echo "</div>";
	print_footer($course);
	
?>