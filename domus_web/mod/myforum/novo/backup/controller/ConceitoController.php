<?php

class ConceitoController {
    
    public $topico ;
    public $conceito ;
    public $conceito_json ;
    public $json;
    
    public function __construct() {
        $this->topico = new Topico();
        $this->conceito = new Conceito();
    }
     
    public function listar($response){
               
          $topico = Topico::find($this->topico->id);
          
          
           $corpo = "{conceitos:[";
           
           foreach($topico->conceito_topico as $t){
               $nome =  $t->conceito->title;
               $id =  $t->conceito->id;
               $descricao =  $t->conceito->text;
               $t->conceito->text = preg_replace('/(\\\\){2,}/','\\',preg_replace('/\\\\"/','"',$t->conceito->text )) ;
               $corpo .= preg_replace('/} *$/', '', $t->conceito->to_json());
               $corpo .= ',nome_usuario: "' . $t->conceito->usuario->firstname . " " . $t->conceito->usuario->lastname . '" ';        
               $corpo .=         "},";
           }

           $corpo = preg_replace('/,$/','',$corpo) . "]}";
           
           $this->json =  $corpo;
    }
    
    
    public function formulario($response){
        
    }
     
    public function inserir($response){
        $this->conceito->userid=$response->s['USER']->id;
        
        try{
            if($this->conceito->save()){
                $conceito_topico = new ConceitoTopico();
                $conceito_topico->concepts_id = $this->conceito->id;
                $conceito_topico->discussion_id = $this->topico->id;
                $conceito_topico->save();
                $this->json = '{success:true}';            
            }else{
              $titulo_erro = $this->conceito->errors->on('title'); 
              $this->json = "{success:false,errors:{'conceito[title]':'$titulo_erro'}}";            
            }            
        }catch(Exception $e){
            $this->json = "{success:false,errors:{'dump':'Erro ao tentar gravar. " + $e->getMessage()+ "'}}";            
        }



    }
    
    public function inserir_visao($response){
        
        
    }

    
    
    
    public function alterar_visao($response){
        $this->conceito = Conceito::find($this->conceito->id);
        
        $this->conceito_json = "[";
        $this->conceito_json = $this->conceito_json . "{id:'conceito[title]', value:'" . $this->conceito->title . "'},";
        $this->conceito_json = $this->conceito_json . "{id:'conceito[text]', value:'" . $this->conceito->text . "'}]" ;
        
        
    }

    public function alterar($response){
        $conceito_antigo = Conceito::find($this->conceito->id);
        try{
            if($conceito_antigo->update_attributes($response->r['conceito'])){
                $this->json = '{success:true}';
            }else{
                  $titulo_erro = $conceito_antigo->errors->on('title'); 
                  $this->json = "{success:false,errors:{'conceito[title]':'$titulo_erro'}}";            
                }            
        }catch(Exception $e){
            $this->json = "{success:false,errors:{'dump':'Erro ao tentar gravar. " + $e->getMessage()+ "'}}";            
        }        
        
    }
    
    public function relacionar_novo_topico($response){
        $conceito_topico = new ConceitoTopico();
        $conceito_id = $this->conceito->id;
        $topico_id = $this->topico->id;
        
        if (!ConceitoTopico::exists(array('conditions' => "concepts_id = $conceito_id and discussion_id= $topico_id"))){
            $conceito_topico->concepts_id = $this->conceito->id;
            $conceito_topico->discussion_id = $this->topico->id;
            $conceito_topico->save();
            $this->json = '{success:true}';
        }else{
            $this->json = '{success:false}';
        }
        
        
        
    }
    
    public function deletar($response){
        $conceito_id = $this->conceito->id;
        $topico_id = $this->topico->id;
        
        $conceito_topico = ConceitoTopico::find(array('conditions' => "concepts_id = $conceito_id and discussion_id= $topico_id"));    
        $conceito_topico->delete();
        

        
        $this->json = '{success:true}';
    }
}
?>
