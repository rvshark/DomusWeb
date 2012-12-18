<?php
/**
* This filter shows a dynamique course menu
* This is first a work of Kevin TREUSSIER
* I would make it more simple of use by using filter
* (to prevent core code modification)
* and adding some improvements to the original code
*
* [-MENU-]
*
* @package filter-menu
* @category filter
* @author Kevin TREUSSIER
* @author Eric BUGNET
* Looking for last version on http://buggy.free.fr/moodle/
*
*
*/

include_once($CFG->dirroot.'/filter/menu/lib.php');   

/**
* Change the first instance of [-MENU-] to create the menu
*
* @uses $CFG,$COURSE,$USER;
* @param string $text The text to filter
* @return string The text filtered
*/
function menu_filter($courseid, $text) {
	global $CFG,$COURSE,$USER;
	$CFG->currenttextiscacheable = false;
	$USER->filter_menu = optional_param('filter_menu', 'all', PARAM_TEXT);
	// If guest, show all courses
	if ($USER->username == 'guest') {
		$USER->filter_menu = 'all';
	}
	
	// Do a quick check to avoid unnecessary work
	// - Is there instance ?
	if (strpos($text, '[-MENU-]') === false) {
		return $text;
	}
	
	// There is job to do.... so let's do it !
	
	// Import css file
	if (file_exists($CFG->dirroot.'/theme/'.current_theme().'/filter_menu.css')) {
		echo '<style type="text/css">';
		echo '	@import url('. $CFG->httpsthemewww.'/'.current_theme().'/filter_menu.css);';
		echo '</style>';
	} else {
		echo '<style type="text/css">';
		echo '	@import url('.$CFG->wwwroot.'/filter/menu/filter_menu.css);';
		echo '</style>';
	}
	
	// If there is an instance...
	if (!strpos($text, '[-MENU-]')===false) {
		global $categories,$nbcat,$nbcourse;
		$nbcat=array();
		$nbcourse=array();
		
		/// Build the tree of categories
		$categories = get_categories(0);
		$cattree = load_cattree($categories);
		
		if (($USER->id) AND ($USER->filter_menu=='own')) {
			$courses = get_my_courses($USER->id);
		} else {
			$courses = get_courses('all');
		}
		

		
		foreach ($courses as $course) {
			if (!$course->category) {
				continue;
			}
			has_courses($course);
		}		
		                              
		$list = create_list(0);
		
		// Get maxi nb of lines
		$maxi=0;
		$cats0 = get_categories(0);
		foreach ($cats0 as $cat) {
			if ($categories[$cat->id]->hascourses) {
				$maxi++;
			}
		}

		get_maxi(0);
		
		foreach ($categories as $cat) {
			if (((@$nbcat[$cat->id]) OR (@$nbcourse[$cat->id])) AND ((@$nbcat[$cat->id]+@$nbcourse[$cat->id]) > $maxi)) {
				$maxi = (@$nbcat[$cat->id]+@$nbcourse[$cat->id]);
			}
		}
		
		// Let's print it
		$menu = '';
		$menu .= '<script type="text/javascript" src="'.$CFG->wwwroot.'/filter/menu/browserdetect.js"></script>';
		$menu .= '<script type="text/javascript" src="'.$CFG->wwwroot.'/filter/menu/dynMenu.js"></script>';
		$menu .= '<style type="text/css">#ancre_menu, #menu, #menu ul { height: '.(23*$maxi).'px; }</style>';
		$menu .= '<h2>'.get_string('title', 'filter_menu');
		$menu .= ' <a target="courseinfo" title="'.get_string('help', 'filter_menu').'" onclick="window.open(\''.$CFG->wwwroot.'/filter/menu/help.php\',\''.get_string('help', 'filter_menu').'\',\'menubar=0,location=0,scrollbars,resizable,width=500,height=400\')">';
		$menu .= '<span style="cursor:pointer"><img src="'.$CFG->wwwroot.'/filter/menu/pix/help.gif" /></span></a></h2>';
		
		// Print switch [all courses / my courses only]
		if ($USER->username <> 'guest') {
			if (($USER->id) AND ($USER->filter_menu=='own')) {
				$menu .= '<p class="switch"><a href="'.$CFG->wwwroot.'?filter_menu=all">'.get_string('viewallcourses', 'filter_menu').'</a></p>';
			} else if (($USER->id) AND ($USER->filter_menu=='all') ) {
				$menu .= '<p class="switch"><a href="'.$CFG->wwwroot.'?filter_menu=own">'.get_string('viewmycourses', 'filter_menu').'</a></p>';
			}
		}
		
		// Print the menu
		$menu .= '<div align="center"><p id="ancre_menu"><ul id="menu">';
		$menu .= $list;
		$menu .= '</ul></p>';
		$menu .= '<script type="text/javascript">initMenu();</script>';
		
		// Print search box
		$menu .= print_course_search('',true);
		$menu .= '</div>';
		
		// Change chain in text
		$text = str_replace('[-MENU-]',$menu,$text);
	}
	return $text;
}
?>