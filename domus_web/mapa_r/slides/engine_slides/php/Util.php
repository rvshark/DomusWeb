<?php
function oi(){
	echo "renan";
}
function Varre($dir,$filtro="",$nivel="")
{

    $diraberto = opendir($dir); // Abre o diretorio especificado
    
    chdir($dir); // Muda o diretorio atual p/ o especificado
    while($arq = readdir($diraberto)) { // Le o conteudo do arquivo
        if($arq == ".." || $arq == ".")continue; // Desconsidera os diretorios
        $arr_ext = explode(";",$filtro);
        
        foreach($arr_ext as $ext) {
            $extpos = (strtolower(substr($arq,strlen($arq)-strlen($ext)))) == strtolower($ext);
            if ($extpos == strlen($arq) and is_file($arq)){ // Verifica se o arquivo é igual ao filtro
            
            	$arq_nome_list = explode(".", $arq);
            	$arq_nome = $arq_nome_list[0];
            	
            	$n = "";
            	$formated = strtoupper($arq_nome[0]);
            	$n = substr_replace($arq_nome, $formated, 0, 1);
				
				

            
                echo "<a rel='#voverlay' href='engine/swf/player.swf?url=/".$dir.$arq."&volume=100' title='climatizacao'><img src='data/thumbnails/$arq_nome.png' alt='".$arq_nome[0]."' />".$n."<span></span></a>";
            }
            		
        }
    }
    chdir(".."); // Volta um diretorio
    closedir($diraberto); // Fecha o diretorio atual
}

function pegaSlides($dir,$filtro="",$nivel="")
{

    $diraberto = opendir($dir); // Abre o diretorio especificado
    
    chdir($dir); // Muda o diretorio atual p/ o especificado
    while($arq = readdir($diraberto)) { // Le o conteudo do arquivo
        if($arq == ".." || $arq == ".")continue; // Desconsidera os diretorios
        $arr_ext = explode(";",$filtro);
        
        foreach($arr_ext as $ext) {
            $extpos = (strtolower(substr($arq,strlen($arq)-strlen($ext)))) == strtolower($ext);
            if ($extpos == strlen($arq) and is_file($arq)){ // Verifica se o arquivo é igual ao filtro
            
            	$arq_nome_list = explode(".", $arq);
            	$arq_nome = $arq_nome_list[0];
            	
            	$n = "";
            	$formated = strtoupper($arq_nome[0]);
            	$n = substr_replace($arq_nome, $formated, 0, 1);
            
				$tamanho = filesize($arq);
			
				echo "<a rel='#voverlay' href='http://powerdomus.pucpr.br/slides/".$dir.$arq."' title=''><img src='../videos/engine/images/modelo.png' alt='".$arq_nome[0]."' />".$n."<span></span></a>";
			           	
            	
            }
            		
        }
    }
    chdir(".."); // Volta um diretorio
    closedir($diraberto); // Fecha o diretorio atual
}
?>