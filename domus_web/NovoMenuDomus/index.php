<?php  // $Id: index.php,v 1.201.2.10 2009/04/25 21:18:24 stronk7 Exp $
// index.php - the front page.

///////////////////////////////////////////////////////////////////////////
//                                                                       //
// NOTICE OF COPYRIGHT                                                   //
//                                                                       //
// Moodle - Modular Object-Oriented Dynamic Learning Environment         //
//          http://moodle.org                                            //
//                                                                       //
// Copyright (C) 1999 onwards  Martin Dougiamas  http://moodle.com       //
//                                                                       //
// This program is free software; you can redistribute it and/or modify  //
// it under the terms of the GNU General Public License as published by  //
// the Free Software Foundation; either version 2 of the License, or     //
// (at your option) any later version.                                   //
//                                                                       //
// This program is distributed in the hope that it will be useful,       //
// but WITHOUT ANY WARRANTY; without even the implied warranty of        //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         //
// GNU General Public License for more details:                          //
//                                                                       //
//          http://www.gnu.org/copyleft/gpl.html                         //
//                                                                       //
///////////////////////////////////////////////////////////////////////////

if (!file_exists('../config.php')) {
	header('Location: install.php');
	die;
}


require_once('../config.php');
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/lib/blocklib.php');


// Inicio config Configurdor Menu


include_once "classes/MenuTree.php";
include_once "classes/ConfiguradorMenu.php";
include_once "classes/crud_menu.php";
//include_once '../config.php';
$conf = new ConfiguradorMenu();
if(isset($_POST['id'])){

	new CrudMenu($_POST);

}


$conf = new ConfiguradorMenu();

// FIM config configurador menu


//if (empty($SITE)) {	redirect($CFG->wwwroot .'/'. $CFG->admin .'/index.php');}

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

if (!isloggedin()) {
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
							
						// Chamada do novo menu -- Jhonatan
						//	d($novoMenuDomus->show());
							
						//include_once 'classes/MenuTree.php';
						$novoMenuDomus = new TreeMenu2();
						echo $novoMenuDomus->show();
							
						blocks_print_group($PAGE, $pageblocks, BLOCK_POS_LEFT);
						print_container_end();
						echo '</td>';
					}


					break;
				case 'middle':


					echo '<td id="middle-column">'. skip_main_destination();

					print_container_start();
					// inicio da impressão do configurador do menu
					?>

		<fieldset style='width:93%; margin: 10px;'>
			<legend>Configuração do Menu Principal</legend>
			<table border=1 style="width: 100%;">
				<tr>
					<th style="width: 150px">Menu</th>
					<th style="vertical-align: middle; width: 200px">Antecessor</th>
				</tr>
				<?php 
				foreach ($conf->getListaMenus() as $menu  ){
					$menuConfigurado = $conf->searchItemConfigurado($menu->id);

					if(!$menuConfigurado) $pai = "9999";
					else  $pai = $menuConfigurado->pai;

					?>

				<tr>

					<td style="width: 150px"><?php echo $menu->nome; ?></td>
					<td style="vertical-align: middle; width: 200px">
						<form method='POST' action=''>
							<input type='hidden' name='id' value='<?php echo $menu->id; ?>' />
							<select name='pai'>
								<option value=''>Não Configurado</option>
								<?php 
								$conf->empilhador(new Menu2(0,"Titulo de Menu",0,""));
									
								foreach($conf->getListaMenus() as $opcao){
									$selected = "";
									if($pai == $opcao->id )
										$selected = "selected";

									echo "<option value='{$opcao->id}' {$selected} > ".$opcao->nome."</option>";



								}
								?>
								<input type='text' name='link' size=60
								value='<?php echo $CFG->wwwroot."/mod/resource/view.php?id=".$menu->id; ?>' />
							</select> <input name='excluir' type='checkbox' value='1' /> Excluir <input
								type='submit' value='Atualizar' />
						</form>

					</td>

				</tr>





				<?php } //$this->con->fecharConexao(); // encerra conexÃ£o Gambiarra pra nao	dar de erro de conexÃ£o ?>
			</table>
			<div style='clear: both'></div>

		</fieldset>
		<div style='clear: both'></div>







		<?php 	
		// fim da impressão do configurador do menu
		print_container_end();
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






























<?php 
/* Exemplo de uso isolado da classe que gera menus
 $arv->addItem(new Menu(1,"conteudo",0,"link"));
$arv->addItem(new Menu(2,"curso",0,1,"link"));
$arv->addItem(new Menu(3,"domus",1,"link"));
$arv->addItem(new Menu(4,"filho do domus",3,"link"));
$arv->addItem(new Menu(5,"irmao do domus",1,"link"));
$arv->addItem(new Menu(6,"filho do curso",2,"link"));
$arv->addItem(new Menu(7,"filho 2 do domus",3,"link"));
$arv->addItem(new Menu(8,"neto do curso",6,"link"));
$arv->addItem(new Menu(9,"Curso da lorena",8,"http://domus.pucpr.br/homo/course/view.php?id=35"));
$arv->addItem(new Menu(10,"PPGEM",2,"http://domus.pucpr.br/homo/course/view.php?id=35"));
$arv->addItem(new Menu(11,"Atividade",10,"http://domus.pucpr.br/mod/resource/view.php?id=840"));
$arv->addItem(new Menu(12,"Wiki",10,"http://domus.pucpr.br/homo/course/view.php?id=35"));
$arv->addItem(new Menu(13,"Forum",10,"http://domus.pucpr.br/homo/course/view.php?id=35"));

*/




?>






