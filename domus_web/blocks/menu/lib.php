<?php

/**
* Load all categories and sub categories
*
* @uses $categories;
* @uses $USER;
* @param int $cats Category id to analyse
* @return array Category array completed
*/
function load_cattree($cats) {
	global $categories,$USER;
	foreach ($cats as $cat) {
		$categories[$cat->id]->id = $cat->id;
		$categories[$cat->id]->parent = $cat->parent;
		if ($cs = get_categories($cat->id)) {
			$categories[$cat->id]->categories = load_cattree($cs);
		} else {
			$categories[$cat->id]->categories = array();
		}
		$categories[$cat->id]->hascourses = false;
		
		// If user can create courses, need to get all categories with hascourses = true to let them printed
		if ((has_capability('moodle/course:create', get_context_instance(CONTEXT_SYSTEM))) AND ($USER->filter_menu=='all')) {
			$categories[$cat->id]->hascourses = true;
		}
	}
        return $categories;
}



/**
* Check all courses and switch all parent categories with "hascourse" setting
*
* @uses $categories;
* @param array $course Course array to analyse
* @return nothing
*/
function has_courses($course) {
	global $categories;
	
	$categories[$course->category]->hascourses = true;
	$categories[$course->category]->courses[$course->sortorder] = $course;
	
        // Make sure the courses are in the order specified.
        ksort($categories[$course->category]->courses);
	
        $catid = $course->category;
	
       while ($categories[$catid]->parent > 0) {
		$catid = $categories[$catid]->parent;
		$categories[$catid]->hascourses = true;
	}
}



/**
* Create the list of categories and course
*
* @uses $CFG;
* @uses $USER;
* @uses $categories;
* @param int $parent Parent id to begin
* @return bool
*/
function create_list($parent) {
	global $CFG,$USER,$categories;
	$list='';
	
	if ($result_cat = get_categories($parent)) {
		
		foreach ($result_cat as $cat) {
			if ($categories[$cat->id]->hascourses == true) {
				
				if ($cat->visible == 0){
					$category_status = 'hidden';
				} else {
					$category_status = 'visible';
				}
					
				$list .= '<li class="category'.$category_status.'"><a title="'.$cat->name.'" href="'.$CFG->wwwroot.'/course/category.php?id='.$cat->id.'" >'.shorten_text($cat->name,26,true).'</a><span class="droite"><img src="'.$CFG->wwwroot.'/filter/menu/pix/course.gif" /></span><ul>';
				
				// Print sub categories
				if (create_list($cat->id)) {
					$list .=create_list($cat->id);
				}
				
				// Print courses
				if (@$categories[$cat->id]->courses) {
					
					foreach ($categories[$cat->id]->courses as $course) {
						
						// Get user status in this course
						$context=get_context_instance(CONTEXT_COURSE, $course->id);
						if ((has_capability('moodle/course:update', $context)) AND ($USER->id) AND ($USER->username <> 'guest')) {
							$user_status='teacher';
						} elseif ((has_capability('moodle/course:view', $context)) AND ($USER->id) AND ($USER->username <> 'guest')) {
							$user_status='student';
						} else {
							// If no user status, get access conditions
							if ($course->password) {
								$user_status='key';
							} else {
								$user_status='';
							}
							
							// If guest and guest didn't need key in this course
							if ($course->guest == 1) {
								$user_status='guest';
							}
						}
						
						// Check if this course is visible
						if ($course->visible == 0) {
							$course_status='hidden';
						} else {
							$course_status='visible';
						}
						
						// Print the line
						$list .= '<li class="course'.$course_status.'"><a title="'.$course->fullname.'" href="'.$CFG->wwwroot.'/course/view.php?id='.$course->id.'" >'.shorten_text($course->shortname,21,true).'</a>';
	
						if ($user_status) {
							$list .= '<span class="droite_status"><img title="'.get_string($user_status, 'filter_menu').'" height="16" width="16" border="0" src="'.$CFG->wwwroot.'/filter/menu/pix/'.$user_status.'.gif" /></a></span>';
						}
						
						$list .= '<span class="droite_info"><a target="courseinfo" title="'.get_string('resume', 'filter_menu').'" href="'.$CFG->wwwroot.'/course/info.php?id='.$course->id.'" onclick="window.open(\''.$CFG->wwwroot.'/course/info.php?id='.$course->id.'\',\'courseinfo\',\'menubar=0,location=0,scrollbars,resizable,width=500,height=400\')"><img alt="'.get_string('resume' ,'filter_menu').'" height="16" width="16" border="0" src="'.$CFG->wwwroot.'/pix/i/info.gif" /></a></span></li>';	
					}
				}	
				$list .= '</ul></li>';	
			}	
		}
		return $list;
	}
	return false;
}



/**
* Count how many lines we be displayed in the menu at maxi
*
* @uses $categories;
* @uses $nbcat;
* @uses $nbcourse;
* @param $parent
* @return int $maxi Maxi nb. of lines
*/
function get_maxi($parent) {
	global $categories,$nbcat,$nbcourse;
	
	if ($result_cat = get_categories($parent)) {
		foreach ($result_cat as $cat) {			
			if ($categories[$cat->id]->hascourses == true) {
				
				// Count categories
				$nbcat[$cat->parent] = @$nbcat[$cat->parent]+1;
				
				// Search in subcategories
				get_maxi($cat->id);
				
				// Count courses
				if (@$categories[$cat->id]->courses) {
					foreach ($categories[$cat->id]->courses as $course) {
						$nbcourse[$cat->id]=@$nbcourse[$cat->id]+1;
					}
				}
			}						
		}
	}
	
	return true;
}

?>
