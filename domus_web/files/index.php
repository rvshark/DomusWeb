<?php // $Id: index.php,v 1.121.2.11 2009/09/28 18:57:25 skodak Exp $

//  Manage all uploaded files in a course file area

//  All the Moodle-specific stuff is in this top section
//  Configuration and access control occurs here.
//  Must define:  USER, basedir, baseweb, html_header and html_footer
//  USER is a persistent variable using sessions

    require("../config.php");
    require($CFG->libdir.'/filelib.php');
    require($CFG->libdir.'/adminlib.php');

    $id      = required_param('id', PARAM_INT);
//    $file    = optional_param('file', '', PARAM_PATH);
//    $wdir    = optional_param('wdir', '', PARAM_PATH);
//    $action  = optional_param('action', '', PARAM_ACTION);
//    $name    = optional_param('name', '', PARAM_FILE);
//    $oldname = optional_param('oldname', '', PARAM_FILE);
//    $choose  = optional_param('choose', '', PARAM_FILE); //in fact it is always 'formname.inputname'
//    $userfile= optional_param('userfile','',PARAM_FILE);
//    $save    = optional_param('save', 0, PARAM_BOOL);
//    $text    = optional_param('text', '', PARAM_RAW);
//    $confirm = optional_param('confirm', 0, PARAM_BOOL);

    if ($choose) {
        if (count(explode('.', $choose)) > 2) {
            error('Incorrect format for choose parameter');
        }
    }


    if (! $course = get_record("course", "id", $id) ) {
        error("That's an invalid course id");
    }

    require_login($course);

    require_capability('moodle/course:managefiles', get_context_instance(CONTEXT_COURSE, $course->id));

    function html_footer() {
        global $COURSE, $choose;

        echo '</td></tr></table>';

        print_footer($COURSE);
    }

    function html_header($course, $wdir, $formfield=""){
        global $CFG, $ME, $choose;

        $navlinks = array();
        // $navlinks[] = array('name' => $course->shortname, 'link' => "../course/view.php?id=$course->id", 'type' => 'misc');

        if ($course->id == SITEID) {
            $strfiles = get_string("sitefiles");
        } else {
            $strfiles = get_string("files");
        }

        if ($wdir == "/") {
            $navlinks[] = array('name' => $strfiles, 'link' => null, 'type' => 'misc');
        } else {
            $dirs = explode("/", $wdir);
            $numdirs = count($dirs);
            $link = "";
            $navlinks[] = array('name' => $strfiles,
                                'link' => $ME."?id=$course->id&amp;wdir=/&amp;choose=$choose",
                                'type' => 'misc');

            for ($i=1; $i<$numdirs-1; $i++) {
                $link .= "/".urlencode($dirs[$i]);
                $navlinks[] = array('name' => $dirs[$i],
                                    'link' => $ME."?id=$course->id&amp;wdir=$link&amp;choose=$choose",
                                    'type' => 'misc');
            }
            $navlinks[] = array('name' => $dirs[$numdirs-1], 'link' => null, 'type' => 'misc');
        }
		
        $navigation = build_navigation($navlinks);

        if ($choose) {
            print_header();

            $chooseparts = explode('.', $choose);
            if (count($chooseparts)==2){
            ?>
            <script type="text/javascript">
            //<![CDATA[
            function set_value(txt) {
                opener.document.forms['<?php echo $chooseparts[0]."'].".$chooseparts[1] ?>.value = txt;
                window.close();
            }
            //]]>
            </script>

            <?php
            } elseif (count($chooseparts)==1){
            ?>
            <script type="text/javascript">
            //<![CDATA[
            function set_value(txt) {
                opener.document.getElementById('<?php echo $chooseparts[0] ?>').value = txt;
                window.close();
            }
            //]]>
            </script>

            <?php

            }
            $fullnav = '';
            $i = 0;
            foreach ($navlinks as $navlink) {
                // If this is the last link do not link
                if ($i == count($navlinks) - 1) {
                    $fullnav .= $navlink['name'];
                } else {
                    $fullnav .= '<a href="'.$navlink['link'].'">'.$navlink['name'].'</a>';
                }
                $fullnav .= ' -> ';
                $i++;
            }
            $fullnav = substr($fullnav, 0, -4);
            $fullnav = str_replace('->', '&raquo;', format_string($course->shortname) . " -> " . $fullnav);
            echo '<div id="nav-bar">'.$fullnav.'</div>';

            if ($course->id == SITEID and $wdir != "/backupdata") {
                print_heading(get_string("publicsitefileswarning3"), "center", 2);
            }

        } else {

            if ($course->id == SITEID) {

                if ($wdir == "/backupdata") {
                    admin_externalpage_setup('frontpagerestore');
                    admin_externalpage_print_header();
                } else {
                    admin_externalpage_setup('sitefiles');
                    admin_externalpage_print_header();

                    print_heading(get_string("publicsitefileswarning3"), "center", 2);

                }

            } else {
            	
                print_header("$course->shortname: $strfiles", $course->fullname, $navigation,  $formfield);
                
            }
        }


        echo "<table border=\"0\" style=\"margin-left:auto;margin-right:auto\" cellspacing=\"3\" cellpadding=\"3\" width=\"640\">";
        echo "<tr>";
        echo "<td colspan=\"2\">";

    }


//    if (! $basedir = make_upload_directory("$course->id")) {
//        error("The site administrator needs to fix the file permissions");
//    }

    // make sure site files contain the backupdata or else people put backups into public area!!
//    if ($course->id == SITEID) {
//        if (!file_exists("$CFG->dataroot/$course->id/backupdata")) {
//            make_upload_directory("$course->id/backupdata");
//        }
//    }

//    $baseweb = $CFG->wwwroot;

//  End of configuration and access control

//
//    if ($wdir == '') {
//        $wdir = "/";
//    }

//    if ($wdir{0} != '/') {  //make sure $wdir starts with slash
//        $wdir = "/".$wdir;
//    }
//
//    if ($wdir == "/backupdata") {
//        if (! make_upload_directory("$course->id/backupdata")) {   // Backup folder
//            error("Could not create backupdata folder.  The site administrator needs to fix the file permissions");
//        }
//    }
//
//    if (!is_dir($basedir.$wdir)) {
//        html_header($course, $wdir);
//        error("Requested directory does not exist.", "$CFG->wwwroot/files/index.php?id=$id");
//    }

    

/// FILE FUNCTIONS ///////////////////////////////////////////////////////////

//
//function setfilelist($VARS) {
//    global $USER;
//
//    $USER->filelist = array ();
//    $USER->fileop = "";
//
//    $count = 0;
//    foreach ($VARS as $key => $val) {
//        if (substr($key,0,4) == "file") {
//            $count++;
//            $val = rawurldecode($val);
//            $USER->filelist[] = clean_param($val, PARAM_PATH);
//        }
//    }
//    return $count;
//}
//
//function clearfilelist() {
//    global $USER;
//
//    $USER->filelist = array ();
//    $USER->fileop = "";
//}
//
//
//function printfilelist($filelist) {
//    global $CFG, $basedir;
//
//    $strfolder = get_string("folder");
//    $strfile   = get_string("file");
//
//    foreach ($filelist as $file) {
//        if (is_dir($basedir.'/'.$file)) {
//            echo '<img src="'. $CFG->pixpath .'/f/folder.gif" class="icon" alt="'. $strfolder .'" /> '. htmlspecialchars($file) .'<br />';
//            $subfilelist = array();
//            $currdir = opendir($basedir.'/'.$file);
//            while (false !== ($subfile = readdir($currdir))) {
//                if ($subfile <> ".." && $subfile <> ".") {
//                    $subfilelist[] = $file."/".$subfile;
//                }
//            }
//            printfilelist($subfilelist);
//
//        } else {
//            $icon = mimeinfo("icon", $file);
//            echo '<img src="'. $CFG->pixpath .'/f/'. $icon .'" class="icon" alt="'. $strfile .'" /> '. htmlspecialchars($file) .'<br />';
//        }
//    }
//}
//
//
//function print_cell($alignment='center', $text='&nbsp;', $class='') {
//    if ($class) {
//        $class = ' class="'.$class.'"';
//    }
//    echo '<td align="'.$alignment.'" style="white-space:nowrap "'.$class.'>'.$text.'</td>';
//}

function displaydir ($wdir) {
	global $CFG,$id;
	
    echo "<table border=\"0\" cellspacing=\"2\" cellpadding=\"2\" width=\"640\"><tr>";
    echo "<td align=\"center\">";
    echo "<iframe scrolling='no' id=\"ibrowser2\" name=\"ibrowser2\" src=\"{$CFG->wwwroot}/files/gerenciar_arquivos.php?id=$id&choose=$choose\" style=\"width: 790px; height: 690px;\"></iframe>";
    echo "</tr>";
    echo "</table>";
    echo "<hr/>";
    //echo "<hr width=\"640\" align=\"center\" noshade=\"noshade\" size=\"1\" />";

}

html_header($course, $wdir);
displaydir($wdir);
html_footer();

?>
