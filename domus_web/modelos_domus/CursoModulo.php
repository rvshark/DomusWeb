<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CursoModule
 *
 * @author Luiz Loja
 */
class CursoModulo extends ActiveRecord\Model {
    
    static $table_name = 'mdl_course_modules';
    
    static $belongs_to = array(
         array('curso', 'foreign_key' => 'course', 'class_name' => 'Curso'),
         array('recurso', 'foreign_key' => 'instance', 'class_name' => 'Recurso')
    );
    
    
    public function meus_filhos(){
        $modulos = $this->curso->modulo_curso_sequencia();
        $i = 0;
        $j = 0 ;
        while($modulos[$i++]->id != $this->id);
        while($modulos[$i++]->indent == $this->indent + 1){
            $filhos[$j++] = $modulos[$i - 1];
        }
        return $filhos;
    }
}

?>
