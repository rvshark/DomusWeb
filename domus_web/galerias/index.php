<?php

require_once ('../config.php');

//require_once ('../util/dBug.php');

//$id = required_param('id', PARAM_INT);

if ($CFG -> forcelogin) {
	require_login();
}

if (!$site = get_site()) {
	error('Site isn\'t defined!');
}

$systemcontext = get_context_instance(CONTEXT_SYSTEM);

if (update_category_button()) {
	if ($categoryedit !== -1) {
		$USER -> categoryediting = $categoryedit;
	}
	$adminediting = !empty($USER -> categoryediting);
} else {
	$adminediting = false;
}

function html_header() {
	global $CFG;
	global $SITE;

	require_once ($CFG -> libdir . '/adminlib.php');
	admin_externalpage_setup('galerias', update_category_button());
	admin_externalpage_print_header();
}

function displayTree() {

	require_once ('TreeMenu.php');

	$menu = new HTML_TreeMenu();
	$menu -> createTreeMenu();

	echo "<h2 class='main'>Galeria Cursos</h2><br/>";
	echo "<table border='0' cellspacing='2' cellpadding='2' width='100%' style='margin-left:25px;maring-top:15px;'>";
	echo "<tr><td>";
	//$treeMenu->printMenu();
	//$listBox->printMenu();
	$menu -> treeMenu -> printMenu();
	//$menu -> listBox -> printMenu();
	echo "</td></tr>";
	echo "</table>";

}

html_header();
displayTree();
admin_externalpage_print_footer();

include ('ArquivosModal.php');
?>

