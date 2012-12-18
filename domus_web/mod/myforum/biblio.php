<?
	require_once("../../config.php");
    require_once("lib_forum.php");
    require_once("lib.php");
	include("style.css.php");
	
	$acc   				= optional_param('acc', 0, PARAM_TEXT);
	$id   				= optional_param('id', 0, PARAM_INT);
	$idbiblio			= optional_param('idbiblio', 0, PARAM_INT);
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
    /*******************CABECALHO******************************/
	
	$modmoodleform = "$CFG->dirroot/mod/myforum/biblio_form.php";
    if (file_exists($modmoodleform)) {
        require_once($modmoodleform);

    } else {
        error('No formslib form description file found for this activity.');
    }
	
	
	$mformclassname = 'mod_myforum_biblio_form';
    $mform =& new $mformclassname('post.php', array('course'=>$course, 'cm'=>$cm, 'coursecontext'=>$coursecontext, 'modcontext'=>$modcontext, 'forum'=>$forum));
	if($acc=="biblio_edit"){
		$biblio = get_record("myforum_biblio", "id", $idbiblio);
		$mform->idbiblio = $biblio->id;
		$mform->text = $biblio->text;
	}
	
	$mform->acc = $acc;
	$mform->id = $id;
	$mform->discussion = $discussion;
	$mform->forum = $myforum->id;
	$mform->course = $course->id;
	$mform->set_data($mform);
	$mform->display();
?>