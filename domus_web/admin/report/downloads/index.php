<style>
	.generaltable{width:700px!important}
	
	
</style>
<?php  
require_once('../../../config.php');
require_once($CFG->libdir.'/adminlib.php');

require_login();

admin_externalpage_setup('reportsecurity');
admin_externalpage_print_header();
print_heading("Downloads");


if (true) {
    
    $table = new object();
    $table->head  = array("Nome","E-mail","Telefone","Instituição","Cidade","País","Ip","Data Download");
    $table->size  = array('15%', '15%', '15%', '15%', '10%', '10%', '5%', '15%' );
    $table->align = array('left', 'left', 'left', 'left', 'left', 'left', 'left');
    $table->data  = array();
	

    $sql = "SELECT nome, email, telefone, instituicao, cidade, pais, ip, dt_cadastro FROM mdl_cadastro_download ORDER BY dt_cadastro DESC";
	
	$downmembers = get_recordset_sql($sql);
	
	while ($rs = rs_fetch_next_record($downmembers)) {
		
		$data = date($rs -> dt_cadastro);
		$row = array();
        $row[0] = $rs -> nome;
        $row[1] = $rs -> email;
        $row[2] = $rs -> telefone;
		$row[3] = $rs -> instituicao;
		$row[4] = $rs -> cidade;
		$row[5] = $rs -> pais;
		$row[6] = $rs -> ip;
		$row[7] = $data;

        $table->data[] = $row;
	}
	
	echo '<br>';
    print_table($table);

    //print_box($result->details, 'generalbox boxwidthnormal boxaligncenter'); // TODO: add proper css  

} 



print_footer();

?>