<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnotacaoController
 *
 * @author Luiz Loja
 * Controlador responsável por tratar todas responsabilidades relacionadas a 
 * Anotação
 */
class AnotacaoController {
    
    public $tema ;
    public $anotacao ;
    public $json;
    
    /**
     * Controi a classe com o atributo tema e anotação.
     * Estes atributos serão preenchidos automaticamente dependendo dos parametros
     * do response
     */
    public function __construct() {
        $this->tema = new Tema();
        $this->anotacao = new Anotacao();
    }
    
    /**
     * Este método restorna a anotação do usuário relacionada ao fórum em questão
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
    public function anotacao_tema($response){
        $forum_id = $this->tema->id;
        $user_id = $response->s['USER']->id;
        $this->anotacao = Anotacao::find(array('conditions' => "forum = $forum_id and userid = $user_id "));
    }
    
    
    /**
     * Este método salva as anotações feitas pelo usuário em relação ao fórum
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
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
