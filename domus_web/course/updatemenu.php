<?php

require_once ('../config.php');

if ($CFG->forcelogin) {
    require_login();
}



if (!$site = get_site()) {
    error('Site isn\'t defined!');
}

$systemcontext = get_context_instance(CONTEXT_SYSTEM);

function html_header(){
    global $CFG;
    global $SITE;

    require_once($CFG->libdir.'/adminlib.php');
    admin_externalpage_setup('galerias', update_category_button());
    admin_externalpage_print_header();
}

function atualiza_menu(){
		
	$cursosMenu = new CursosDomus();
	
	$cursosMenu -> LimparCache();
	
	$menu = $cursosMenu -> ImprimirMenu();
	
	if($menu != "")
		echo "<font color='green'>Menu atualizado com sucesso.</font>";
	else 
		echo "<font color='red'>Problema na atualização do menu! Informe o administrador do sistema.</font>";
	
}
  
html_header();
?>

<table width="100%">
	<tr>
		<td style="width: 100%;text-align: center;height: 50px;"><b><?php atualiza_menu(); ?></b></td>
	</tr>	
</table>
<?php admin_externalpage_print_footer(); ?>