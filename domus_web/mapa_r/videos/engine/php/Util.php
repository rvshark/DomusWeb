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
            
            	$arq_nome = explode(".", $arq);
            
                echo "<a rel='#voverlay' href='engine/swf/player.swf?url=../../../../videos/climatizacao/".$arq."&volume=100' title='climatizacao'><img src='data/thumbnails/$arq_nome[0].png' alt='".$arq_nome[0]."' /><span></span></a>";
            }
            		
        }
    }
    chdir(".."); // Volta um diretorio
    closedir($diraberto); // Fecha o diretorio atual
}
?>