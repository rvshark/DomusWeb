<?php

class Anotacao extends ActiveRecord\Model{
    
    static $belongs_to = array(
         array('tema', 'foreign_key' => 'forum', 'class_name' => 'Tema')
    );
    
    static $table_name = 'mdl_myforum_notes';
    
}


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
