<?php

class TopicoRecursoArquivo extends ActiveRecord\Model{
    
    static $table_name = 'mdl_discussion_resource_file';
    
    static $belongs_to = array(
         array('topico_recurso', 'foreign_key' => 'discussion_resource_id', 'class_name' => 'TopicoRecurso')
    );
    
    
    
}


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
