<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of TemaController
 * Classe responsável por administrar o Tema. Myforum
 * @author Luiz Loja
 */
class TemaController {
   
    public $curso ;
    public $tema ;
    public $tema_json ;
    public $json;
    public $usuario;
    
    /**
     * Carrega o curso e o tema
     */
    public function __construct() {
        $this->curso = new Curso();
        $this->tema = new Tema();
    }
    
    /**
     * Apresenta a visão princial
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
    public function visao($response){
            $curso_modulo = CursoModulo::find($response->r['id']);
            $this->curso = $curso_modulo->curso;    
            $this->usuario = Usuario::find($response->s['USER']->id);
    }
     
    
    /**
     * Apresenta a arvore do curso para poder migrar um determinado tema
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
    public function arvore_curso($response){
        $corpo = "[{text:'Cursos',cls:'folder', expanded:false , children:[ ";
        $modulos = CursoModulo::find('all',array('module' => 22));
        foreach($modulos as $modulo){
            $nome = $modulo->curso->shortname;
            $id = $modulo->curso->id;
            $corpo .="{text:'$nome',leaf:true,  id:'$id' , checked:false },";         
        }
        $corpo = preg_replace('/,$/','',$corpo) . "]}]";            
        $this->json  = $corpo;
    }
    
    
    /**
     * Lista todos os temas de um determinado curso
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
    
    public function listar($response){
          
          $curso = Curso::find($this->curso->id);
          
          
           $corpo = "{temas:[";
           
           foreach($curso->temas as $t){
               if ($t->esta_ativo()){
                   $corpo = $corpo . $t->to_json() . ",";
               }
           }

           $corpo = preg_replace('/,$/','',$corpo) . "]}";
           
           $this->json =  $corpo;
    }
    
    
    public function formulario($response){
    }
    
    public function tema_individual(){
        $this->tema = Tema::find($this->tema->id);
    }
     
    
    /**
     * Insere um novo tema
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
    public function inserir($response){
        //$this->tema->userid=$response->s['USER']->id;
    $this->usuario =  Usuario::find($response->s['USER']->id);
    $this->tema->course=$this->curso->id;
        if(preg_match('/^( *(&nbsp;)* *(<.?br *.?>)* *)*$/',$this->tema->intro) != 0){
            $this->tema->intro =null;
        }    
        
    try{
        $this->tema->maxbytes =  $this->tema->maxbytes * 1024;
        $this->tema->ativo = true;
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
    
    
    /**
     * Copia um tema para um novo curso
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
    public function copiar_tema($response){
        $this->tema = Tema::find($this->tema->id);
        
        foreach(split(",", $response->r['cursos']['ids']) as $curso_id){
            $curso = Curso::find($curso_id);
            $this->tema->copiarTemaParaCurso($curso);

        }
    }
    
    /**
     * Apresenta a tela de visão para inserção do curso
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
    public function inserir_visao($response){
        
        
    }

    
    
    /**
     * Apresenta a tela de alteração de um determinado tema
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
    public function alterar_visao($response){
        $this->tema = Tema::find($this->tema->id);
        
        $this->tema_json = "[";
        $this->tema_json = $this->tema_json . "{id:'tema[name]', value:" . json_encode($this->tema->name) . "},";
        $this->tema_json = $this->tema_json . "{id:'tema[maxbytes]', value:" . json_encode($this->tema->maxbytes/1024) . "},";
        $this->tema_json = $this->tema_json . "{id:'tema[intro]', value:" . json_encode(preg_replace('/(\\\\){2,}/','\\',preg_replace('/\\\"/','"',$this->tema->intro))) . "}]" ;
        
        
    }

    /**
     * Altera um tema
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
    public function alterar($response){
        $tema_antigo = Tema::find($this->tema->id);
        $this->usuario =  Usuario::find($response->s['USER']->id);

        //Verifica se a introdução do tema está vazia
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
    
  
    /**
     * Remove um tema. Caso o tema tenha posts ele ficará desativado
     * Temas desativados não aparecem na visão principal
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
    public function deletar($response){
        $tema_id = $this->tema->id;
        $topico_id = $this->topico->id;
        $this->usuario =  Usuario::find($response->s['USER']->id);

       if($this->usuario->souProfessorEditor() ){
           $this->tema = Tema::find($this->tema->id);
           if(!Topico::exists(array('conditions' => " forum = $tema_id"))){
               $this->tema->delete();
           }else{
               $this->tema->ativo = false;
               $this->tema->save();
           }
           $this->json = '{success:true}'; 
       }else{

          $this->json = "{success:false,errors:{'dump':'Você não tem permissão para excluir este tema.'} }";  
       }     
    }
}

?>
