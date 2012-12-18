<?php

class TopicoRecurso extends ActiveRecord\Model{
    
    static $table_name = 'mdl_discussion_resource';
    
    static $belongs_to = array(
         array('recurso', 'foreign_key' => 'resource_id', 'class_name' => 'Recurso'),
         array('topico', 'foreign_key' => 'discussion_id', 'class_name' => 'Topico')
    );
    
    
    static $has_many = array(
         array('arquivos', 'foreign_key' => 'discussion_resource_id', 'class_name' => 'TopicoRecursoArquivo')
    );
    
 
    public function caminho_hash(){
        $hash = array();
         foreach($this->arquivos as $key => $content){
             $hash[$content->url] = true;
         }
        return $hash;
    }
    
}


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
