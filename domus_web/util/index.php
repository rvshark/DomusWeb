<?php
require_once ("../config.php");

$path = $CFG -> downdir;

switch ($_GET["acao"]) {
	case 'download' :
		
		if ($_POST['arquivo'] == 'domus.exe' || $_POST['arquivo'] == 'domusteste.exe') {
			
			$nome = $_POST['txtNome'];
			$email = $_POST['txtEmail'];
			$cpf =$_POST['cpf'];
			$telefone = $_POST['txtTelefone'];
			$instituicao = $_POST['txtInstituicao'];
			$id_cidade = $_POST['cidades_go'];
			$id_estado = $_POST['estados_go'];
			$pais = $_POST['txtPais'] == '' ? 'NULL' : $_POST['txtPais'];
			$ip = $_SERVER['REMOTE_ADDR'];
			
			if($nome == '' || $email == '')
			{
				
				echo '<script type="text/jscript">alert("Erro em gravar as informações. Favor tente mais tarde!"); history.back();</script>';
				
				break;
			}
			

			$sql = "INSERT INTO {$CFG->prefix}cadastro_download 
						(nome,email,cpf,telefone,instituicao,id_cidade,id_estado,pais,ip,dt_cadastro)
					VALUES
						('$nome','$email','$cpf','$telefone','$instituicao',1,1','$ip',CURRENT_TIMESTAMP())";
			
			execute_sql($sql,false);
		}

		$fullPath = $path . $_POST['arquivo'];

		if ($fd = fopen($fullPath, "r")) {
			$fsize = filesize($fullPath);
			$path_info = pathinfo($fullPath);

			switch ($path_info['extension']) {
				case "pdf" :
					header("Content-type: application/pdf");
					// add here more headers for diff. extensions
					header("Content-Disposition: attachment; filename=\"" . $path_parts["basename"] . "\"");
					// use 'attachment' to force a download
					break;
				default :
					header("Content-type: application/octet-stream");
					header("Content-Disposition: filename=\"" . $path_info['basename'] . "\"");
			}
			header("Content-length: $fsize");
			header("Cache-control: private");
			
			//use this to open files directly
			while (!feof($fd)) {
				$buffer = fread($fd, 2048);
				echo $buffer;
			}
		}
		fclose($fd);
		exit ;

		break;
	
	case 'pdf':
		$fullPath = $path . $_GET['arquivo'];
		
		header("Content-type: application/pdf");
		header("Content-Disposition: inline; filename='" . $fullPath . "'");
		header('Content-Length: ' . filesize($fullPath));
		@readfile($fullPath);
		//header("Cache-control: private");
	case 'video':
		$fullPath = $path . $_GET['arquivo'];
		
		header("Content-type: application/x-rar-compressed");
		header("Content-disposition: attachment; filename='" . $_GET['arquivo'] . "'");
		header("Content-Length: " . filesize($fullPath));
		@readfile($fullPath);
	break;
	
	default :
		break;
}
?>


