<?php 
/** 
 * LINKLOG FUNCTION 
 * @category ToolsAndUtilities
 * @package adLDAP
 * @author Jhonatan Morais (jhonatanvinicius@gmail.com)
 * @version 0.0.1
 * @link unkÃ¢nou
 */
function linklog($page_name = null){

 $arr = array();
	if(isset($_SESSION['logTT'])){						// se a variavel de sessÃ£o esta definida armazena a pg acessada
		array_push($_SESSION['logTT'], $_SERVER['REQUEST_URI'])  ;
		array_push($_SESSION['nameTT'],$page_name);
	}else{												// se a variavel de sessÃ£o nÃ£o esta definida a inicia com o valor de index.php
		$_SESSION['logTT'] = array();
		$_SESSION['nameTT'] = array();
		
	
	}
	if(count($_SESSION['logTT']) > 5){					// se o tamanha do array de historico Ã© > 5 deleta o primeiro indice
		array_shift($_SESSION['logTT']);
		array_shift($_SESSION['nameTT']);
	}
	$i =0;		
	//echo '<pre>'; print_r($_SESSION['log']);print_r($_SESSION['name']);exit();										// serve para controlar a impressÃ£o do 1Âº ' >> '
	foreach ($_SESSION['logTT'] as $x){					// imprime o historico
		
		if(count($_SESSION['logTT']) > 0){				// garante a primeira impressÃ£o apenas apos o acesso da 2Âº pagina
			 						// garante a correta impressÃ£o do separador '>>'
			array_push($arr, "<a href='{$_SESSION['logTT'][$i]}'>{$_SESSION['nameTT'][$i]}</a>")  ;
		}
	$i++;
	}
	
	
	$stringLog = join(" ► ", $arr) . '<br>';
	$stringLog = 'Histórico: ' . $stringLog;
	return $stringLog;
}

?>
