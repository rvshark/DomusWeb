<?php
class Tema extends ActiveRecord\Model{

    static $has_many = array(
         array('anotacoes', 'foreign_key' => 'forum', 'class_name' => 'Anotacao'),
         array('topicos', 'foreign_key' => 'forum', 'class_name' => 'Topico', 'order' => 'name')
    );
    
    static $has_one = array(
         array('anotacao', 'foreign_key' => 'forum', 'class_name' => 'Anotacao')
    );    
    
    static $belongs_to = array(
         array('curso', 'foreign_key' => 'course', 'class_name' => 'Curso')
    );    
    
    static $table_name = 'mdl_myforum';
    

    static $validates_presence_of = array(
        array('name', 'message' => 'Preencha o nome do assunto!'),
        array('intro', 'message' => 'Preencha a descrição do tema!'),
    );    
 
    
    
}



?>
