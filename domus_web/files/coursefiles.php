<?php // $Id: coursefiles.php,v 1.13.8.6 2009/06/09 04:58:38 jonathanharker Exp $

//  Manage all uploaded files in a course file area

//  This file is a hack to files/index.php that removes
//  the headers and adds some controls so that images
//  can be selected within the Richtext editor.

//  All the Moodle-specific stuff is in this top section
//  Configuration and access control occurs here.
//  Must define:  USER, basedir, baseweb, html_header and html_footer
//  USER is a persistent variable using sessions

require("../config.php");
require_once($CFG->libdir.'/filelib.php');

$id      = required_param('id', PARAM_INT);
$conteudo_id = optional_param('conteudo_id',0, PARAM_INT);
$file    = optional_param('file', '', PARAM_PATH);
$wdir    = optional_param('wdir', '', PARAM_PATH);
$action  = optional_param('action', '', PARAM_ACTION);
$name    = optional_param('name', '', PARAM_FILE);
$oldname = optional_param('oldname', '', PARAM_FILE);
$usecheckboxes  = optional_param('usecheckboxes', 1, PARAM_INT);
$save     = optional_param('save', 0, PARAM_BOOL);
$text     = optional_param('text', '', PARAM_RAW);
$confirm  = optional_param('confirm', 0, PARAM_BOOL);
$images   = optional_param("images", 0, PARAM_INT);
$keywords = optional_param("keywords", '', PARAM_ALPHA);
$idSearch = optional_param("idSearch", 0, PARAM_INT);
$type	  = optional_param("typeFile", 'all', PARAM_ALPHA);

if (!$course = get_record("course", "id", $id)) {
	error("Curso inválido");
}

//Verificar se e para mostrar apenas os arquivos do conteudo selecionado

if($conteudo_id > 0 && $wdir == ""){
	$wdir = "/Conteudos/$conteudo_id" ;		
	$idSearch = $id.$wdir;
}

//new dBug($wdir);


function html_footer() {
	echo "\n\n</body>\n</html>";
}

function html_header($course, $wdir, $formfield=""){

	global $CFG,$images;

	if (!empty($_SERVER['HTTPS']) and $_SERVER['HTTPS'] != 'off') {
		$url = preg_replace('|https?://[^/]+|', '', $CFG->wwwroot).'/files/';
	} else {
		$url = $CFG->wwwroot.'/files/';
	}

	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
            "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>coursefiles</title>
<script type="text/javascript"><!--
//<![CDATA[


        function set_value(params) {
            /// function's argument is an object containing necessary values
            /// to export parent window (url,isize,itype,iwidth,iheight, imodified)
            /// set values when user click's an image name.
            var upper = window.parent;
            var insimg = upper.document.getElementById('f_url');

            try {
                if(insimg != null) {
                    if(params.itype.indexOf("image/gif") == -1 && 
                       params.itype.indexOf("image/jpeg") == -1 && 
                       params.itype.indexOf("image/png") == -1) {

				 	   <?php if($images == 1){?> 
                        	
                        	alert("<?php print_string("notimage","editor");?>");
                        	return false;
                        
                        <?php }else{?>
	                        for(field in params) {
		                        var value = params[field];
					
		                        switch(field) {
		                        case "url"   :   upper.document.getElementById('f_url').value = value;
		                                 		 upper.ipreview.location.replace('preview.php?id='+ <?php print($course->id)?> +'&imageurl='+ value + '&error=1');
		                            break;
		                        case "isize" :   upper.document.getElementById('isize').value = value; break;
		                        case "itype" :   upper.document.getElementById('itype').value = value; break;
	                            case "iwidth":   upper.document.getElementById('f_width').value = '-'; break;
	                            case "iheight":  upper.document.getElementById('f_height').value = '-'; break;
		                   		}
	                        }
                        <?php } ?>
                    }
                    for(field in params) {
                        var value = params[field];
                        switch(field) {
                            case "url"   :   upper.document.getElementById('f_url').value = value;
                                 			 upper.ipreview.location.replace('preview.php?id='+ <?php print($course->id);?> +'&imageurl=' + value);break;
                            case "isize" :   upper.document.getElementById('isize').value = value; break;
                            case "itype" :   upper.document.getElementById('itype').value = value; break;
                            case "iwidth":   upper.document.getElementById('f_width').value = value; break;
                            case "iheight":  upper.document.getElementById('f_height').value = value; break;
                        }
                    }
                } else {
                    for(field in params) {
                        var value = params[field];
                        switch(field) {
                            case "url" :
                                //upper.document.getElementById('f_href').value = value;
                                upper.opener.document.getElementById('f_href').value = value;
                                upper.close();
                                break;
                            //case "imodified" : upper.document.getElementById('imodified').value = value; break;
                            //case "isize" : upper.document.getElementById('isize').value = value; break;
                            //case "itype" : upper.document.getElementById('itype').value = value; break;
                        }
                    }
                }
            } catch(e) {
                if ( window.tinyMCE != "undefined" || window.TinyMCE != "undefined" ) {
                    upper.opener.Dialog._return(params.url);
                    upper.close();
                } else {
                    alert("Something odd just occurred!!!");
                }
            }
            return false;
        }

        function set_dir(strdir) {
            // sets wdir values
            var upper = window.parent.document;
            if(upper) {
                for(var i = 0; i < upper.forms.length; i++) {
                    var f = upper.forms[i];
                    try {
                        f.wdir.value = strdir;
                    } catch (e) {

                    }
                }
            }
        }

        /*function set_rename(strfile) {
            var upper = window.parent.document;
            upper.getElementById('irename').value = strfile;
            return true;
        }*/

        function reset_value() {
            var upper = window.parent.document;
            for(var i = 0; i < upper.forms.length; i++) {
                var f = upper.forms[i];
                for(var j = 0; j < f.elements.length; j++) {
                    var e = f.elements[j];
                    if(e.type != "submit" && e.type != "button" && e.type != "hidden") {
                        try {
                            e.value = "";
                        } catch (e) {
                        }
                    }
                }
            }
            //upper.getElementById('irename').value = 'xx';

            var prev = window.parent.ipreview;
            if(prev != null) {
                prev.location.replace('<?php echo $url ?>blank.html');
            }
            var uploader = window.parent.document.forms['uploader'];
            if(uploader != null) {
                uploader.reset();
            }
            set_dir('<?php print($wdir);?>');
            return true;
        }

//]]>
--></script>
<style type="text/css">
body {
	background-color: white;
	margin-top: 2px;
	margin-left: 4px;
	margin-right: 4px;
}

body,p,table,td,input,select,a {
	font-family: Tahoma, sans-serif;
	font-size: 11px;
}

select {
	position: absolute;
	top: -20px;
	left: 0px;
}

img.icon {
	vertical-align: middle;
	margin-right: 4px;
	width: 16px;
	height: 16px;
	border: 0px;
}
</style>
</head>
<body onload="reset_value();">

                        <?php
}

if (!$basedir = make_upload_directory("$course->id")) {
//if (!$basedir = make_upload_directory($idSearch == 0 ? $course->id : $idSearch)) {
	error("The site administrator needs to fix the file permissions");
}

$baseweb = $CFG->wwwroot;

//  End of configuration and access control


if ($wdir == '') {
	$wdir='/';
}

switch ($action) {
	case "search":
		clearfilelist();
		html_header($course, $wdir);
		displaydir($wdir);
		html_footer();
		break;
	
	case "upload":
		html_header($course, $wdir);
		require_once($CFG->dirroot.'/lib/uploadlib.php');
		if ($save and confirm_sesskey()) {
			$um = new upload_manager('userfile',false,false,$course,false,0);
			$dir = "$basedir$wdir";
			if ($um->process_file_uploads($dir)) {
				notify(get_string('uploadedfile'));
			}
			// um will take care of error reporting.
			displaydir($wdir);
		} else {
			$upload_max_filesize = get_max_upload_file_size($CFG->maxbytes);
			$filesize = display_size($upload_max_filesize);

			$struploadafile = get_string("uploadafile");
			$struploadthisfile = get_string("uploadthisfile");
			$strmaxsize = get_string("maxsize", "", $filesize);
			$strcancel = get_string("cancel");

			echo "<p>$struploadafile ($strmaxsize) --> <strong>$wdir</strong>";
			echo "<table border=\"0\"><tr><td colspan=\"2\">\n";
			echo "<form enctype=\"multipart/form-data\" method=\"post\" action=\"coursefiles.php\">\n";
			upload_print_form_fragment(1,array('userfile'),null,false,null,$course->maxbytes,0,false);
			echo " <input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
			echo " <input type=\"hidden\" name=\"conteudo_id\" value=\"$conteudo_id\" />\n";
			echo " <input type=\"hidden\" name=\"images\" value=\"$images\" />\n";
			echo " <input type=\"hidden\" name=\"wdir\" value=\"$wdir\" />\n";
			echo " <input type=\"hidden\" name=\"action\" value=\"upload\" />\n";
			echo " <input type=\"hidden\" name=\"sesskey\" value=\"$USER->sesskey\" />\n";
			echo " </td><tr><td align=\"right\">";
			echo " <input type=\"submit\" name=\"save\" value=\"$struploadthisfile\" />\n";
			echo "</form>\n";
			echo "</td>\n<td>\n";
			echo "<form action=\"coursefiles.php\" method=\"get\">\n";
			echo " <input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
			echo " <input type=\"hidden\" name=\"conteudo_id\" value=\"$conteudo_id\" />\n";
			echo " <input type=\"hidden\" name=\"images\" value=\"$images\" />\n";
			echo " <input type=\"hidden\" name=\"wdir\" value=\"$wdir\" />\n";
			echo " <input type=\"hidden\" name=\"action\" value=\"cancel\" />\n";
			echo " <input type=\"submit\" value=\"$strcancel\" />\n";
			echo "</form>\n";
			echo "</td>\n</tr>\n</table>\n";
		}
		html_footer();
		break;

	case "delete":
		if ($confirm and confirm_sesskey()) {
			html_header($course, $wdir);
			foreach ($USER->filelist as $file) {
				$fullfile = $basedir.$file;
				if (! fulldelete($fullfile)) {
					echo "<br />Erro: N�o pode deletar: $fullfile";
				}
			}
			clearfilelist();
			displaydir($wdir);
			html_footer();

		} else {
			html_header($course, $wdir);
			if (setfilelist($_POST)) {
				echo "<p align=center>".get_string("deletecheckwarning").":</p>";
				print_simple_box_start("center");
				printfilelist($USER->filelist);
				print_simple_box_end();
				echo "<br />";
				$frameold = $CFG->framename;
				$CFG->framename = "ibrowser";
				notice_yesno (get_string("deletecheckfiles"),
                                "coursefiles.php?id=$id&images=$images&amp;wdir=$wdir&amp;action=delete&amp;confirm=1&amp;sesskey=$USER->sesskey",
                                "coursefiles.php?id=$id&images=$images&amp;wdir=$wdir&amp;action=cancel;sesskey=$USER->sesskey");
				$CFG->framename = $frameold;
			} else {
				displaydir($wdir);
			}
			html_footer();
		}
		break;

	case "move":
		html_header($course, $wdir);
		if ($count = setfilelist($_POST) and confirm_sesskey()) {
			$USER->fileop     = $action;
			$USER->filesource = $wdir;
			echo "<p align=\"center\">";
			print_string("selectednowmove", "moodle", $count);
			echo "</p>";
		}
		displaydir($wdir);
		html_footer();
		break;

	case "paste":
		html_header($course, $wdir);
		if (isset($USER->fileop) and $USER->fileop == "move" and confirm_sesskey()) {
			foreach ($USER->filelist as $file) {
				$shortfile = basename($file);
				$oldfile = $basedir.$file;
				$newfile = $basedir.$wdir."/".$shortfile;
				if (!rename($oldfile, $newfile)) {
					echo "<p>Erro: $shortfile n�o foi movido";
				}
			}
		}
		clearfilelist();
		displaydir($wdir);
		html_footer();
		break;

	case "rename":
		if (!empty($name) and confirm_sesskey()) {
			html_header($course, $wdir);
			$name    = clean_filename($name);
			if (file_exists($basedir.$wdir."/".$name)) {
				echo "Erro: $name j� existe!";
			} else if (!@rename($basedir.$wdir."/".$oldname, $basedir.$wdir."/".$name)) {
				echo "Erro: n�o pode ser renomeado de $oldname para $name";
			}
			displaydir($wdir);

		} else {
			$strrename = get_string("rename");
			$strcancel = get_string("cancel");
			$strrenamefileto = get_string("renamefileto", "moodle", $file);
			html_header($course, $wdir, "form.name");
			echo "<p>$strrenamefileto:";
			echo "<table border=\"0\">\n<tr>\n<td>\n";
			echo "<form action=\"coursefiles.php\" method=\"post\" id=\"form\">\n";
			echo " <input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
			echo " <input type=\"hidden\" name=\"conteudo_id\" value=\"$conteudo_id\" />\n";
			echo " <input type=\"hidden\" name=\"images\" value=\"$images\" />\n";
			echo " <input type=\"hidden\" name=\"wdir\" value=\"$wdir\" />\n";
			echo " <input type=\"hidden\" name=\"action\" value=\"rename\" />\n";
			echo " <input type=\"hidden\" name=\"sesskey\" value=\"$USER->sesskey\" />\n";
			echo " <input type=\"hidden\" name=\"oldname\" value=\"$file\" />\n";
			echo " <input type=\"text\" name=\"name\" size=\"35\" value=\"$file\" />\n";
			echo " <input type=\"submit\" value=\"$strrename\" />\n";
			echo "</form>\n";
			echo "</td><td>\n";
			echo "<form action=\"coursefiles.php\" method=\"get\">\n";
			echo " <input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
			echo " <input type=\"hidden\" name=\"conteudo_id\" value=\"$conteudo_id\" />\n";
			echo " <input type=\"hidden\" name=\"images\" value=\"$images\" />\n";
			echo " <input type=\"hidden\" name=\"wdir\" value=\"$wdir\" />\n";
			echo " <input type=\"hidden\" name=\"action\" value=\"cancel\" />\n";
			echo " <input type=\"hidden\" name=\"sesskey\" value=\"$USER->sesskey\" />\n";
			echo " <input type=\"submit\" value=\"$strcancel\" />\n";
			echo "</form>";
			echo "</td></tr>\n</table>\n";
		}
		html_footer();
		break;

	case "mkdir":
		if (!empty($name) and confirm_sesskey()) {
			html_header($course, $wdir);
			$name = clean_filename($name);
			if (file_exists("$basedir$wdir/$name")) {
				echo "Erro: $name j� existe!";
			} else if (! make_upload_directory("$course->id/$wdir/$name")) {
				echo "Erro: $name n�o pode ser criado";
			}
			displaydir($wdir);

		} else {
			$strcreate = get_string("create");
			$strcancel = get_string("cancel");
			$strcreatefolder = get_string("createfolder", "moodle", $wdir);
			html_header($course, $wdir, "form.name");
			echo "<p>$strcreatefolder:";
			echo "<table border=\"0\">\n<tr><td>\n";
			echo "<form action=\"coursefiles.php\" method=\"post\" name=\"form\">\n";
			echo " <input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
			echo " <input type=\"hidden\" name=\"conteudo_id\" value=\"$conteudo_id\" />\n";
			echo " <input type=\"hidden\" name=\"images\" value=\"$images\" />\n";
			echo " <input type=\"hidden\" name=\"wdir\" value=\"$wdir\" />\n";
			echo " <input type=\"hidden\" name=\"action\" value=\"mkdir\" />\n";
			echo " <input type=\"hidden\" name=\"sesskey\" value=\"$USER->sesskey\" />\n";
			echo " <input type=\"text\" name=\"name\" size=\"35\" />\n";
			echo " <input type=\"submit\" value=\"$strcreate\" />\n";
			echo "</form>\n";
			echo "</td><td>\n";
			echo "<form action=\"coursefiles.php\" method=\"get\">\n";
			echo " <input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
			echo " <input type=\"hidden\" name=\"conteudo_id\" value=\"$conteudo_id\" />\n";
			echo " <input type=\"hidden\" name=\"images\" value=\"$images\" />\n";
			echo " <input type=\"hidden\" name=\"wdir\" value=\"$wdir\" />\n";
			echo " <input type=\"hidden\" name=\"action\" value=\"cancel\" />\n";
			echo " <input type=\"submit\" value=\"$strcancel\" />\n";
			echo "</form>\n";
			echo "</td>\n</tr>\n</table>\n";
		}
		html_footer();
		break;

	case "edit":
		html_header($course, $wdir);
		if (($text != '') and confirm_sesskey()) {
			$fileptr = fopen($basedir.$file,"w");
			fputs($fileptr, stripslashes($text));
			fclose($fileptr);
			displaydir($wdir);

		} else {
			$streditfile = get_string("edit", "", "<strong>$file</strong>");
			$fileptr  = fopen($basedir.$file, "r");
			$contents = fread($fileptr, filesize($basedir.$file));
			fclose($fileptr);

			print_heading("$streditfile");

			echo "<table><tr><td colspan=\"2\">\n";
			echo "<form action=\"coursefiles.php\" method=\"post\" name=\"form\" $onsubmit>\n";
			echo " <input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
			echo " <input type=\"hidden\" name=\"conteudo_id\" value=\"$conteudo_id\" />\n";
			echo " <input type=\"hidden\" name=\"images\" value=\"$images\" />\n";
			echo " <input type=\"hidden\" name=\"wdir\" value=\"$wdir\" />\n";
			echo " <input type=\"hidden\" name=file value=\"$file\" />";
			echo " <input type=\"hidden\" name=\"action\" value=\"edit\" />\n";
			echo " <input type=\"hidden\" name=\"sesskey\" value=\"$USER->sesskey\" />\n";
			print_textarea(false, 25, 80, 680, 400, "text", $contents);
			echo "</td>\n</tr>\n<tr>\n<td>\n";
			echo " <input type=\"submit\" value=\"".get_string("savechanges")."\" />\n";
			echo "</form>\n";
			echo "</td>\n<td>\n";
			echo "<form action=\"coursefiles.php\" method=\"get\">\n";
			echo " <input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
			echo " <input type=\"hidden\" name=\"conteudo_id\" value=\"$conteudo_id\" />\n";
			echo " <input type=\"hidden\" name=\"images\" value=\"$images\" />\n";
			echo " <input type=\"hidden\" name=\"wdir\" value=\"$wdir\" />\n";
			echo " <input type=\"hidden\" name=\"action\" value=\"cancel\" />\n";
			echo " <input type=\"submit\" value=\"".get_string("cancel")."\" />\n";
			echo "</form>\n";
			echo "</td></tr></table>\n";

			if ($usehtmleditor) {
				use_html_editor("text");
			}


		}
		html_footer();
		break;

	case "zip":
		if (!empty($name) and confirm_sesskey()) {
			html_header($course, $wdir);
			$name = clean_filename($name);

			$files = array();
			foreach ($USER->filelist as $file) {
				$files[] = "$basedir/$file";
			}

			if (!zip_files($files,"$basedir/$wdir/$name")) {
				print_error("zipfileserror","error");
			}

			clearfilelist();
			displaydir($wdir);

		} else {
			html_header($course, $wdir, "form.name");

			if (setfilelist($_POST)) {
				echo "<p align=\"center\">".get_string("youareabouttocreatezip").":</p>";
				print_simple_box_start("center");
				printfilelist($USER->filelist);
				print_simple_box_end();
				echo "<br />";
				echo "<p align=\"center\">".get_string("whattocallzip");
				echo "<table border=\"0\">\n<tr>\n<td>\n";
				echo "<form action=\"coursefiles.php\" method=\"post\" name=\"form\">\n";
				echo " <input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
				echo " <input type=\"hidden\" name=\"conteudo_id\" value=\"$conteudo_id\" />\n";
				echo " <input type=\"hidden\" name=\"images\" value=\"$images\" />\n";
				echo " <input type=\"hidden\" name=\"wdir\" value=\"$wdir\" />\n";
				echo " <input type=\"hidden\" name=\"action\" value=\"zip\" />\n";
				echo " <input type=\"hidden\" name=\"sesskey\" value=\"$USER->sesskey\" />\n";
				echo " <INPUT type=\"text\" name=\"name\" size=\"35\" value=\"new.zip\" />\n";
				echo " <input type=\"submit\" value=\"".get_string("createziparchive")."\" />";
				echo "</form>\n";
				echo "</td>\n<td>\n";
				echo "<form action=\"coursefiles.php\" method=\"get\">\n";
				echo " <input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
				echo " <input type=\"hidden\" name=\"conteudo_id\" value=\"$conteudo_id\" />\n";
				echo " <input type=\"hidden\" name=\"images\" value=\"$images\" />\n";
				echo " <input type=\"hidden\" name=\"wdir\" value=\"$wdir\" />\n";
				//echo " <input type=\"hidden\" name=\"action\" value=\"cancel\" />\n";
				echo " <input type=\"submit\" value=\"".get_string("cancel")."\" />\n";
				echo "</form>\n";
				echo "</td>\n</tr>\n</table>\n";
			} else {
				displaydir($wdir);
				clearfilelist();
			}
		}
		html_footer();
		break;

	case "unzip":
		html_header($course, $wdir);
		if (!empty($file) and confirm_sesskey()) {
			$strok = get_string("ok");
			$strunpacking = get_string("unpacking", "", $file);

			echo "<p align=\"center\">$strunpacking:</p>";

			$file = basename($file);

			if (!unzip_file("$basedir/$wdir/$file")) {
				print_error("unzipfileserror","error");
			}

			echo "<center><form action=\"coursefiles.php\" method=\"get\">\n";
			echo " <input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
			echo " <input type=\"hidden\" name=\"conteudo_id\" value=\"$conteudo_id\" />\n";
			echo " <input type=\"hidden\" name=\"images\" value=\"$images\" />\n";
			echo " <input type=\"hidden\" name=\"wdir\" value=\"$wdir\" />\n";
			echo " <input type=\"hidden\" name=\"action\" value=\"cancel\" />\n";
			echo " <input type=\"submit\" value=\"$strok\" />\n";
			echo "</form>\n";
			echo "</center>\n";
		} else {
			displaydir($wdir);
		}
		html_footer();
		break;

	case "listzip":
		html_header($course, $wdir);
		if (!empty($file) and confirm_sesskey()) {
			$strname = get_string("name");
			$strsize = get_string("size");
			$strmodified = get_string("modified");
			$strok = get_string("ok");
			$strlistfiles = get_string("listfiles", "", $file);

			echo "<p align=\"center\">$strlistfiles:</p>";
			$file = basename($file);

			require_once($CFG->libdir.'/pclzip/pclzip.lib.php');
			$archive = new PclZip("$basedir/$wdir/$file");
			if (!$list = $archive->listContent("$basedir/$wdir")) {
				notify($archive->errorInfo(true));

			} else {
				echo "<table cellpadding=\"4\" cellspacing=\"2\" border=\"0\">\n";
				echo "<tr>\n<th align=\"left\" scope=\"col\">$strname</th><th align=\"right\" scope=\"col\">$strsize</th><th align=\"right\" scope=\"col\">$strmodified</th></tr>";
				foreach ($list as $item) {
					echo "<tr>";
					print_cell("left", $item['filename']);
					if (! $item['folder']) {
						print_cell("right", display_size($item['size']));
					} else {
						echo "<td>&nbsp;</td>\n";
					}
					$filedate  = userdate($item['mtime'], get_string("strftimedatetime"));
					print_cell("right", $filedate);
					echo "</tr>\n";
				}
				echo "</table>\n";
			}
			echo "<br /><center><form action=\"coursefiles.php\" method=\"get\">\n";
			echo " <input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
			echo " <input type=\"hidden\" name=\"conteudo_id\" value=\"$conteudo_id\" />\n";
			echo " <input type=\"hidden\" name=\"images\" value=\"$images\" />\n";
			echo " <input type=\"hidden\" name=\"wdir\" value=\"$wdir\" />\n";
			echo " <input type=\"hidden\" name=\"action\" value=\"cancel\" />\n";
			echo " <input type=\"hidden\" name=\"sesskey\" value=\"$USER->sesskey\" />\n";
			echo " <input type=\"submit\" value=\"$strok\" />\n";
			echo "</form>\n";
			echo "</center>\n";
		} else {
			displaydir($wdir);
		}
		html_footer();
		break;

	case "cancel":
		html_header($course, $wdir);
		displaydir($wdir);
		break;

	case "uncheckall":
		html_header($course, $wdir);
		displaydir($wdir);
		html_footer();
		echo "<script type=\"text/javascript\">
				var inputs = document.getElementsByTagName('input');
	            for(var i = 0; i < inputs.length; i++) {
	                inputs[i].checked = false;
	            } 
		      </script>";

		break;

	case "checkall":
		html_header($course, $wdir);
		displaydir($wdir);
		html_footer();
		echo "<script type=\"text/javascript\">
				var inputs = document.getElementsByTagName('input');
	            for(var i = 0; i < inputs.length; i++) {
	                inputs[i].checked = true;
	            } 
		      </script>";

		break;
	
	default:
		html_header($course, $wdir);
		displaydir($wdir);
		html_footer();
		break;
}


/// FILE FUNCTIONS ///////////////////////////////////////////////////////////


function setfilelist($VARS) {
	global $USER;

	$USER->filelist = array ();
	$USER->fileop = "";

	$count = 0;
	foreach ($VARS as $key => $val) {
		if (substr($key,0,4) == "file") {
			$count++;
			$val = rawurldecode($val);
			if (!detect_munged_arguments($val, 0)) {
				$USER->filelist[] = $val;
			}
		}
	}
	return $count;
}

function clearfilelist() {
	global $USER;

	$USER->filelist = array ();
	$USER->fileop = "";
}

function printfilelist($filelist) {
	global $basedir, $CFG;

	foreach ($filelist as $file) {
		if (is_dir($basedir.$file)) {
			echo "<img src=\"$CFG->pixpath/f/folder.gif\" class=\"icon\" alt=\"".get_string('folder')."\" /> $file<br />";
			$subfilelist = array();
			$currdir = opendir($basedir.$file);
			while (false !== ($subfile = readdir($currdir))) {
				if ($subfile <> ".." && $subfile <> ".") {
					$subfilelist[] = $file."/".$subfile;
				}
			}
			printfilelist($subfilelist);

		} else {
			$icon = mimeinfo("icon", $file);
			echo "<img src=\"$CFG->pixpath/f/$icon\"  class=\"icon\" alt=\"".get_string('file')."\" /> $file<br />";
		}
	}
}


function print_cell($alignment="center", $text="&nbsp;") {
	echo "<td align=\"$alignment\" nowrap=\"nowrap\">\n";
	echo "$text";
	echo "</td>\n";
}

function get_image_size($filepath) {
	/// This function get's the image size

	/// Check if file exists
	if(!file_exists($filepath)) {
		return false;
	} else {
		/// Get the mime type so it really an image.
		if(mimeinfo("icon", basename($filepath)) != "image.gif") {
			return false;
		} else {
			$array_size = getimagesize($filepath);
			return $array_size;
		}
	}
	unset($filepath,$array_size);
}

/**
 * @param unknown_type $pattern - Palavra para comparacao
 * @param unknown_type $string - nome do arquivo para ser comparado
 * @return retorna true se existe o pattern dentro no nome do arquivo e falso
 * 			caso n�o exista.
 */
function fnmatch2($pattern, $string) {
	$pattern = '*'.$pattern.'*';

	if(@preg_match('/^' . strtr(addcslashes($pattern, '\\.+^$(){}=!<>|'), array('*' => '.*', '?' => '.?')) . '$/i', $string) == 1)
	return true;
	else
	return false;
}

/**
 * @param $root_dir - Diretorio raiz do data onde encontra os diretorios
 * @param $keyword - Filtro palavra chave para busca dentro dos diretorios
 * @param $idSearch - Filtro id do curso onde sera apenas percorrido a busca. Obs.: id=0 varre todos os diretorios
 * @param $type - Filtro por tipo de arquivo
 * @param $all_data - Todos os arquivos encontrados
 * @return retorna todos os arquivos encontrado na busca
 */
function get_files($dir,$allow_extensions,$all_data=array())
{
	global $keywords,$type;

	//Listar os arquivos do diretorio
	$dir_content = scandir($dir);
	
	
	//Verifica todos os arquivos
	foreach($dir_content as $key => $content)
	{
		if ($content == "." || $content == "..") {
			continue;
		}
		
		$path = $dir.'/'.$content;
		$content_chunks = explode(".",$content);
		$ext = strtolower($content_chunks[count($content_chunks) - 1]);
				
		if($keywords != "" && !fnmatch2($keywords,$content) && is_file($path)){
			continue;
		}		

		// salva o arquivo com o path no array
		if (in_array($ext, $allow_extensions) && is_file($path))
		{			
			$all_data[] = $path;
			
		}
		else if($type == "all" && is_file($path))
		{
			$all_data[] = $path;
		}

		// Verifica se o content � um diretorio, caso seja ira chamar a fun��o
		// recursivamente at� abrir todos os diretorios
		if(is_dir($path) && is_readable($path))
		{
			$all_data = get_files($path,$allow_extensions,$all_data);
		}
		
	}

	return $all_data;
}

/**
 * @param $wdir - Imprime a listagem de arquivos
 */
function displaydir ($wdir) {
	//  $wdir == / or /a or /a/b/c/d  etc

	global $basedir;
	global $usecheckboxes;
	global $id,$images,$type,$keywords;
	global $idSearch;
	global $USER, $CFG;
	global $conteudo_id;
	
	$filelist = array();
	$fullpath = $CFG->dataroot;
	
	if($keywords != "" || $type != "all")
	{		
		static $dir = array();
		$allow_extensions = array();

		//Verifica se tem filtro de curso para varrer apenas o diretorio solicitado
		$dir = $idSearch == 0 ? $fullpath : "$fullpath/$idSearch";

		if($type == 'img'){
			$allow_extensions = array("png", "jpeg", "jpg", "gif", "pmg", "bmp");
		}
		else if($type == 'docs'){
			$allow_extensions = array("doc", "docx", "xls", "xlsx", "txt", "html", "ppt", "pptx","pps","ppsx");
		}
		else if($type == 'doc'){
			$allow_extensions = array("doc", "docx");
		}		
		else if($type == 'ppt'){
			$allow_extensions = array("ppt", "pptx","pps","ppsx");
		}
		else if($type == 'pdf'){
			$allow_extensions = array("pdf");
		}
		else if($type == 'video'){
			$allow_extensions = array("flv","wmv","mp4");
		}

		$filelist = array_merge($filelist, get_files($dir,$allow_extensions));

	}else if($idSearch > 0){ //se é selecionado um cursos diferente do atual

		$fullpath = $idSearch == 0 ? $fullpath : "$fullpath/$idSearch";
		$directory = opendir($fullpath);             // Find all files
		while (false !== ($file = readdir($directory))) {
			if ($file == "." || $file == "..") {
				continue;
			}

			if (is_dir($fullpath."/".$file)) {
				$dirlist[] = $file;
			} else {
				$filelist[] = $file;
			}
		}
	}else{ //se é o curso atual sem filtros
		$fullpath = $basedir.$wdir;
		$directory = opendir($fullpath);             // Find all files
		while (false !== ($file = readdir($directory))) {
			if ($file == "." || $file == "..") {
				continue;
			}

			if (is_dir($fullpath."/".$file)) {
				$dirlist[] = $file;
			} else {
				$filelist[] = $file;
			}
		}
	}
	closedir($directory);

	$strfile = get_string("file");
	$strname = get_string("name");
	$strsize = get_string("size");
	$strmodified = get_string("modified");
	$straction = get_string("action");
	$strmakeafolder = get_string("makeafolder");
	$struploadafile = get_string("uploadafile");
	$strwithchosenfiles = get_string("withchosenfiles");
	$strmovetoanotherfolder = get_string("movetoanotherfolder");
	$strmovefilestohere = get_string("movefilestohere");
	$strdeletecompletely = get_string("deletecompletely");
	$strcheckall = get_string("selectall");
	$struncheckall = get_string("deselectall");
	$strcreateziparchive = get_string("createziparchive");
	$strrename = get_string("rename");
	$stredit   = get_string("edit");
	$strunzip  = get_string("unzip");
	$strlist   = get_string("list");
	$strchoose   = get_string("choose");


	echo "<form action=\"coursefiles.php\" method=\"post\" name=\"dirform\">\n";
	echo "<table border=\"0\" cellspacing=\"2\" cellpadding=\"2\" width=\"100%\">\n";

	if ($wdir == "/") {
		$wdir = "";
	} 
	else if($wdir == "/Conteudos/$conteudo_id"){
		$wdir = "/Conteudos/$conteudo_id";
	}	
	else {
		$bdir = str_replace("/".basename($wdir),"",$wdir);
		if($bdir == "/") {
			$bdir = "";
		}
		print "<tr>\n<td colspan=\"5\">";
		print "<a href=\"coursefiles.php?id=$id&conteudo_id=$conteudo_id&images=$images&amp;wdir=$bdir&amp;usecheckboxes=$usecheckboxes\" onclick=\"return reset_value();\">";
		print "<img src=\"$CFG->wwwroot/lib/editor/htmlarea/images/folderup.gif\" height=\"14\" width=\"24\" border=\"0\" alt=\"".get_string('parentfolder')."\" />";
		print "</a></td>\n</tr>\n";
	}

	/**
	 * Imprimir cabe�alho da listagem dos arquivos
	 */
	$count = 0;
	$strmodified = get_string("modified");
	$strname = get_string("name");
	$straction = get_string("action");
	$strsize = get_string("size");

	echo "<tr>";
	print_cell();
	print_cell("left",  $strname);
	print_cell("right", $strsize);
	print_cell("right", $strmodified);
	print_cell("right", $straction);
	echo "</tr>";

	/**
	 * Verifica se o array de diretorios n�o est� vazia,
	 */
	if (!empty($dirlist)) {
		asort($dirlist);
		foreach ($dirlist as $dir) {

			$count++;

			$filename = $fullpath."/".$dir;
			$fileurl  = $wdir."/".$dir;
			$filedate = userdate(filemtime($filename), "%d %b %Y, %I:%M %p");
			$filesize = display_size(get_directory_size("$fullpath/$dir"));

			echo "<tr>";

			if ($usecheckboxes) {
				if ($fileurl === '/moddata') {
					print_cell();
				} else {
					print_cell("center", "<input type=\"checkbox\" name=\"file$count\" value=\"$fileurl\" onclick=\"return set_rename('$dir');\" />");
				}
			}
			print_cell("left", "<a href=\"coursefiles.php?id=$id&conteudo_id=$conteudo_id&images=$images&amp;wdir=$fileurl\" onclick=\"return reset_value();\"><img src=\"$CFG->pixpath/f/folder.gif\" class=\"icon\" alt=\"".get_string('folder')."\" /></a> <a href=\"coursefiles.php?id=$id&images=$images&amp;wdir=$fileurl&amp;usecheckboxes=$usecheckboxes\" onclick=\"return reset_value();\">".htmlspecialchars($dir)."</a>");
			print_cell("right", $filesize);
			print_cell("right", $filedate);
			print_cell("right", "<a href=\"coursefiles.php?id=$id&conteudo_id=$conteudo_id&images=$images&amp;wdir=$wdir&amp;file=$dir&amp;action=rename&amp;sesskey=$USER->sesskey\">[ Editar ]</a>");

			echo "</tr>";
		}
	}

	/**
	 * Verifica se o array de arquivos está vazia
	 */
	if (!empty($filelist) && $keywords == "" && $type == "all") {
		asort($filelist);
		
		foreach ($filelist as $file) {

			$count++;
			$icon       = mimeinfo("icon", $file);
			$imgtype    = mimeinfo("type", $file);
			$filename   = $fullpath.'/'.$file;
			$fileurl    = "$wdir/$file";
			$filedate   = userdate(filemtime($filename), "%d %b %Y, %I:%M %p");
			$file_size  = display_size(filesize($filename));
			$dimensions = get_image_size($filename);

			if($dimensions) {
				$imgwidth  = $dimensions[0];
				$imgheight = $dimensions[1];
			} else {
				$imgwidth = "";
				$imgheight = "";
			}
			unset($dimensions);
			echo "<tr>\n";

			if ($usecheckboxes) {
				print_cell("center", "<input type=\"checkbox\" name=\"file$count\" value=\"$fileurl\" onclick=\";return set_rename('$file');\" />");
			}
			echo "<td align=\"left\" nowrap=\"nowrap\">";
			$ffurl = get_file_url($id.$fileurl);
			link_to_popup_window ($ffurl, "display", "<img src=\"$CFG->pixpath/f/$icon\" class=\"icon\" alt=\"$strfile\" />",480, 640);

			echo "<a onclick=\"return set_value(info = {url: '".$ffurl."',";
			echo " isize: '".$file_size."', itype: '".$imgtype."', iwidth: '".$imgwidth."',";
			echo " iheight: '".$imgheight."', imodified: '".$filedate."' })\" href=\"#\">$file</a>";
			echo "</td>\n";

			if ($icon == "zip.gif") {
				$edittext =  "<a href=\"coursefiles.php?id=$id&conteudo_id=$conteudo_id&images=$images&amp;wdir=$wdir&amp;file=$fileurl&amp;action=unzip&amp;sesskey=$USER->sesskey\">[ $strunzip ]</a>&nbsp;";
				$edittext .= "<a href=\"coursefiles.php?id=$id&conteudo_id=$conteudo_id&images=$images&amp;wdir=$wdir&amp;file=$fileurl&amp;action=listzip&amp;sesskey=$USER->sesskey\">[ $strlist ]</a> ";
			} else {
				$edittext = $file_size;
			}
			print_cell("right", "$edittext");
			print_cell("right", $filedate);
			print_cell("right", "<a href=\"download.php?file=$filename\">[ Baixar ]</a>
								 <a href=\"coursefiles.php?id=$id&conteudo_id=$conteudo_id&images=$images&amp;wdir=$wdir&amp;file=$file&amp;action=rename&amp;sesskey=$USER->sesskey\">[ Editar ]</a>");

			echo "</tr>\n";
		}
	}else{
		
		asort($filelist);
		foreach ($filelist as $file) {

			$count++;
			$icon       = mimeinfo("icon", $file);
			$imgtype    = mimeinfo("type", $file);
			$filename   = $file;
			$fileurl    = "$file";
			$name		= explode("/",$filename);
			//$name		= $name[count($name)-1];
			$filedate   = userdate(filemtime($filename), "%d %b %Y, %I:%M %p");
			$file_size  = display_size(filesize($filename));
			$dimensions = get_image_size($filename);


			if($dimensions) {
				$imgwidth  = $dimensions[0];
				$imgheight = $dimensions[1];
			} else {
				$imgwidth = "";
				$imgheight = "";
			}
			unset($dimensions);
			echo "<tr>\n";

			if ($usecheckboxes) {
				print_cell("center", "<input type=\"checkbox\" name=\"file$count\" value=\"$fileurl\" onclick=\";return set_rename('$file');\" />");
			}

			echo "<td align=\"left\" nowrap=\"nowrap\">";
			
			$ffurl = $CFG->www."/file.php/".str_replace($CFG->dataroot.'/','',$fileurl);

			link_to_popup_window ($ffurl, "display", "<img src=\"$CFG->pixpath/f/$icon\" class=\"icon\" alt=\"$strfile\" />",480, 640);

			echo "<a onclick=\"return set_value(info = {url: '".$ffurl."',";
			echo " isize: '".$file_size."', itype: '".$imgtype."', iwidth: '".$imgwidth."',";
			echo " iheight: '".$imgheight."', imodified: '".$filedate."' })\" href=\"#\">".$name[count($name)-1]."</a>";
			echo "</td>\n";

			if ($icon == "zip.gif") {
				//$edittext =  "<a href=\"coursefiles.php?id=$id&images=$images&amp;wdir=$wdir&amp;file=$fileurl&amp;action=unzip&amp;sesskey=$USER->sesskey\">[ $strunzip ]</a>&nbsp;";
				//$edittext .= "<a href=\"coursefiles.php?id=$id&images=$images&amp;wdir=$wdir&amp;file=$fileurl&amp;action=listzip&amp;sesskey=$USER->sesskey\">[ $strlist ]</a> ";
			} else {
				$edittext = $file_size;
			}
			print_cell("right", "$edittext");
			print_cell("right", $filedate);
			print_cell("right", "<a href=\"download.php?file=$filename\">[ Baixar ]</a>");
			//<a href=\"coursefiles.php?id=$id&images=$images&amp;wdir=$wdir&amp;file=$file&amp;action=rename&amp;sesskey=$USER->sesskey\">[ Editar ]</a>");

			echo "</tr>\n";
		}

	}

	if(empty($filelist) && empty($dirlist)){
		echo "<tr>";
		print_cell();
		print_cell("left",  '-');
		print_cell("right", '-');
		print_cell("right", '-');
		print_cell("right", '-');
		echo "</tr>";

	}

	echo "</table>\n";

	if (empty($wdir)) {
		$wdir = "/";
	}

	echo "<table border=\"0\" cellspacing=\"2\" cellpadding=\"2\">\n";
	echo "<tr>\n<td>";
	echo "<input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
	echo "<input type=\"hidden\" name=\"conteudo_id\" value=\"$conteudo_id\" />\n";
	echo "<input type=\"hidden\" name=\"images\" value=\"$images\" />\n";
	echo "<input type=\"hidden\" name=\"wdir\" value=\"$wdir\" />\n";
	echo "<input type=\"hidden\" name=\"sesskey\" value=\"$USER->sesskey\" />\n";
	$options = array (
                   "move" => "$strmovetoanotherfolder",
                   "delete" => "$strdeletecompletely",
                   "zip" => "$strcreateziparchive",
				   "checkall" => "$strcheckall",
				   "uncheckall"	=> "$struncheckall"
	);
	if (!empty($count)) {
		choose_from_menu ($options, "action", "", "$strwithchosenfiles...", "javascript:getElementById('dirform').submit()");
	}
	if (!empty($USER->fileop) and ($USER->fileop == "move") and ($USER->filesource <> $wdir)) {



		echo "<form action=\"coursefiles.php\" method=\"get\">\n";
		echo " <input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
		echo "<input type=\"hidden\" name=\"conteudo_id\" value=\"$conteudo_id\" />\n";
		echo "<input type=\"hidden\" name=\"images\" value=\"$images\" />\n";
		echo " <input type=\"hidden\" name=\"wdir\" value=\"$wdir\" />\n";
		echo " <input type=\"hidden\" name=\"action\" value=\"paste\" />\n";
		echo " <input type=\"hidden\" name=\"sesskey\" value=\"$USER->sesskey\" />\n";
		echo " <input type=\"submit\" value=\"$strmovefilestohere\" />\n";
		echo "</form>";
	}
	echo "</td></tr>\n";
	echo "</table>\n";
	echo "</form>\n";
}

?>

</body>
</html>
