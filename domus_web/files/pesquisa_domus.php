<?php
/**
 * Pagina Pesquisa;
 * 
 * Esta pagina serve para listar os resultados da pesquisa que vrm como requisição do menu de pesquisa do menu do topo.
 * O form de origem está no arquivo /include/menu.php; (Prox. da linha 217)
 * A formaração do item li de pesquisa esta no arquivo: include/css/meuNovo.css, na propriedade nav-one
 * Acrescente o arquivo conexão para conversar com a base
 * acrescente um arquivo para e exibir o html e outro o tipo
 * 
 * 
 * 
 * 
 * 
 */
//echo "Jhonatan Aqui";
//require_once("../config.php");








if (!file_exists('../config.php')) {
	header('Location: install.php');
	die;
}

 
require_once('../config.php');
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/lib/blocklib.php');

if (empty($SITE)) {
	redirect($CFG->wwwroot .'/'. $CFG->admin .'/index.php');
}

// Bounds for block widths
// more flexible for theme designers taken from theme config.php
$lmin = (empty($THEME->block_l_min_width)) ? 100 : $THEME->block_l_min_width;
$lmax = (empty($THEME->block_l_max_width)) ? 210 : $THEME->block_l_max_width;
$rmin = (empty($THEME->block_r_min_width)) ? 100 : $THEME->block_r_min_width;
$rmax = (empty($THEME->block_r_max_width)) ? 210 : $THEME->block_r_max_width;

define('BLOCK_L_MIN_WIDTH', $lmin);
define('BLOCK_L_MAX_WIDTH', $lmax);
define('BLOCK_R_MIN_WIDTH', $rmin);
define('BLOCK_R_MAX_WIDTH', $rmax);


// check if major upgrade needed - also present in login/index.php
if ((int)$CFG->version < 2006101100) { //1.7 or older
	@require_logout();
	redirect("$CFG->wwwroot/$CFG->admin/");
}
// Trigger 1.9 accesslib upgrade?
if ((int)$CFG->version < 2007092000
&& isset($USER->id)
&& is_siteadmin($USER->id)) { // this test is expensive, but is only triggered during the upgrade
	redirect("$CFG->wwwroot/$CFG->admin/");
}

if ($CFG->forcelogin) {
	require_login();
} else {
	user_accesstime_log();
}

if ($CFG->rolesactive) { // if already using roles system
	if (has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM))) {
		if (moodle_needs_upgrading()) {
			redirect($CFG->wwwroot .'/'. $CFG->admin .'/index.php');
		}
	} else if (!empty($CFG->mymoodleredirect)) {    // Redirect logged-in users to My Moodle overview if required
		if (isloggedin() && $USER->username != 'guest') {
			redirect($CFG->wwwroot .'/my/index.php');
		}
	}
} else { // if upgrading from 1.6 or below
	if (isadmin() && moodle_needs_upgrading()) {
		redirect($CFG->wwwroot .'/'. $CFG->admin .'/index.php');
	}
}


if (get_moodle_cookie() == '') {
	set_moodle_cookie('nobody');   // To help search for cookies on login page
}

if (!empty($USER->id)) {
	add_to_log(SITEID, 'course', 'view', 'view.php?id='.SITEID, SITEID);
}

if (empty($CFG->langmenu)) {
	$langmenu = '';
} else {
	$currlang = current_language();
	$langs = get_list_of_languages();
	$langlabel = get_accesshide(get_string('language'));
	$langmenu = popup_form($CFG->wwwroot .'/index.php?lang=', $langs, 'chooselang', $currlang, '', '', '', true, 'self', $langlabel);
}

$PAGE       = page_create_object(PAGE_COURSE_VIEW, SITEID);
$pageblocks = blocks_setup($PAGE);
 
 
$editing    = $PAGE->user_is_editing();
 
 
$preferred_width_left  = bounded_number(BLOCK_L_MIN_WIDTH, blocks_preferred_width($pageblocks[BLOCK_POS_LEFT]),
BLOCK_L_MAX_WIDTH);
$preferred_width_right = bounded_number(BLOCK_R_MIN_WIDTH, blocks_preferred_width($pageblocks[BLOCK_POS_RIGHT]),
BLOCK_R_MAX_WIDTH);
print_header($SITE->fullname, $SITE->fullname, 'home', '',
				   '<meta name="description" content="'. strip_tags(format_text($SITE->summary, FORMAT_HTML)) .'" />',
true, '', user_login_string($SITE).$langmenu);

//menu_sequence();
?>

<?php 
if ($PAGE->user_allowed_editing()) {
	echo '<div style="text-align:center;width: 150px;height: 30px;">'.update_course_icon($SITE->id).'</div>';
}
else
	{
		//echo '<div style="width: 985px;height: 30px"></div>';
	}
?>
<table id="layout-table" summary="layout">
	<tr>
	<?php
	$lt = (empty($THEME->layouttable)) ? array('left', 'middle', 'right') : $THEME->layouttable; //TODO LINHA COMENTADA PARA RETIRAR A COLUNA DA DIREITA
	foreach ($lt as $column) {
		switch ($column) {
			case 'left':
				if (blocks_have_content($pageblocks, BLOCK_POS_LEFT) || $editing || $PAGE->user_allowed_editing()) {

					echo '<td style="width: '.$preferred_width_left.'px;" id="left-column">';
					print_container_start();					
					
					blocks_print_group($PAGE, $pageblocks, BLOCK_POS_LEFT);
					print_container_end();
					echo '</td>';
				}


				break;
			case 'middle':
				
				global $DB;
			
				echo '<td id="middle-column">'. skip_main_destination();
					
				// conteudo central bem aqui -- jhonatan
				require ("../util/conexao.php");
	
					// Valida se a pesquisa veio vazia
				echo "<div style='padding:10px'>";
					if(isset($_POST['pesquisa']) && !empty($_POST['pesquisa']))	
					{
						echo Linklog("Pesquisa por {$_POST['pesquisa']}");
						$criterio = $_POST['pesquisa'];
						$my = new myCon($CFG->dbhost , $CFG->dbuser, $CFG->dbpass);
						$query = $my->processa("select id, name, type from `mdl_resource` where alltext like '%{$criterio}%'");
						$linhas = mysql_num_rows($query);
						
							myUtils::setSuccessMensagem("Como resultado da pesquisa por:<b> {$criterio}</b><br/> Foram encontrado(s): <b>{$linhas}</b> fonte(s) de conteúdo.");
							while ($TEMPobj  = mysql_fetch_object($query)){
								echo "<div style='
									border: 1px solid #cccccc;
									margin:5px;>
								'>"; 
									echo "<a href='".$CFG->wwwroot."/files/pesquisa_domus.php?id=".$TEMPobj->id."'>".$TEMPobj->name."</a>" ;
								echo "</div>";
								
							}
						
					// exibe o link selecionado	
					}elseif (isset($_GET['id']) && !empty($_GET['id'])){
						echo Linklog("");
						$criterio = $_GET['id'];
						$my = new myCon($CFG->dbhost , $CFG->dbuser, $CFG->dbpass);
						$query = $my->processa("select alltext from `mdl_resource` where id = '{$criterio}'");
						echo "<div style='padding:10px'>";
						while ($TEMPobj  = mysql_fetch_object($query)){
							
							echo $TEMPobj->alltext;
							
						}
						
						
					}else{
						
						echo Linklog("Pesquisa");	
						myUtils::setWarningMensagem("Por gentileza, Informe uma palavra ou trecho de texto que deseja pesquisar");
						
						
					}
					echo "</div>";
				echo '</td>';
				break;
			case 'right':
				// The right column
				if (blocks_have_content($pageblocks, BLOCK_POS_RIGHT) || $editing || $PAGE->user_allowed_editing()) {
					echo '<td style="width: '.$preferred_width_right.'px;" id="right-column" bgcolor=#DEDEDE>'; //TODO incluido bgcolor
					print_container_start();
					/*
					 if ($PAGE->user_allowed_editing()) {
					 echo '<div style="text-align:center">'.update_course_icon($SITE->id).'</div>';
					 echo '<br />';
					 }
					 */
					blocks_print_group($PAGE, $pageblocks, BLOCK_POS_RIGHT);
					print_container_end();		
					
					
					echo '</td>';
				}
				break;
		}
	}
	?>

	</tr>
</table>

	<?php
	print_footer('home');     // Please do not modify this line
	?>
