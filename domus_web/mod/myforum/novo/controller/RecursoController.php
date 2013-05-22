<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecursoController
 *
 * @author Luiz Loja
 */
class RecursoController {
    
        public $recurso;
        public $json;
        
     public function __construct() {
        $this->recurso = new Recurso();
    }
    
    /**
     * Apresenta um recurso
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
    public function mostrar_recurso($resource){
        $this->recurso = Recurso::find($this->recurso->id);
        
    }
}

?>
