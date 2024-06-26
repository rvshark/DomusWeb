<?php  // $Id: view.php,v 1.61 2007/01/27 19:14:23 skodak Exp $

    require_once("../../config.php");
    require_once("lib.php");
 
    $id = optional_param('id', 0, PARAM_INT);    // Course Module ID
    $r  = optional_param('r', 0, PARAM_INT);  // Resource

    if ($r) {  // Two ways to specify the resource
        if (! $resource = get_record('resource', 'id', $r)) {
            error('Resource ID was incorrect');
        }

        if (! $cm = get_coursemodule_from_instance('resource', $resource->id, $resource->course)) {
            error('Course Module ID was incorrect');
        }

    } else if ($id) {
        if (! $cm = get_coursemodule_from_id('resource', $id)) {
            error('Course Module ID was incorrect');
        }

        if (! $resource = get_record('resource', 'id', $cm->instance)) {
            error('Resource ID was incorrect');
        }
    } else {
        error('No valid parameters!!');
    }

    if (! $course = get_record('course', 'id', $cm->course)) {
        error('Incorrect course id');
    }

    require_course_login($course, true, $cm);

    require ($CFG->dirroot.'/mod/resource/type/'.$resource->type.'/resource.class.php');
	
	echo "<style type='text/css'>
			#header,.navbar{display:none;}
			#container{width:931px!important;}
			#gallery{min-height:1400px;}
		 </style>";
	
    $resourceclass = 'resource_'.$resource->type;
    $resourceinstance = new $resourceclass($cm->id);
	$resourceinstance->resource->options = 'printpage';	
    $resourceinstance->display();
		
	
	echo '<script language="JavaScript">
				$(document).ready(function(){
					window.print();
				});			
		  </script>';

?>
