<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConceitoTopico
 *
 * @author Luiz Loja
 */
class ConceitoTopico extends ActiveRecord\Model {

    static $after_destroy = array('remover_conceito');
    
    static $table_name = 'mdl_myforum_conceito_topico';
    
     static $belongs_to = array(
         array('conceito', 'foreign_key' => 'concepts_id', 'class_name' => 'Conceito'),
         array('topico', 'foreign_key' => 'discussion_id', 'class_name' => 'Topico')
    );
     
     public function remover_conceito(){
         
         $conceito_id = $this->concepts_id;
         if (!ConceitoTopico::exists(array('conditions' => "concepts_id = $conceito_id"))){
             $this->conceito->delete();
         }
     }
}


?>
