<?php
class Topico extends ActiveRecord\Model{

    static $belongs_to = array(
         array('tema', 'foreign_key' => 'forum', 'class_name' => 'Tema'),
         array('primeiro_post', 'foreign_key' => 'first_post_id', 'class_name' => 'Post')
    );
    
   
    static $has_many = array(
         array('posts', 'foreign_key' => 'discussion', 'class_name' => 'Post', 'order' => 'created_at asc'),
        
         array('topico_recurso', 'foreign_key' => 'discussion_id', 'class_name' => 'TopicoRecurso'),
        
         array('conceito_topico', 'foreign_key' => 'discussion_id', 'class_name' => 'ConceitoTopico'),
         array('conceitos', 'through' => 'conceito_topico', 'class_name' => 'Conceito', 'foreign_key' => 'discussion_id'),
        
         array('bibliografia_topico', 'foreign_key' => 'discussion_id', 'class_name' => 'BibliografiaTopico'),
         array('bibliografias', 'through' => 'bibliografia_topico', 'class_name' => 'Bibliografia', 'foreign_key' => 'discussion_id')

    );
        
    
    static $table_name = 'mdl_myforum_discussions';
    
    
    
    public function recursos(){
        $recursos_hypertexto = array();

        foreach($this->topico_recurso as $key => $value){
                 $recursos_hypertexto[$value->recurso->name] = $value->recurso;   
        }
        return $recursos_hypertexto;
    }
    
    public function recursos_links(){
        $recursos = array();
        
        foreach($this->topico_recurso as $key => $value){
             if($value->recurso->tipo->id == 2){
                 $recursos[preg_replace('/^\[-LINK\]/','',$value->recurso->name)] = $value->recurso;   
             }
        }
        return $recursos;
    }
    
    
    
    
    
    
}

?>
