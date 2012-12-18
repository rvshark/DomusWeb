<?php  // $Id: lib.php,v 1.4 2006/08/28 16:41:20 mark-nielsen Exp $
/**
 * Library of functions and constants for module myforum
 *
 * @author 
 * @version $Id: lib.php,v 1.4 2006/08/28 16:41:20 mark-nielsen Exp $
 * @package myforum
 **/

/// (replace myforum with the name of your module and delete this line)


define('MYFORUM_MODE_FLATOLDEST', 1);
define('MYFORUM_MODE_FLATNEWEST', -1);
define('MYFORUM_MODE_THREADED', 2);
define('MYFORUM_MODE_NESTED', 3);

define('MYFORUM_FORCESUBSCRIBE', 1);
define('MYFORUM_INITIALSUBSCRIBE', 2);
define('MYFORUM_DISALLOWSUBSCRIBE',3);

define('MYFORUM_TRACKING_OFF', 0);
define('MYFORUM_TRACKING_OPTIONAL', 1);
define('MYFORUM_TRACKING_ON', 2);

define('MYFORUM_UNSET_POST_RATING', -999);

define ('MYFORUM_AGGREGATE_NONE', 0); //no ratings
define ('MYFORUM_AGGREGATE_AVG', 1);
define ('MYFORUM_AGGREGATE_COUNT', 2);
define ('MYFORUM_AGGREGATE_MAX', 3);
define ('MYFORUM_AGGREGATE_MIN', 4);
define ('MYFORUM_AGGREGATE_SUM', 5);

/**
 * Given an object containing all the necessary data, 
 * (defined by the form in mod.html) this function 
 * will create a new instance and return the id number 
 * of the new instance.
 *
 * @param object $instance An object from the form in mod.html
 * @return int The id of the newly inserted myforum record
 **/
 /**
	
	FUNÇÃO RECURSIVA - RETORNA OS POSTS DA DISCUSSAO
	NOME: myforum_get_posts
	DATA: 27/07/2011
	POR: RAMIRES OLIVEIRA
	$id 		= id do context
	$discussion = id da discussao
	$parent 	= id da resposta
	$margin 	= margin-left (css)
	$width 		= tamanho da tabela
 **/
function myforum_get_posts($id,$discussion,$parent=0,$margin=0,$width=100){

	global $CFG, $USER;
	//print_header("", "","", "", "", true, "", "");
						
	$modmoodleform = "$CFG->dirroot/mod/myforum/repost_form.php";
    if (file_exists($modmoodleform)) {
        require_once($modmoodleform);

    } else {
        error('No formslib form description file found for this activity.');
    }					
	$modmoodleform = "$CFG->dirroot/mod/myforum/editpost_form.php";
    if (file_exists($modmoodleform)) {
        require_once($modmoodleform);

    } else {
        error('No formslib form description file found for this activity.');
    }
	
	//$myforum = get_record("myforum_discussions", "id", $discussion);
	
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
	$coursecontext = get_context_instance(CONTEXT_COURSE, $course->id);
	$modcontext = get_context_instance(CONTEXT_MODULE, $cm->id);
	
	
	
	
	
	
	include("funcoes.js.php");
	include("style.css.php");
	
	$sql = "select * from mdl_myforum_posts where discussion=$discussion and parent=$parent";
	
	
	$res = mysql_query($sql);
	while ($row = mysql_fetch_array($res)){
		$mformclassname = 'mod_myforum_repost_form';
		$mform =& new $mformclassname("$CFG->wwwroot/mod/myforum/post.php",array('course'=>$course, 'cm'=>$cm, 'coursecontext'=>$coursecontext, 'modcontext'=>$modcontext, 'forum'=>$myforum, 'name_message'=>$row['id']),'post');
		
		$eformclassname = 'mod_myforum_editpost_form';
		$eform =& new $eformclassname("$CFG->wwwroot/mod/myforum/post.php",array('course'=>$course, 'cm'=>$cm, 'coursecontext'=>$coursecontext, 'modcontext'=>$modcontext, 'forum'=>$myforum, 'name_message'=>$row['id']),'post');
		$usr = get_record('user','id',$row['userid']);
		//$margin=0;
		echo "<table class='forumpost' border=0 width='".$width."%' style='float:right; margin-bottom:15px; margin-left:".$margin."px;'>";
			echo "<tbody>";
			echo "<tr class='cabecalho_forum'>";
					echo "<td>";
					
						$imguser = $CFG->wwwroot."/user/pix.php/".$usr->id."/f1.jpg";
						echo "<div style='float:left; padding-right:5px;'><img height='60' width='60' alt='Imagem de ".$usr->firstname.' '.$usr->lastname."' src='".$imguser."' class='userpicture defaultuserpic'></div>";
						
						echo $row['subject']."<br>";
						$post = get_record("myforum_posts", "id", $row['id']);
						$fullname = $usr->firstname.' '.$usr->lastname;
						$by = new object;
						$url = $CFG->wwwroot.'/user/view.php?id='.$usr->id.'&amp;course='.$course->id;
						$by->name = '<a href="javascript:parent.location.href=\''.$url.'\'">'.$fullname.'</a>';
						$by->date = userdate($post->modified);
						print_string('bynameondate', 'forum', $by);
						echo "<br>";
						if ($post->attachment){
							myforum_print_attachments($post);
						}
					echo"</td>";
			echo "</tr>";
			echo "<tr class='fonte_forum'>";
					echo "<td>";
					$options = new object();
					$options->para      = false;
					$options->trusttext = true;
					echo format_text($row['message'], $post->format, $options, $course->id);
					// echo $row['message'];
					echo "<div style='margin-left:15px; margin-top:15px;'>";
						
						echo "<a href='javascript:void(0)' onclick='javascript:window.open(\"responder.php?id=$id&reply=".$row['id']."&discussion=$discussion&parent=$parent\",name,\"width=1000, height=600,scrollbars=1\")' >Responder</a>";
						if ($USER->id==$post->userid){
							echo " | <a href='javascript:void(0)' onclick='javascript:window.open(\"editar.php?id=$id&idpost=".$row['id']."&discussion=$discussion&parent=$parent\",name,\"width=1000, height=600,scrollbars=1\")' >Editar</a>";
						}
						if ($post->parent!=0) echo " | <a href='javascript:void(0)' onclick='interromper_post(".$id.",".$post->id.");' >Interromper</a>";
						
						if (has_capability('mod/forum:deleteanypost', $modcontext)){
						//if ($USER->id==$post->userid){
							//if ( !(($post->userid == $USER->id && has_capability('mod/forum:deleteownpost', $modcontext))|| has_capability('mod/forum:deleteanypost', $modcontext)) ) {
							echo " | <a href='javascript:void(0)' onclick='excluir_post(".$id.",".$post->id.");' >Excluir</a>";
						}
						
						
						if ($myforum->assessed>0){ # AVALIACAO 
							
							if ((time()>=$myforum->assesstimestart)&&(time()<=$myforum->assesstimefinish)){ # DATA PARA AVALIACAO
								echo "<div style='float:right; margin-right:20px;'>";
							
								if (has_capability('mod/forum:viewrating', $modcontext)){
									if ($ratings = myforum_get_ratings($post->id,"r.time DESC")){
										foreach($ratings as $r){
											echo "Nota: ".$r->rating."&nbsp;&nbsp;";
										}
										//echo "<a href='javascript:void(0)' onclick='openpopup(\"/mod/myforum/report.php?id=$post->id\", \"ratings\", \"menubar=0,location=0,scrollbars,resizable,width=600,height=400\", 0);'>Notas</a>";
									}
								}
								if (has_capability('mod/forum:deleteanypost', $modcontext)){ # VERIFICA SE TEM PERMISSAO PARA AVALIAR
									if ($USER->id!=$post->userid){
										echo "<select name='rate' id='rate'>";
											echo "<option value=''>- Selecione -</option>";
											for($i=$myforum->scale;$i>=0;$i--){
												echo "<option value='$i'>$i/$myforum->scale</option>";
											}
										echo "</select>&nbsp;&nbsp;";
										echo "<a href='javascript:void(0)' onclick='avaliar(".$id.",".$post->id.",document.getElementById(\"rate\").value);'>Avaliar</a>&nbsp;&nbsp;";
									}
								}
								echo "</div>";
							}
						}
					echo "</div>";
						
						
						
					echo"</td>";
			echo "</tr>";
			echo "</tbody>";
		echo "</table>";
		myforum_get_posts($id,$row['discussion'],$row['id'],$margin+20,$width-5);
	}
	
	
	return true;
}
function myforum_get_ratings($postid, $sort="u.firstname ASC") {
    global $CFG;
    return get_records_sql("SELECT u.*, r.rating, r.time
                              FROM {$CFG->prefix}myforum_ratings r,
                                   {$CFG->prefix}user u
                             WHERE r.post = '$postid'
                               AND r.userid = u.id
                             ORDER BY $sort");
}
function myforum_get_post_full($postid) {
    global $CFG;

    return get_record_sql("SELECT p.*, d.forum, u.firstname, u.lastname, u.email, u.picture, u.imagealt
                             FROM {$CFG->prefix}myforum_posts p
                                  JOIN {$CFG->prefix}myforum_discussions d ON p.discussion = d.id
                                  LEFT JOIN {$CFG->prefix}user u ON p.userid = u.id
                            WHERE p.id = '$postid'");
}
function myforum_delete_discussion($discussion, $fulldelete=false) {
// $discussion is a discussion record object

    $result = true;

    if ($posts = get_records("myforum_posts", "discussion", $discussion->id)) {
        foreach ($posts as $post) {
            $post->course = $discussion->course;
            $post->forum  = $discussion->forum;
            if (! delete_records("myforum_ratings", "post", "$post->id")) {
                $result = false;
            }
            if (! myforum_delete_post($post, $fulldelete)) {
                $result = false;
            }
        }
    }

    //forum_tp_delete_read_records(-1, -1, $discussion->id);

    if (! delete_records("myforum_discussions", "id", "$discussion->id")) {
        $result = false;
    }

    return $result;
}
function myforum_delete_post($post, $children=false) {
   if ($childposts = get_records('myforum_posts', 'parent', $post->id)) {
       if ($children) {
           foreach ($childposts as $childpost) {
               myforum_delete_post($childpost, true);
           }
       } else {
           return false;
       }
   }
   if (delete_records("myforum_posts", "id", $post->id)) {
       delete_records("myforum_ratings", "post", $post->id);  // Just in case

       //forum_tp_delete_read_records(-1, $post->id);

       if ($post->attachment) {
           $discussion = get_record("myforum_discussions", "id", $post->discussion);
           $post->course = $discussion->course;
           $post->forum  = $discussion->forum;
           myforum_delete_old_attachments($post);
       }

   // Just in case we are deleting the last post
       //forum_discussion_update_last_post($post->discussion);

       return true;
   }
   return false;
}
function myforum_delete_old_attachments($post, $exception="") {

/**
 * Deletes all the user files in the attachments area for a post
 * EXCEPT for any file named $exception
 */
    if ($basedir = myforum_file_area($post)) {
        if ($files = get_directory_list($basedir)) {
            foreach ($files as $file) {
                if ($file != $exception) {
                    unlink("$basedir/$file");
                    notify("Existing file '$file' has been deleted!");
                }
            }
        }
        if (!$exception) {  // Delete directory as well, if empty
            rmdir("$basedir");
        }
    }
}
/* FAZ UPLOAD DO ARQUIVO */
function myforum_add_attachment($post, $inputname,&$message) {

    global $CFG;

    if (!$forum = get_record("myforum", "id", $post->forum)) {
        return "";
    }

    if (!$course = get_record("course", "id", $forum->course)) {
        return "";
    }

    require_once($CFG->dirroot.'/lib/uploadlib.php');
    $um = new upload_manager($inputname,true,false,$course,false,$forum->maxbytes,true,true);
    $dir = myforum_file_area_name($post);
    if ($um->process_file_uploads($dir)) {
        $message .= $um->get_errors();
        return $um->get_new_filename();
    }
    $message .= $um->get_errors();
    return null;
}
/* IMPRIME O ANEXO */
function myforum_print_attachments($post, $return=NULL) {

    global $CFG;

    $filearea = myforum_file_area_name($post);
	$imagereturn = "";
    $output = "";

    if ($basedir = myforum_file_area($post)) {
        if ($files = get_directory_list($basedir)) {
            $strattachment = get_string("attachment", "forum");
            foreach ($files as $file) {
                $icon = mimeinfo("icon", $file);
                $type = mimeinfo("type", $file);
                $ffurl = get_file_url("$filearea/$file");
                $image = "<img src=\"$CFG->pixpath/f/$icon\" class=\"icon\" alt=\"\" />";

                if ($return == "html") {
                    $output .= "<a href=\"$ffurl\">$image</a> ";
                    $output .= "<a href=\"$ffurl\">$file</a><br />";

                } else if ($return == "text") {
                    $output .= "$strattachment $file:\n$ffurl\n";

                } else {
                    if (in_array($type, array('image/gif', 'image/jpeg', 'image/png'))) {    // Image attachments don't get printed as links
                        $imagereturn .= "<br /><img src=\"$ffurl\" alt=\"\" />";
                    } else {
                        echo "<a href=\"$ffurl\">$image</a> ";
                        echo filter_text("<a href=\"$ffurl\">$file</a><br />");
                    }
                }
            }
        }
    }

    if ($return) {
        return $output;
    }

    return $imagereturn;
}
function myforum_file_area_name($post) {
    global $CFG;

    if (!isset($post->forum) or !isset($post->course)) {
		
        debugging('missing forum or course', DEBUG_DEVELOPER);
        if (!$discussion = get_record('myforum_discussions', 'id', $post->discussion)) {
            return false;
        }
        if (!$forum = get_record('myforum', 'id', $discussion->forum)) {
            return false;
        }
        $forumid  = $forum->id;
        $courseid = $forum->course;
		
    } else {
        $forumid  = $post->forum;
        $courseid = $post->course;
    }

    return "$courseid/$CFG->moddata/myforum/$forumid/$post->id";
}
function myforum_file_area($post) {
    $path = myforum_file_area_name($post);
    if ($path) {
        return make_upload_directory($path);
    } else {
        return false;
    }
}
function myforum_add_instance($myforum) {
    
    $myforum->timemodified = time();

    # May have to add extra stuff in here #
    
    return insert_record("myforum", $myforum);
}

/**
 * Given an object containing all the necessary data, 
 * (defined by the form in mod.html) this function 
 * will update an existing instance with new data.
 *
 * @param object $instance An object from the form in mod.html
 * @return boolean Success/Fail
 **/
function myforum_update_instance($myforum) {

    $myforum->timemodified = time();
    $myforum->id = $myforum->instance;

    # May have to add extra stuff in here #

    return update_record("myforum", $myforum);
}

/**
 * Given an ID of an instance of this module, 
 * this function will permanently delete the instance 
 * and any data that depends on it. 
 *
 * @param int $id Id of the module instance
 * @return boolean Success/Failure
 **/
function myforum_delete_instance($id) {

    if (! $myforum = get_record("myforum", "id", "$id")) {
        return false;
    }

    $result = true;

    # Delete any dependent records here #

    if (! delete_records("myforum", "id", "$myforum->id")) {
        $result = false;
    }

    return $result;
}

/**
 * Return a small object with summary information about what a 
 * user has done with a given particular instance of this module
 * Used for user activity reports.
 * $return->time = the time they did it
 * $return->info = a short text description
 *
 * @return null
 * @todo Finish documenting this function
 **/
function myforum_user_outline($course, $user, $mod, $myforum) {
    return $return;
}

/**
 * Print a detailed representation of what a user has done with 
 * a given particular instance of this module, for user activity reports.
 *
 * @return boolean
 * @todo Finish documenting this function
 **/
function myforum_user_complete($course, $user, $mod, $myforum) {
    return true;
}

/**
 * Given a course and a time, this module should find recent activity 
 * that has occurred in myforum activities and print it out. 
 * Return true if there was output, or false is there was none. 
 *
 * @uses $CFG
 * @return boolean
 * @todo Finish documenting this function
 **/
function myforum_print_recent_activity($course, $isteacher, $timestart) {
    global $CFG;

    return false;  //  True if anything was printed, otherwise false 
}

/**
 * Function to be run periodically according to the moodle cron
 * This function searches for things that need to be done, such 
 * as sending out mail, toggling flags etc ... 
 *
 * @uses $CFG
 * @return boolean
 * @todo Finish documenting this function
 **/
function myforum_cron () {
    global $CFG;

    return true;
}

/**
 * Must return an array of grades for a given instance of this module, 
 * indexed by user.  It also returns a maximum allowed grade.
 * 
 * Example:
 *    $return->grades = array of grades;
 *    $return->maxgrade = maximum allowed grade;
 *
 *    return $return;
 *
 * @param int $myforumid ID of an instance of this module
 * @return mixed Null or object with an array of grades and with the maximum grade
 **/
function myforum_grades($myforumid) {
   return NULL;
}

/**
 * Must return an array of user records (all data) who are participants
 * for a given instance of myforum. Must include every user involved
 * in the instance, independient of his role (student, teacher, admin...)
 * See other modules as example.
 *
 * @param int $myforumid ID of an instance of this module
 * @return mixed boolean/array of students
 **/
function myforum_get_participants($myforumid) {
    return false;
}

/**
 * This function returns if a scale is being used by one myforum
 * it it has support for grading and scales. Commented code should be
 * modified if necessary. See forum, glossary or journal modules
 * as reference.
 *
 * @param int $myforumid ID of an instance of this module
 * @return mixed
 * @todo Finish documenting this function
 **/
function myforum_scale_used ($myforumid,$scaleid) {
    $return = false;

    //$rec = get_record("myforum","id","$myforumid","scale","-$scaleid");
    //
    //if (!empty($rec)  && !empty($scaleid)) {
    //    $return = true;
    //}
   
    return $return;
}


//////////////////////////////////////////////////////////////////////////////////////
/// Any other myforum functions go here.  Each of them must have a name that 
/// starts with myforum_


/**
 * Returns array of forum types
 */
function myforum_get_forum_types() {
    return array ('general'  => get_string('generalforum', 'myforum'),
                  'eachuser' => get_string('eachuserforum', 'myforum'),
                  'single'   => get_string('singleforum', 'myforum'),
                  'qanda'    => get_string('qandaforum', 'myforum'));
}

/**
 * Returns array of forum aggregate types
 */
function myforum_get_aggregate_types() {
    return array (MYFORUM_AGGREGATE_NONE  => get_string('aggregatenone', 'forum'),
                  MYFORUM_AGGREGATE_AVG   => get_string('aggregateavg', 'forum'),
                  MYFORUM_AGGREGATE_COUNT => get_string('aggregatecount', 'forum'),
                  MYFORUM_AGGREGATE_MAX   => get_string('aggregatemax', 'forum'),
                  MYFORUM_AGGREGATE_MIN   => get_string('aggregatemin', 'forum'),
                  MYFORUM_AGGREGATE_SUM   => get_string('aggregatesum', 'forum'));
}
function myforum_add_new_discussion(){
	
}
?>
