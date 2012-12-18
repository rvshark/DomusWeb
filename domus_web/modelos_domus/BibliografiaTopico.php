<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BibliografiaTopico
 *
 * @author Luiz Loja
 */
class BibliografiaTopico extends ActiveRecord\Model {
    static $after_destroy = array('remover_bibliografia');
    
    static $table_name = 'mdl_myforum_bibliografia_topico';
    
     static $belongs_to = array(
         array('bibliografia', 'foreign_key' => 'biblio_id', 'class_name' => 'Bibliografia'),
         array('topico', 'foreign_key' => 'discussion_id', 'class_name' => 'Topico')
    );
     
     public function remover_bibliografia(){
         
         $biblio_id = $this->biblio_id;
         
         if (!BibliografiaTopico::exists(array('conditions' => "biblio_id = $biblio_id"))){
             $this->bibliografia->delete();
         }
     }
}

?>
