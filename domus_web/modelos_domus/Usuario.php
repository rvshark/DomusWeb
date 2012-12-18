<?php
class Usuario extends ActiveRecord\Model{


    
    static $has_many = array(
         array('regras_atribuidas', 'foreign_key' => 'userid', 'class_name' => 'AtribuicaoRegra'),
        
         array('posts', 'foreign_key' => 'userid', 'class_name' => 'Post'),
        
         array('conceitos', 'foreign_key' => 'userid', 'class_name' => 'Conceito'),
         
         array('bibliografias', 'foreign_key' => 'userid', 'class_name' => 'Bibliografia')
         
    );
    
    
    public function souProfessorEditor(){
        foreach($this->regras_atribuidas as  $regra_atribuida ){
            if($regra_atribuida->roleid == 3 || $regra_atribuida->roleid == 1 ){
                return true;
            }
        }
        return false;
    }
        
    
    static $table_name = 'mdl_user';
    
    
    
}
?>