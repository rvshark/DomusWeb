<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of TemaController
 *
 * @author Luiz Loja
 */
class TemaController {
   
    public $curso ;
    public $tema ;
    public $tema_json ;
    public $json;
    public $usuario;
    
    public function __construct() {
        $this->curso = new Curso();
        $this->tema = new Tema();
    }
    
    
    public function visao($response){
            $curso_modulo = CursoModulo::find($response->r['id']);
            $this->curso = $curso_modulo->curso;    
            $this->usuario = Usuario::find($response->s['USER']->id);
    }
     
    public function listar($response){
          
          $curso = Curso::find($this->curso->id);
          
          
           $corpo = "{temas:[";
           
           foreach($curso->temas as $t){
               $corpo = $corpo . $t->to_json() . ",";
           }

           $corpo = preg_replace('/,$/','',$corpo) . "]}";
           
           $this->json =  $corpo;
    }
    
    
    public function formulario($response){
        
    }
    
    public function tema_individual(){
        $this->tema = Tema::find($this->tema->id);
    }
     
    public function inserir($response){
        //$this->tema->userid=$response->s['USER']->id;
    $this->usuario =  Usuario::find($response->s['USER']->id);
    $this->tema->course=$this->curso->id;
        if(preg_match('/^( *(&nbsp;)* *(<.?br *.?>)* *)*$/',$this->tema->intro) != 0){
            $this->tema->intro =null;
        }    
        
    try{
        $this->tema->maxbytes =  $this->tema->maxbytes * 1024;
        if($this->usuario->souProfessorEditor() && $this->tema->save() ){
            $this->json = '{success:true,data:' . $this->tema->to_json() . '}';            

            }else{
                if($this->tema->errors->is_invalid('name')){
                    $titulo_erro = $this->tema->errors->on('name'); 
                    $this->json = "{success:false,errors:{'tema[name]':'$titulo_erro'}}";                                
                }else if($this->tema->errors->is_invalid('intro')){
                    $titulo_erro = $this->tema->errors->on('intro'); 
                    $this->json = "{success:false,errors:{'tema[intro]':'$titulo_erro'}}";                                
                }else{
                    $this->json = "{success:false,errors:{'tema[intro]':'Usuário não possui permissão para esta ação.'}}";
                }


            }            
        }catch(Exception $e){
            $this->json = "{success:false,errors:{'dump':'Erro ao tentar gravar. " + $e->getMessage()+ "'}}";            
        }        
        
        

    }
    
    public function inserir_visao($response){
        
        
    }

    
    
    
    public function alterar_visao($response){
        $this->tema = Tema::find($this->tema->id);
        
        $this->tema_json = "[";
        $this->tema_json = $this->tema_json . "{id:'tema[name]', value:" . json_encode($this->tema->name) . "},";
        $this->tema_json = $this->tema_json . "{id:'tema[maxbytes]', value:" . json_encode($this->tema->maxbytes/1024) . "},";
        $this->tema_json = $this->tema_json . "{id:'tema[intro]', value:" . json_encode(preg_replace('/(\\\\){2,}/','\\',preg_replace('/\\\"/','"',$this->tema->intro))) . "}]" ;
        
        
    }

    public function alterar($response){
        $tema_antigo = Tema::find($this->tema->id);
        $this->usuario =  Usuario::find($response->s['USER']->id);

     if(preg_match('/^( *(&nbsp;)* *(<.?br *.?>)* *)*$/',$response->r['tema']['intro']) != 0){
            $response->r['tema']['intro'] = null;
        }    
        
    try{
        $response->r['tema']['maxbytes'] =  $response->r['tema']['maxbytes'] * 1024;
        if($this->usuario->souProfessorEditor() && $tema_antigo->update_attributes($response->r['tema']) ){
            $this->json = '{success:true,data:' . $tema_antigo->to_json() . '}';            

            }else{
                if($tema_antigo->errors->is_invalid('name')){
                    $titulo_erro = $tema_antigo->errors->on('name'); 
                    $this->json = "{success:false,errors:{'tema[name]':'$titulo_erro'}}";                                
                }else if($tema_antigo->errors->is_invalid('intro')){
                    $titulo_erro = $tema_antigo->errors->on('intro'); 
                    $this->json = "{success:false,errors:{'tema[intro]':'$titulo_erro'}}";                                
                }else{
                    $this->json = "{success:false,errors:{'tema[intro]':'Usuário não possui permissão para esta ação.'}}";
                }


            }            
        }catch(Exception $e){
            $this->json = "{success:false,errors:{'dump':'Erro ao tentar gravar. " + $e->getMessage()+ "'}}";            
        }           
        
        
    }
    
  
    
    public function deletar($response){
        $tema_id = $this->tema->id;
        $topico_id = $this->topico->id;
        $this->usuario =  Usuario::find($response->s['USER']->id);

       if($this->usuario->souProfessorEditor() && !Topico::exists(array('conditions' => " forum = $tema_id"))){
          $this->tema = Tema::find($this->tema->id);
          $this->tema->delete();
          $this->json = '{success:true}'; 
       }else{

          $this->json = "{success:false,errors:{'dump':'Erro ao tentar remover. Tema possui tópicos.'} }";  
       }     
    }
}

?>
