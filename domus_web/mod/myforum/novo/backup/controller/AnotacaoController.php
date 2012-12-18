<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnotacaoController
 *
 * @author Luiz Loja
 */
class AnotacaoController {
    
    public $tema ;
    public $anotacao ;
    public $json;
    
    public function __construct() {
        $this->tema = new Tema();
        $this->anotacao = new Anotacao();
    }
    
    public function anotacao_tema($response){
        $forum_id = $this->tema->id;
        $user_id = $response->s['USER']->id;
        $this->anotacao = Anotacao::find(array('conditions' => "forum = $forum_id and userid = $user_id "));
    }
    
    public function alterar($response){

        $forum_id = $this->tema->id;
        $user_id = $response->s['USER']->id;
        
        
        
        if(!Anotacao::exists(array('conditions' => "forum = $forum_id and userid = $user_id " ))){

            $this->anotacao->forum = $forum_id;
            $this->anotacao->userid = $user_id;
            
            $this->anotacao->save();
        }else{
            $anotacao_antiga = Anotacao::find(array('conditions' => "forum = $forum_id and userid = $user_id " ));
            $anotacao_antiga->update_attributes(array('text' => $response->r['anotacao']['text']));
        }
        
        $this->json = '{success:true}';
    }
}

?>
