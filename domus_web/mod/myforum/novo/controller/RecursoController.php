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
    
    
    public function mostrar_recurso($resource){
        $this->recurso = Recurso::find($this->recurso->id);
        
    }
}

?>
