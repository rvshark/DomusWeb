<?php
class Post extends ActiveRecord\Model{

    static $before_destroy = array('validacao_delecao');
    
    static $belongs_to = array(
         array('topico', 'foreign_key' => 'discussion', 'class_name' => 'Topico'),
         array('usuario', 'foreign_key' => 'userid', 'class_name' => 'Usuario'),
         array('citacao', 'foreign_key' => 'parent', 'class_name' => 'Post')
    );
    
   static $validates_presence_of = array(
        array('message', 'message' => 'Preencha a mensagem!'),
        array('subject', 'message' => 'Preencha o assunto!')
    ); 

    
    
    static $table_name = 'mdl_myforum_posts';
    
    
    public function validacao_delecao(){
          
        if ($this->ja_fui_citado() ){
             return false;
         }
    }
    
    public function caminhoArquivos(){
        global $CFG;
        $courseid = $this->topico->tema->curso->id;
        $forumid = $this->topico->tema->id;        
        return "$courseid/$CFG->moddata/myforum/$forumid/$this->id";
    }
    
    public function recuperarUrlArquivo(){
        global $CFG;
        require_once($CFG->dirroot.'/lib/filelib.php');
        
        if( $this->attachment != null){
            return get_file_url( $this->caminhoArquivos() . "/" . $this->attachment);
        }else{
            return "";
        }
        
    }
    
    public function carregar_arquivo_do_upload(){
        global $CFG;
        require_once($CFG->dirroot.'/lib/uploadlib.php');
        
        $um = new upload_manager("attachment",true,false,$this->topico->tema->curso->id,false,$this->topico->tema->maxbytes,true,true);
        
        if ($um->process_file_uploads($this->caminhoArquivos())) {
            $message .= $um->get_errors();
            $this->attachment = $um->get_new_filename();
        }
        
        $message = $um->get_errors();
        
        
    }
    
    
    public function ja_fui_citado(){
        $post_id = $this->id;
        return Post::exists(array('conditions' => "parent = $post_id"));
    }
    
    
}
?>
