<?php

class TipoRecurso extends ActiveRecord\Model{
    
    static $has_many = array(
         array('recurso', 'foreign_key' => 'resourcetypeid', 'class_name' => 'Recurso')
    );
    
    static $table_name = 'mdl_resource_type';
    
    
    
}


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
