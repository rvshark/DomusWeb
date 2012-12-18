<?php
	require_once("../../config.php");
    require_once("lib_forum.php");
    require_once("lib.php");
	include("style.css.php");
	$id = optional_param('id', 0, PARAM_INT); // Course Module ID, or
	$reply = optional_param('reply', 0, PARAM_INT); // Course Module ID, or
	$discussion = optional_param('discussion', 0, PARAM_INT); // Course Module ID, or
	$parent = optional_param('parent', 0, PARAM_INT); // Course Module ID, or
	
	global $CFG, $USER;
	$modmoodleform = "$CFG->dirroot/mod/myforum/repost_form.php";
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
	$coursecontext = get_context_instance(CONTEXT_COURSE, $course->id);
	$modcontext = get_context_instance(CONTEXT_MODULE, $cm->id);
	
	$mformclassname = 'mod_myforum_repost_form';
	$mform =& new $mformclassname("$CFG->wwwroot/mod/myforum/post.php",array('course'=>$course, 'cm'=>$cm, 'coursecontext'=>$coursecontext, 'modcontext'=>$modcontext, 'forum'=>$myforum),'post');
	
	$sql = "select * from mdl_myforum_posts where discussion=$discussion and parent=$parent";
	$res = mysql_query($sql);
	
	$post = get_record("myforum_posts", "id", $reply);
	
	$mform->acc = "reply";
	$mform->id = $id;
	$mform->userid = $USER->id;
	$mform->reply = $reply;
	$mform->subject = "Re: ".$post->subject;
	$mform->discussion = $discussion;
	$mform->set_data($mform);
	$mform->display();

?>