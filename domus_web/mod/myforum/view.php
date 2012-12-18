<?php  // $Id: view.php,v 1.4 2006/08/28 16:41:20 mark-nielsen Exp $
/**
 * This page prints a particular instance of myforum
 * 
 * @author 
 * @version $Id: view.php,v 1.4 2006/08/28 16:41:20 mark-nielsen Exp $
 * @package myforum
 **/

/// (Replace myforum with the name of your module)

    require_once("../../config.php");
    require_once("lib_forum.php");
    require_once("lib.php");
	 require_once($CFG->libdir.'/blocklib.php');
	require_once($CFG->libdir.'/ajax/ajaxlib.php');
	
    $id = optional_param('id', 0, PARAM_INT); // Course Module ID, or
    $a  = optional_param('a', 0, PARAM_INT);  // myforum ID
    $discussion  = optional_param('discussion', 0, PARAM_INT);  

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
	
	

    require_login($course->id);

    add_to_log($course->id, "myforum", "view", "view.php?id=$cm->id", "$myforum->id");

/// Print the page header

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

/// Print the main part of the page
	include("funcoes.js.php");
	include("style.css.php");

//#########BOTAO ADD NOVA DISCUSSAO

	$modcontext = get_context_instance(CONTEXT_MODULE, $cm->id);
	if (has_capability('mod/forum:startdiscussion', $modcontext)){
        echo '<div class="singlebutton forumaddnew">';
        echo "<form id=\"newdiscussionform\" method=\"get\" action=\"$CFG->wwwroot/mod/myforum/post.php\">";
        echo '<div>';
        echo "<input type=\"hidden\" name=\"id\" value=\"$id\" />";
        echo '<input type="submit" value="Novo T&oacute;pico';
        echo '" />';
        echo '</div>';
        echo '</form>';
        echo "</div>\n";
	}
	
	
	echo "<div id='menu_lateral' style=''>";
			echo "<ul id='menu' class='menu'>";
				echo "<li>Ferramentas";
					echo "<ul>";
						echo "<li>Hipertextos</li>";
						echo "<li>Simula&ccedil;&atilde;o Domus</li>";
						echo "<li>Mapas Conceituais</li>";
						echo "<li>V&iacute;deos</li>";
						echo "<li>Organizador Domus</li>";
						echo "<li>Wiki</li>";
						echo "<li>Links</li>";
						echo "<li><a href='$CFG->wwwroot'>Home</a></li>";
					echo "</ul>";
				echo "</li>";
				echo "<li>Meus Cursos";
					echo "<ul>";
					$c = get_my_courses($USER->id);
					foreach($c as $courses){
						if (coursemodule_visible_for_user($courses, $USER->id)){
							echo "<li onclick='location.href=\"".$CFG->wwwroot."/course/view.php?id=".$courses->id."\"'><a href='javascript:void(0)'>".$courses->shortname."</a></li>";
							//echo "<li >".$course->shortname."</li>";
						}
					}
					echo "</ul>";
				echo "</li>";
			echo "</ul>";
			
		$sql = "select * from mdl_myforum_discussions where course=$course->id and forum=$myforum->id";

		$topicos = get_records_sql($sql);
		$css = "<style type='text/css'>
				body{
					background:#dedede;
				}
				</style>
				";
		//echo $css;
		echo "<br>";
		echo "<ul class='menu'><b>T&oacute;picos</b>";
		foreach ($topicos as $topico) {
			echo "<li style='cursor:pointer;' onclick='frame_resp.location.href=\"respostas.php?id=$id&discussion=$topico->id\"; frame_bibli.location.href=\"bibliografia.php?id=$id&courseid=$course->id&myforumid=$myforum->id&discussion=$topico->id\"; frame_topico.location.href=\"conceitos.php?id=$id&courseid=$course->id&myforumid=$myforum->id&discussion=$topico->id\" '>";
			echo "<a  href='javascript:void(0)' onclick=''>";
				echo $topico->name."<br>";
			echo "</a>";
			echo "</li>";
		}
		echo "</ul>";	
			

	echo "</div>";
	echo "<div style='width:79%;  float:left; margin-left:5px;'>";
	echo "<center><h3 class='tema'>Tema: ".$myforum->name."</h3></center>";
	echo "<div class='problema' style='height:70px; overflow:auto;'><b>Problema</b>: ".$myforum->intro."</div>";
	echo "</div>";
	
	
	
	
	
	
	
	
	
	
	
	
	
	echo "<iframe frameborder=0 name='frame_topico' id='frame_topico'  src='conceitos.php?id=$id&courseid=$course->id&myforumid=$myforum->id'></iframe>";
	echo "<iframe frameborder=0 name='frame_resp' id='frame_resp'  src='respostas.php?courseid=$course->id&myforumid=$myforum->id&discussion=$discussion'></iframe>";
	echo "<iframe frameborder=0 name='frame_bibli' id='frame_bibli'  src='bibliografia.php?id=$id&courseid=$course->id&myforumid=$myforum->id&discussion=$discussion'></iframe>";
	
		echo "<div style='border:0px solid #f00; margin-left:155px;' align=''><ul class='menu_baixo' style=''>
				<li>
					<a href='javascript:void(0)'>Comunica&ccedil;&atilde;o</a>
				</li>
				<li>
					<a href='javascript:void(0)'>Arquivos</a>
				</li>
				<li>
					<a href='javascript:void(0)'>Busca</a>
				</li>
				<li><a href='javascript:void(0)' onclick='javascript:window.open(\"anotacoes.php?id=$id&courseid=$course->id&myforumid=$myforum->id\",name,\"width=500, height=230,scrollbars=1\")'>Anota&ccedil;&otilde;es</a>
				</li>
				<li>
					<a href='javascript:void(0)'>Ajuda</a>
				</li>
			</ul></div>";
	


/// Finish the page
    print_footer($course);

?>
