<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Conceito
 *
 * @author Luiz Loja
 */
class Conceito extends ActiveRecord\Model {

     static $before_destroy = array('validacao');
    
    static $table_name = 'mdl_myforum_concepts';

    static $validates_presence_of = array(
        array('title', 'message' => 'Preencha o nome do conceito!')
    );    
    
    
     
    static $has_many = array(
         array('conceito_topico', 'foreign_key' => 'concepts_id', 'class_name' => 'ConceitoTopico'),
         array('topicos', 'through' => 'conceito_topico', 'class_name' => 'Topico', 'foreign_key' => 'concepts_id')
    );
    
    static $belongs_to = array(
         array('usuario', 'foreign_key' => 'userid', 'class_name' => 'Usuario')

    );
    
    
    public function validacao(){
          
        
    }
    
}

?>
