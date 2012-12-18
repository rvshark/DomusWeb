<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AtribuicaoRegras
 *
 * @author Luiz Loja
 */
class AtribuicaoRegra extends ActiveRecord\Model {
    //put your code here
    
    static $table_name = 'mdl_role_assignments';
    
        static $belongs_to = array(
             array('usuario', 'foreign_key' => 'userid', 'class_name' => 'Usuario'),
             array('regra', 'foreign_key' => 'roleid', 'class_name' => 'Regra')
        );

}

?>
