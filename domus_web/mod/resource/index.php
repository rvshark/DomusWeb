<?php // $Id: index.php,v 1.27.2.5 2008/02/05 21:39:53 skodak Exp $
require_once("../../config.php");

if(isset($_POST['ajax']))
{
	
	$arr = array();
	
	if(isset($_POST["resource_type_id"]) && isset($_POST["resource_id"])){
		$sql = "UPDATE {$CFG->prefix}resource SET resourcetypeid = ". $_POST["resource_type_id"] ." WHERE id = " . $_POST["resource_id"];		
        $arr['msg'] = execute_sql($sql,false) ? "sucesso" : "erro";
	}
	else {
		$arr['msg'] = "erro";
	}
	
	echo json_encode($arr);
}
else
{

    $id = required_param( 'id', PARAM_INT ); // course
    $edit = optional_param('edit', 0, PARAM_INT );

    if (! $course = get_record("course", "id", $id)) {
        error("Course ID is incorrect");
    }

    require_course_login($course, true);

    if ($course->id != SITEID) {
        require_login($course->id);
    }
    add_to_log($course->id, "resource", "view all", "index.php?id=$course->id", "");

    $strresource = get_string("modulename", "resource");
    $strresources = get_string("modulenameplural", "resource");
    $strweek = get_string("week");
    $strtopic = get_string("topic");
    $strname = get_string("name");
    $strsummary = get_string("summary");
    $strlastmodified = get_string("lastmodified");

    $navlinks = array();
    $navlinks[] = array('name' => $strresources, 'link' => '', 'type' => 'activityinstance');
    $navigation = build_navigation($navlinks);

    print_header("$course->shortname: $strresources", $course->fullname, $navigation,
                 "", "", true, "", navmenu($course));

    if (! $resources = get_all_instances_in_course("resource", $course)) {
        notice(get_string('thereareno', 'moodle', $strresources), "../../course/view.php?id=$course->id");
        exit;
    }

	if($edit > 0){
		$table->head  = array ($strlastmodified, $strname, 'Tipo Recurso', 'Opções');
        $table->align = array ("left", "left", "left","left");
	}
	else if ($course->format == "weeks") {
        $table->head  = array ($strweek, $strname, $strsummary);
        $table->align = array ("center", "left", "left");
    } else if ($course->format == "topics") {
        $table->head  = array ($strtopic, $strname, $strsummary);
        $table->align = array ("center", "left", "left");
    } else {
        $table->head  = array ($strlastmodified, $strname, $strsummary);
        $table->align = array ("left", "left", "left");
    }

    $select = $currentsection = "";
    $options->para = false;
    
    
    if($edit > 0)
	{
		$rows = get_records_sql("SELECT id, name FROM {$CFG->prefix}resource_type ORDER BY name");
		
		$select = "<select id='sel_%d' style='display:none'><option value='0'>Selecione</option>";
		
		foreach ($rows as $key => $value) {
			$select = $select . sprintf("<option value='%d'>%s</option>", $value->id, $value->name);
		}
		
		$select = $select . "</select>";
	}
	
	//new dBug($resources);
	
	foreach ($resources as $resource) {
        if (($course->format == "weeks" or $course->format == "topics") && $edit == 0) {
            $printsection = "";
            if ($resource->section !== $currentsection) {
                if ($resource->section) {
                    $printsection = $resource->section;
                }
                if ($currentsection !== "") {
                    $table->data[] = 'hr';
                }
                $currentsection = $resource->section;
            }
        } else {
            $printsection = '<span class="smallinfo">'.userdate($resource->timemodified)."</span>";
        }
        if (!empty($resource->extra)) {
            $extra = urldecode($resource->extra);
        } else {
            $extra = "";
        }
		
		                  
        	
    	if($edit > 0)
		{
			$table->data[] = array ($printsection, 
                 "<a $extra href=\"view.php?id=$resource->coursemodule\">".format_string($resource->name,true)."</a>"
                 , sprintf('<span id="value_%d">',$resource->id) . $resource->resourcetype . '</span>'
                 . sprintf($select,$resource->id)
                 , sprintf("<span id='edit_%d'>
                 				<input type='button' value='editar' onclick='editar(%d);' />
                 			</span>
                 			<span id='save_%d' style='display:none'>
                 	 	    	<input type='button' value='salvar' onclick='salvar(%d);' />
                 		    	<input type='button' value='cancelar' onclick='cancelar(%d);' />
                 		    </span>", 
                 		    $resource->id, $resource->id, $resource->id, $resource->id, $resource->id));
				 
		}else if (!$resource->visible) {      // Show dimmed if the mod is hidden
            $table->data[] = array ($printsection, 
                    "<a class=\"dimmed\" $extra href=\"view.php?id=$resource->coursemodule\">".format_string($resource->name,true)."</a>",
                    format_text($resource->summary, FORMAT_MOODLE, $options) );

        } else { //Show normal if the mod is visible
				$table->data[] = array ($printsection, 
                    "<a $extra href=\"view.php?id=$resource->coursemodule\">".format_string($resource->name,true)."</a>",
                    format_text($resource->summary, FORMAT_MOODLE, $options) );	
			
            
        }
    }

    echo "<style type='text/css'>.generaltable tr td{vertical-align: middle;}</style>";
    echo "<br />";

    print_table($table);   

?>

<script type="text/javascript">

	function editar(resource_id)
	{
		$('#sel_' + resource_id + ',#save_' + resource_id).show();
		$('#edit_' + resource_id + ',#value_' + resource_id).hide();
	
		type = $('#value_' + resource_id).text();
		$("#sel_" + resource_id + " option:[text='" + type + "']").attr('selected', 'selected');
	}
	
	function cancelar(resource_id)
	{
		$('#sel_' + resource_id + ',#save_' + resource_id).hide();
		$('#edit_' + resource_id + ',#value_' + resource_id).show();
	}
	
	function salvar(resource_id)
	{
		if($('#sel_' + resource_id).val() == "0")
		{
			alert('Selecione um Tipo de Recurso!');
			return;
		}
		
		jQuery.ajax({
	       url: "<?php echo $CFG->wwwroot ?>/mod/resource/index.php", 
	       dataType: "json", 
	       type: "POST",
	       data: { ajax : "1", 
	     		 resource_id : resource_id,
	     		 resource_type_id : $('#sel_' + resource_id).val()
	       },
	       success: function(json){ //Se ocorrer tudo certo
	           msg = json.msg == "sucesso" ? "Recurso atualizado com sucesso." : "Erro na tentativa de atualizar o Recurso!";
	           alert(msg);
	        	   
	           $('#value_' + resource_id).text($('#sel_' + resource_id + ' option:selected').text());
			   cancelar(resource_id);
	       },
	       error: function(e){
	     	   alert('Erro na gravação de dados!');
	     	   cancelar(resource_id);
	       } 
	    }); 
	
	}

</script>
<?php 

	print_footer($course);

} 
?>