<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Regra
 *
 * @author Luiz Loja
 */
class Regra extends ActiveRecord\Model {
   static $table_name = 'mdl_role';
   
       static $has_many = array(
                array('regras_atribuidas', 'foreign_key' => 'roleid', 'class_name' => 'AtribuicaoRegra')
       );

}

?>
