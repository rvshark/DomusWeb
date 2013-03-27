<?php 

require '../../config.php';
//verifica se existe cookie com o ip do ultimo cadastro ou recupera o ip atual
$ip = $_COOKIE["IP_DOMUS"] != "" ?  $_COOKIE["IP_DOMUS"] : $_SERVER['REMOTE_ADDR'];		

	
$sql = "SELECT * FROM {$CFG->prefix}cadastro_download 
		 WHERE ".($_POST["email"] != '' 
				? "email='" .$_POST["email"]."'" 
				: "ip = '".$ip."'" ).
	   " ORDER BY dt_cadastro DESC LIMIT 1";
	   
$row = get_recordset_sql($sql);				

//Grava cookie no cliente para futura consulta
setcookie("IP_DOMUS", $_SERVER['REMOTE_ADDR']);				

echo json_encode(array("email" => ($row -> NumRows() > 0 ? $row->fields["email"] : "")
					 , "nome" => ($row -> NumRows() > 0 ? $row->fields["nome"] : "")
					, "cpf" => ($row -> NumRows() > 0 ? $row->fields["cpf"] : "")
					, "cidades_go" => ($row -> NumRows() > 0 ? $row->fields["id_cidade"] : "")
		        	, "estados_go" => ($row -> NumRows() > 0 ? $row->fields["id_estado"] : "")
				    , "pais" => ($row -> NumRows() > 0 ? $row->fields["pais"] : "")
					 , "telefone" => ($row -> NumRows() > 0 ? $row->fields["telefone"] : "")
					 , "instituicao" => ($row -> NumRows() > 0 ? $row->fields["instituicao"] : "")));

?>