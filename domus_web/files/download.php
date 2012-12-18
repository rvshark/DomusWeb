<?php
$file = $_GET['file']; // pega o endere�o do arquivo
                       // ou o nome dele se o arquivo 
                       // estiver na mesma pagina!! 

//$arrayName = split('/',$file);
$arrayName = explode('/',$file);
$name = $arrayName[sizeof($arrayName) - 1];


header("Content-Type: application/save"); 
header("Content-Length:".filesize($file)); 
header('Content-Disposition: attachment; filename="' . $name . '"'); 
header("Content-Transfer-Encoding: binary");
header('Expires: 0'); 
header('Pragma: no-cache'); 

// nesse momento ele le o arquivo e envia
$fp = fopen("$file", "r"); 
fpassthru($fp); 
fclose($fp); 
?>