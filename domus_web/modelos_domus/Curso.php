<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Curso
 *
 * @author Luiz Loja
 */
class Curso extends ActiveRecord\Model{
    
    static $table_name = 'mdl_course';
    
    static $has_many = array(
         array('temas', 'foreign_key' => 'course', 'class_name' => 'Tema'),
         array('sessoes', 'foreign_key' => 'course', 'class_name' => 'SessaoRecurso' ),
         array('modulos', 'foreign_key' => 'course', 'class_name' => 'CursoModulo' )
    );
    
    static $has_one = array(
         array('sessao_sequencia', 'foreign_key' => 'course', 'class_name' => 'SessaoRecurso', 'conditions' => array('section = 0 and visible = true') )
    );
    
    //Gato que o moodle tem para apresentar os recursos :D.
    public function ordem_apresentacao(){
        return split(",",$this->sessao_sequencia->sequence);
    }
    
    public function modulo_curso_sequencia(){
       $modulos = array(); 
       $ordem = $this->ordem_apresentacao();
       $i = 0;
       
       foreach ($ordem as $key => $val) {

              try{
                       $modulos[$i] = CursoModulo::find($val);
                       $i = $i + 1;                               
               }catch(Exception $e){

               }


       }
       
       return $modulos;
        
    }
    
    
    //put your code here
}

?>
