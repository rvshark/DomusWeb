<?php

class SessaoRecurso extends ActiveRecord\Model{
    
    static $belongs_to = array(
         array('curso', 'foreign_key' => 'course', 'class_name' => 'Curso')
    );
    
    static $table_name = 'mdl_course_sections';
    
    
    
}


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
