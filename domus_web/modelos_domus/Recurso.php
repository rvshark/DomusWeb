<?php

class Recurso extends ActiveRecord\Model{
    
    static $belongs_to = array(
         array('curso', 'foreign_key' => 'course', 'class_name' => 'Curso'),
         array('tipo', 'foreign_key' => 'resourcetypeid', 'class_name' => 'TipoRecurso')
         
    );
    

    static $has_many = array(
         array('topicoRecurso', 'foreign_key' => 'resource_id', 'class_name' => 'TopicoRecurso')
         
    );
    
    
    static $has_one = array(
         array('modulo', 'foreign_key' => 'instance', 'class_name' => 'CursoModulo')
         
    );
    
    
    
    static $table_name = 'mdl_resource';
    
    public function carregar_arquivos_imagem($lista_urls = array() ){
        return $this->carregar_arquivos('img',$lista_urls);
    }
    
    public function carregar_arquivos_video($lista_urls = array()){
        return $this->carregar_arquivos('video',$lista_urls);
    }    
    
    public function carregar_arquivos_documento($lista_urls = array()){
        return $this->carregar_arquivos('arquivos',$lista_urls);
    }    
    
    
    public function carregar_arquivos($type,$lista_urls= array()){
        global $CFG;
        $fullpath = $CFG->dataroot;
        $filelist = array();
        $allow_extensions = array();
        $all_data=array();
        
        
        if($type == 'img'){
			$allow_extensions = array("png", "jpeg", "jpg", "gif", "pmg", "bmp");
		}else if($type == 'docs'){
			$allow_extensions = array("doc", "docx", "xls", "xlsx", "txt", "html", "ppt", "pptx","pps","ppsx");
		}else if($type == 'doc'){
			$allow_extensions = array("doc", "docx");
		}else if($type == 'ppt'){
			$allow_extensions = array("ppt", "pptx","pps","ppsx");
		}else if($type == 'pdf'){
			$allow_extensions = array("pdf");
		}else if($type == 'video'){
			$allow_extensions = array("flv","wmv","mp4");
		}else if($type == 'arquivos'){
			$allow_extensions = array("doc", "docx", "xls", "xlsx", "txt", "html", "ppt", "pptx","pps","ppsx","pdf");
		}
        return array_merge($filelist, $this->get_files($fullpath . "/" . $this->curso->id . "/Conteudos/" . $this->modulo->id ,$allow_extensions, $all_data ,$lista_urls));
    }
    
     /**
     * @param $root_dir - Diretorio raiz do data onde encontra os diretorios
     * @param $keyword - Filtro palavra chave para busca dentro dos diretorios
     * @param $idSearch - Filtro id do curso onde sera apenas percorrido a busca. Obs.: id=0 varre todos os diretorios
     * @param $type - Filtro por tipo de arquivo
     * @param $all_data - Todos os arquivos encontrados
     * @return retorna todos os arquivos encontrado na busca
     */
    function get_files($dir,$allow_extensions,$all_data=array(), $lista_urls= array())
    {
            global $keywords,$type;

            //Listar os arquivos do diretorio
            $dir_content = scandir($dir);


            //Verifica todos os arquivos
            foreach($dir_content as $key => $content)
            {
                    if ($content == "." || $content == "..") {
                            continue;
                    }

                    $path = $dir.'/'.$content;
                    $content_chunks = explode(".",$content);
                    $ext = strtolower($content_chunks[count($content_chunks) - 1]);

                    if($keywords != "" && !fnmatch2($keywords,$content) && is_file($path)){
                            continue;
                    }		

                    // salva o arquivo com o path no array
                    if( (in_array($ext, $allow_extensions) ||  $type == "all") && is_file($path)){
                            $nome = preg_replace('/.*?\//','',$path);
                            //$caminho = preg_replace('/\\/','/',$path);
                            $url = ("/files/download.php?file=" . str_replace('\\','/',$path));
                            $checked = "false";
                            if($lista_urls[$url] == true){
                                $checked = "true";
                            }
                            
                            $all_data[] = array("nome" => $nome, "caminho" => $path, "url" => $url, "ext" => $ext,"checked" =>$checked );
                    }

                    // Verifica se o content � um diretorio, caso seja ira chamar a fun��o
                    // recursivamente at� abrir todos os diretorios
                    if(is_dir($path) && is_readable($path)){
                            $all_data = $this->get_files($path,$allow_extensions,$all_data);
                    }

            }

            return $all_data;
    }
    
}


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
