<?php // $Id: index.php,v 1.3 2007/10/24 08:07:54 pigui Exp $

/// This page lists all the instances of wiki in a particular course
/// Replace wiki with the name of your module

    //this variable determine if we need all wiki libraries.
    $full_wiki = true;

	require_once("../../config.php");
    require_once("lib.php");

    $id = required_param('id',PARAM_INT);   // course

    if (! $course = get_record("course", "id", $id)) {
    	
		if (!$category = get_record("course_categories", "id", $id)) {
        	error("Category not known!");
    	}
		
		//verifica os cursos da categoria
		$sql = "select id, fullname from mdl_course where visible = 1 and category = $id order by sortorder";
		$cursos = get_recordset_sql($sql);
		
		if ($cursos != false) {

			$countPai = 0;


			print_header_simple("", "", "$", "", "", true, "", navmenu($category));
			
			$table->head  = array ("Selecione o conteúdo de <font color='green'>".$category->name."</font> para abrir o seu wiki");
        	$table->align = array ("left");
			
			while ($rs = rs_fetch_next_record($cursos)) {
				    $table->data[] = array ("<a href='".$CFG->wwwroot."/mod/wiki/index.php?id=" . $rs -> id . "' title='".$rs -> fullname."'>". $rs -> fullname . "</a>");
			}			
			
			print_table($table);
			echo "</br>";
    		print_footer($course);
			
			return;
		}
		else{
			error("Course ID is incorrect");			
		}	
        
    }

    require_login($course->id);

    add_to_log($course->id, 'wiki', "view all", "index.php?id=$course->id", "");


/// Get all required strings

    $strwikis = get_string("modulenameplural", 'wiki');
    $strwikis  = get_string("modulename", 'wiki');


	/// Print header.
    $navlinks = array();
    $navlinks[] = array('name' => get_string('modulenameplural','wiki'), 'link' => $CFG->wwwroot.'/mod/wiki/index.php?id='.$course->id, 'type' => 'activity');
    
    $navigation = build_navigation($navlinks);
    
    print_header_simple(format_string($course->fullname), "",
                 $navigation, "", "", true, "", navmenu($course, $WS->cm));
/// Get all the appropriate data

    if (! $wikis = get_all_instances_in_course('wiki', $course)) {
        notice("There are no wikis", "../../course/view.php?id=$course->id");
        die;
    }
    
	print_heading(get_string("modulenameplural", "wiki"));
/// Print the list of instances (your module will probably extend this)

    $timenow = time();
    $strname  = get_string('name');
    $strweek  = get_string('week');
    $strtopic  = get_string('topic');
    $strintro  = get_string('summary');

    if ($course->format == 'weeks') {
        $table->head  = array ($strweek, $strname, $strintro);
        $table->align = array ('center', 'left', 'left');
    } else if ($course->format == 'topics') {
        $table->head  = array ($strtopic, $strname, $strintro);
        $table->align = array ('center', 'left', 'left');
    } else {
        $table->head  = array ($strname, $strintro);
        $table->align = array ('left', 'left');
    }

    foreach ($wikis as $wiki) {
        if (!$wiki->visible) {
            //Show dimmed if the mod is hidden
            $link = "<a class=\"dimmed\" href=\"view.php?id=$wiki->coursemodule\">".s($wiki->name)."</a>";
        } else {
            //Show normal if the mod is visible
            $link = "<a href=\"view.php?id=$wiki->coursemodule\">".s($wiki->name)."</a>";
        }

        $introoptions->para=false;
        $intro = trim(format_text($wiki->intro, $wiki->introformat, $introoptions));

        if ($course->format == "weeks" or $course->format == "topics") {
            $table->data[] = array ($wiki->section, $link, $intro);
        } else {
            $table->data[] = array ($link, $intro);
        }
    }

    echo "<br />";

    print_table($table);

/// Finish the page

    print_footer($course);

?>
