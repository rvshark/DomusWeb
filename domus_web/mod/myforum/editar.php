<?php
	require_once("../../config.php");
    require_once("lib_forum.php");
    require_once("lib.php");
	include("style.css.php");
	global $CFG, $USER;
	
	$id = optional_param('id', 0, PARAM_INT); // Course Module ID, or
	$idpost = optional_param('idpost', 0, PARAM_INT); // Course Module ID, or
	$discussion = optional_param('discussion', 0, PARAM_INT); // Course Module ID, or
	$parent = optional_param('parent', 0, PARAM_INT); // Course Module ID, or
	
	$modmoodleform = "$CFG->dirroot/mod/myforum/editpost_form.php";
    if (file_exists($modmoodleform)) {
        require_once($modmoodleform);

    } else {
        error('No formslib form description file found for this activity.');
    }
	
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
    }
	print_header("", "","", "", "", true, "", "");
	
	$eformclassname = 'mod_myforum_editpost_form';
	$eform =& new $eformclassname("$CFG->wwwroot/mod/myforum/post.php",array('course'=>$course, 'cm'=>$cm, 'coursecontext'=>$coursecontext, 'modcontext'=>$modcontext, 'forum'=>$myforum),'post');
	
	$post = get_record("myforum_posts", "id", $idpost);
	
	$s = "e_subject";
	$m = "e_message";
	$eform->acc = "edit";
	$eform->id = $id;
	$eform->idpost = $idpost;
	$eform->userid = $USER->id;
	$eform->reply = $parent;
	$eform->$s = $post->subject;
	$eform->$m = $post->message;
	$eform->discussion = $discussion;
	$eform->set_data($eform);
	$eform->display();

?>