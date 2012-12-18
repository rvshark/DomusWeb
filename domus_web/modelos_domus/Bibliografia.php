<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bibliografia
 *
 * @author Luiz Loja
 */
class Bibliografia extends ActiveRecord\Model {
    static $table_name = 'mdl_myforum_biblio';
    
    static $validates_presence_of = array(
        array('text', 'message' => 'Preencha a bibliografia!')
    ); 
    
    static $has_many = array(
         array('bibliografia_topico', 'foreign_key' => 'biblio_id', 'class_name' => 'BibliografiaTopico'),
         array('topicos', 'through' => 'bibliografia_topico', 'class_name' => 'Topico', 'foreign_key' => 'biblio_id')
    );
    
    
        static $belongs_to = array(
         array('usuario', 'foreign_key' => 'userid', 'class_name' => 'Usuario')

    );

}

?>
