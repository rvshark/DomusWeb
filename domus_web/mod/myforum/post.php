<?php // $Id: post.php,v 1.154.2.18 2009/10/13 20:53:57 skodak Exp $

//  Edit and save a new post to a discussion

    require_once('../../config.php');
    require_once('lib_forum.php');
    require_once('lib.php');

    global $CFG, $USER;
    $id   		= optional_param('id', 0, PARAM_INT); //CONTEXT ID
    $myforumid   = optional_param('myforum', 0, PARAM_INT);
	$acc 		= optional_param('acc', "", PARAM_TEXT);
    $edit    = optional_param('edit', 0, PARAM_INT);
    $delete  = optional_param('delete', 0, PARAM_INT);
    $prune   = optional_param('prune', 0, PARAM_INT);
    $name    = optional_param('name', '', PARAM_CLEAN);
    $confirm = optional_param('confirm', 0, PARAM_INT);
    $groupid = optional_param('groupid', null, PARAM_INT);
	
	
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
	
	if($acc=="add"){
		
		//echo "salvar";
		$myforum   		= optional_param('myforum', 0, PARAM_INT);
		$course   		= optional_param('course', 0, PARAM_INT);
		$discussion   	= optional_param('discussion', 0, PARAM_INT);
		$parent   		= optional_param('parent', 0, PARAM_INT);
		$userid   		= optional_param('userid', 0, PARAM_INT);
		$reply   			= optional_param('reply', 0, PARAM_INT);
		$subject   		= optional_param('subject', '', PARAM_TEXT);
		$message   		= optional_param('message', '', PARAM_RAW);
		
		$sql = "SELECT coalesce(count(*),0)+1 as num from mdl_myforum_posts";
		$res = get_record_sql($sql);
		$firstpost = $res->num;
		$groupid = -1;
		$timemodified = time(); //mktime(date("H"), date("i"), date("s"), date("m")  , date("d"), date("Y"));
		$newdisc = new object();
		$newdisc->course =  $course;
		$newdisc->forum =  $myforum;
		$newdisc->name =  $subject;
		$newdisc->firstpost =  $firstpost;
		$newdisc->userid =  $userid;
		$newdisc->groupid =  $groupid;
		$newdisc->timemodified =  $timemodified;
		$newdisc->usermodified =  $userid;
		
		if (!$newid = insert_record('myforum_discussions', $newdisc)) {
            error('Could not create new discussion');
        }
		
		$post = new object();
		$post->discussion = $newid;
		$post->parent = $reply;
		$post->userid = $userid;
		$post->created = $timemodified;
		$post->modified = $timemodified;
		$post->mailed = 0;
		$post->subject = $subject;
		$post->message = $message;
		$post->format = 1;
		$post->attachment = "";
		
		if (!$newid = insert_record('myforum_posts', $post)) {
            error('Could not create new post');
        }
		$post->id		  = $newid;
		$post->forum      = $myforum;     // speedup
		$post->course     = $newdisc->course; // speedup
		
		if ($post->attachment = myforum_add_attachment($post, 'attachment',$message)) {
			set_field("myforum_posts", "attachment", $post->attachment, "id", $post->id);
		}
		redirect("view.php?id=$id");
		exit;
	}
	if ($acc=="reply"){
		$userid		   		= optional_param('userid', 0, PARAM_INT);
		$discussion   		= optional_param('discussion', 0, PARAM_INT);
		$reply   			= optional_param('reply', 0, PARAM_INT);
		$subject   			= optional_param('subject', '', PARAM_TEXT);
		$message   			= optional_param('message', '', PARAM_RAW);
		$message = stripslashes($message);
		$timemodified = mktime(date("H"), date("i"), date("s"), date("m")  , date("d"), date("Y"));
		
		
		
		$resp = new object();
		$resp->discussion = $discussion;
		$resp->parent = $reply;
		$resp->userid = $userid;
		$resp->created = $timemodified;
		$resp->modified = $timemodified;
		$resp->mailed = 0;
		$resp->subject = $subject;
		$resp->message = $message;
		$resp->format = 1;
		
		if (!$newid = insert_record('myforum_posts', $resp)) {
            error('Could not create new discussion');
        }
		
		$disc = get_record("myforum_discussions", "id", $discussion);
		$resp->id		  = $newid;
		$resp->forum      = $disc->forum;     // speedup
		$resp->course     = $myforum->course; // speedup
		
		if ($resp->attachment = myforum_add_attachment($resp, 'attachment',$message)) {
			set_field("myforum_posts", "attachment", $resp->attachment, "id", $resp->id);
		}
		
		//redirect("$CFG->wwwroot/mod/myforum/respostas.php?id=$id&discussion=$discussion");
		echo "<script>window.opener.location.reload(); window.close();</script>";
		exit;
	}
	if ($acc=="edit"){
		$idpost		   		= optional_param('idpost', 0, PARAM_INT);
		$userid		   		= optional_param('userid', 0, PARAM_INT);
		$discussion   		= optional_param('discussion', 0, PARAM_INT);
		$reply   			= optional_param('reply', 0, PARAM_INT);
		$subject   			= optional_param('e_subject', '', PARAM_TEXT);
		$message   			= optional_param('e_message', '', PARAM_RAW);
		//$message = stripslashes($message);
		//echo $idpost."--->".$message."-------".$subject;
		//exit;
		$timemodified = time();
		
		 if (! $updatepost = myforum_get_post_full($idpost)) {
            error("Post ID was incorrect");
        }
		
		$updatepost = new object();
		$updatepost->id  = $idpost;
		$updatepost->subject = $subject;
		//$updatepost->message = '';
		$updatepost->message = $message;
		$updatepost->modfied = time();
		$updatepost->attachment = "";
		
		$modcontext = get_context_instance(CONTEXT_MODULE, $cm->id);
		
		trusttext_prepare_edit($updatepost->message, $updatepost->format, can_use_html_editor(), $modcontext);
		trusttext_after_edit($updatepost->message, $modcontext);
		
		
		//exit;
		update_record('myforum_posts', $updatepost);
		
		//$post->id		  = $newid;
		$disc = get_record("myforum_discussions", "id", $discussion);
		$updatepost->forum      = $disc->forum;     // speedup
		$updatepost->course     = $myforum->course; // speedup
		
		if ($updatepost->attachment = myforum_add_attachment($updatepost, 'attachment',$message)) {
			set_field("myforum_posts", "attachment", $updatepost->attachment, "id", $updatepost->id);
		}
		
		//redirect("$CFG->wwwroot/mod/myforum/respostas.php?id=$id&discussion=$discussion");
		echo "<script>window.opener.location.reload(); window.close();</script>";
		exit;
	}
	
	if ($acc=="delete"){
		$delete		   		= optional_param('post', 0, PARAM_INT);
		if (! $post = myforum_get_post_full($delete)) {
            error("Post ID was incorrect");
        }
        if (! $discussion = get_record("myforum_discussions", "id", $post->discussion)) {
            error("This post is not part of a discussion!");
        }
        if (! $forum = get_record("myforum", "id", $discussion->forum)) {
            error("The forum number was incorrect ($discussion->forum)");
        }
        if (!$cm = get_coursemodule_from_instance("myforum", $forum->id, $forum->course)) {
            error('Could not get the course module for the forum instance.');
        }
        if (!$course = get_record('course', 'id', $forum->course)) {
            error('Incorrect course');
        }
		 require_login($course, false, $cm);
        $modcontext = get_context_instance(CONTEXT_MODULE, $cm->id);
		
		if (! $post->parent) {  // post is a discussion topic as well, so delete discussion
			myforum_delete_discussion($discussion);

			add_to_log($discussion->course, "myforum", "delete discussion",
					   "view.php?id=$cm->id", "$forum->id", $cm->id);

			//redirect("view.php?f=$discussion->forum");
			
			echo "<script>parent.location.href='view.php?id=$cm->id';</script>";
			exit;

		} else if (myforum_delete_post($post, has_capability('mod/forum:deleteanypost', $modcontext))) {

			if ($forum->type == 'single') {
				// Single discussion forums are an exception. We show
				// the forum itself since it only has one discussion
				// thread.
				$discussionurl = "view.php?f=$forum->id";
			} else {
				$discussionurl = "discuss.php?d=$post->discussion";
			}

			add_to_log($discussion->course, "myforum", "delete post", $discussionurl, "$post->id", $cm->id);

			//redirect(forum_go_back_to($discussionurl));
			
			
		} else {
			error("An error occurred while deleting record $post->id");
		}
		
		
		redirect("$CFG->wwwroot/mod/myforum/respostas.php?id=$id&discussion=$discussion->id");
		
		
		exit;
	}
	if ($acc=="prune"){
		//exit;
		/**************************************************************/
		
		
		$idpost		   		= optional_param('post', 0, PARAM_INT);
		
		if (! $fullpost = myforum_get_post_full($idpost)) {
            error("Post ID was incorrect");
        }
        if (! $discussion = get_record("myforum_discussions", "id", $fullpost->discussion)) {
            error("This post is not part of a discussion!");
        }
        if (! $forum = get_record("myforum", "id", $discussion->forum)) {
            error("The forum number was incorrect ($discussion->forum)");
        }
        if (!$cm = get_coursemodule_from_instance("myforum", $forum->id, $forum->course)) {
            error('Could not get the course module for the forum instance.');
        }
        if (!$course = get_record('course', 'id', $forum->course)) {
            error('Incorrect course');
        }
		
		//echo $idpost;	
		$fullpost = myforum_get_post_full($idpost);
		$userid   		= $fullpost->userid;
		$firstpost = $discussion->firstpost;
	//	echo $fullpost->userid;
		$timemodified = time(); 
		$newdisc = new object();
		$newdisc->course =  $course->id;
		$newdisc->forum =  $forum->id;
		$newdisc->name =  $fullpost->subject;
		$newdisc->firstpost =  $firstpost;
		$newdisc->userid =  $userid;
		$newdisc->groupid =  $discussion->groupid;
		$newdisc->timemodified =  $timemodified;
		$newdisc->usermodified =  $userid;
		//exit;
		if (!$newid = insert_record('myforum_discussions', $newdisc)) {
            error('Could not create new discussion');
        }
		//exit;
		$post = new object();
		$post->id  = $idpost;
		$post->discussion = $newid;
		$post->parent = 0;
		$post->userid = $userid;
		
		update_record('myforum_posts', $post);
            //error('Could not create new post');
        
		redirect("$CFG->wwwroot/mod/myforum/respostas.php?id=$id&discussion=$newid");
		exit;
	}
	if ($acc=="biblio_add"){
		$discussion		   		= optional_param('discussion', 0, PARAM_INT);
		$myforum		   		= optional_param('forum', 0, PARAM_INT);
		$course			   		= optional_param('course', 0, PARAM_INT);
		$text			   		= optional_param('text', '', PARAM_RAW);
		$userid					= $USER->id;
		$datetime				= time();
		
		$biblio = new object();
		$biblio->text = $text;
		$biblio->discussion = $discussion;
		$biblio->userid = $userid;
		$biblio->forum = $myforum;
		$biblio->course = $course;
		$biblio->datetime = $datetime;
		
		if (!$newid = insert_record('myforum_biblio', $biblio)) {
            error('Could not create new bibliography');
        }
		redirect("view.php?id=$id&discussion=$discussion");
		exit;
	}
	if ($acc=="biblio_edit"){
		$idbiblio			   	= optional_param('idbiblio', 0, PARAM_INT);
		$discussion			   	= optional_param('discussion', 0, PARAM_INT);
		$text			   		= optional_param('text', '', PARAM_RAW);
		$datetime				= time();
		
		$biblio = new object();
		$biblio->id = $idbiblio;
		$biblio->text = $text;
		$biblio->datetime = $datetime;
		update_record('myforum_biblio', $biblio);
		redirect("view.php?id=$id&discussion=$discussion");
		exit;
	}
	if ($acc=="rating"){
	
		$idpost		   		= optional_param('post', 0, PARAM_INT);
		$rate		   		= optional_param('rate', 0, PARAM_INT);
		if (! $post = myforum_get_post_full($idpost)) {
            error("Post ID was incorrect");
        }
        if (! $discussion = get_record("myforum_discussions", "id", $post->discussion)) {
            error("This post is not part of a discussion!");
        }
        if (! $forum = get_record("myforum", "id", $discussion->forum)) {
            error("The forum number was incorrect ($discussion->forum)");
        }
        if (!$cm = get_coursemodule_from_instance("myforum", $forum->id, $forum->course)) {
            error('Could not get the course module for the forum instance.');
        }
        if (!$course = get_record('course', 'id', $forum->course)) {
            error('Incorrect course');
        }
		
		$rating = new Object();
		$rating->userid = $USER->id;
		$rating->post = $idpost;
		$rating->time = time();
		$rating->rating = $rate;
		
		if (!$newid = insert_record('myforum_ratings', $rating)) {
            error('Error');
        }
		redirect("$CFG->wwwroot/mod/myforum/respostas.php?id=$id&discussion=$discussion->id");
		exit;
	}
	if ($acc=="concept_add"){
		$title		   		= optional_param('title', '', PARAM_TEXT);
		$text		   		= optional_param('text', '', PARAM_RAW);
		$course		   		= optional_param('course', 0, PARAM_INT);
		$forum		   		= optional_param('forum', 0, PARAM_INT);
		$discussion		   	= optional_param('discussion', 0, PARAM_INT);
		
		$concept = new Object();
		$concept->title = $title;
		$concept->text = $text;
		$concept->userid = $USER->id;
		$concept->course  = $course;
		$concept->forum  = $forum;
		$concept->discussion  = $discussion;
		$concept->datetime = time();
		
		if (!$newid = insert_record('myforum_concepts', $concept)) {
            error('Could not create new concept');
        }
		echo "<script>window.opener.location.reload(); window.close();</script>";
		//echo "<script>window.close();</script>";
		exit;
	}
	if ($acc=="concept_edit"){
		$idconcept		   	= optional_param('idconcept', 0, PARAM_INT);
		$title		   		= optional_param('title', '', PARAM_TEXT);
		$text		   		= optional_param('text', '', PARAM_RAW);
		$course		   		= optional_param('course', 0, PARAM_INT);
		$forum		   		= optional_param('forum', 0, PARAM_INT);
		$discussion		   	= optional_param('discussion', 0, PARAM_INT);
		
		$concept = new Object();
		$concept->id = $idconcept;
		$concept->title = $title;
		$concept->text = $text;
		$concept->userid = $USER->id;
		$concept->course  = $course;
		$concept->forum  = $forum;
		$concept->discussion  = $discussion;
		$concept->datetime = time();
		
		update_record('myforum_concepts', $concept);
		
		echo "<script>window.opener.location.reload(); window.close();</script>";
		//echo "<script>window.close()</script>";
		exit;
	}
	if($acc=="notesadd"){
		$idnote		   	= optional_param('idnote', 0, PARAM_INT);
		$courseid		   	= optional_param('courseid', 0, PARAM_INT);
		$forumid		   	= optional_param('forumid', 0, PARAM_INT);
		$text		   		= optional_param('text', '', PARAM_TEXT);
		
		$note = new Object();
		if ($idnote!=0) { $note->id = $idnote;}
		$note->text = $text;
		$note->userid = $USER->id;
		$note->course = $courseid;
		$note->forum = $forumid;
		$note->datetime = time();
		echo "$note->id $courseid $forumid  $text";
		//exit;
		if ($idnote==0){
			if (!$newid = insert_record('myforum_notes', $note)) {
				error('ERRO');
			}
		}else{
			update_record('myforum_notes', $note);
		}
		echo "<script>window.close()</script>";
		
		exit;
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
	
	//these page_params will be passed as hidden variables later in the form.
    //require_once('post_form.php');
	$modmoodleform = "$CFG->dirroot/mod/myforum/post_form.php";
    if (file_exists($modmoodleform)) {
        require_once($modmoodleform);

    } else {
        error('No formslib form description file found for this activity.');
    }
	
	$forum = $myforum;
	$coursecontext = get_context_instance(CONTEXT_COURSE, $course->id);
	$modcontext = get_context_instance(CONTEXT_MODULE, $cm->id);
	$mformclassname = 'mod_myforum_post_form';
    $mform =& new $mformclassname('post.php', array('course'=>$course, 'cm'=>$cm, 'coursecontext'=>$coursecontext, 'modcontext'=>$modcontext, 'forum'=>$forum));
	
	
    
	/******** PARAMETROS PARA NOVO TOPICO *****************/
	$sql = "SHOW TABLE STATUS LIKE 'mdl_myforum_discussions'";
	$res2 = mysql_query($sql);
	$row2 = mysql_fetch_array($res2);
	$discussion = $row2['Auto_increment'];
	//$res = get_record_sql($sql);
	
	
	
	$mform->acc = "add";
	$mform->id = $id;
	$mform->course = $course->id;
	$mform->myforum = $myforum->id;
	$mform->discussion = $discussion;
	$mform->parent = 0;
	$mform->reply = 0;
	$mform->userid = $USER->id;
	$mform->set_data($mform);
	/******** PARAMETROS *****************/
	$mform->display();
    print_footer($course);


?>
