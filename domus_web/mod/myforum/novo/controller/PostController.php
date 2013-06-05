<?php
/**
 * Classe responsável por gerenciar as responsabilidades de Discussões
 */
class PostController {
    
    public $topico ;
    public $post ;
    public $post_json ;
    public $json;
    
    /**
     * Carrega o post e o tópico 
     */
    public function __construct() {
        $this->topico = new Topico();
        $this->post = new Post();
    }
     
    /**
     * Responde citando determinado post. Este método é invocado clicando no link responder
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
    
      public function responder($response){
        $post_citado = Post::find($this->post->id);
        
        $novo_post = new Post(); 
        $novo_post->userid=$response->s['USER']->id;
        $novo_post->discussion = $post_citado->topico->id;
        $novo_post->parent = $post_citado->id;
        $novo_post->message = $this->post->message;
        $novo_post->subject = $this->post->subject;
        
        if($novo_post->save()){
           $post_id = $novo_post->id;
            $novo_post->carregar_arquivo_do_upload();
            $novo_post->save();
           
           $this->json = "{success:true, data:{id:$post_id }}";            
        
        }else{
            $text_erro = $novo_post->errors->on('message'); 
            $this->json = "{success:false,errors:{'post[message]':'$text_erro'}}";            
        }            
          
      }
      
      /**
     * Apresenta o formulário para resposta de um post
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
      
public function responder_visao($response){
        $this->post = Post::find($this->post->id);
        
        $this->post_json = "[";
        $this->post_json = $this->post_json . "{id:'post[subject]', value:'Re:" . $this->post->subject . "'}]";
    }
    
    public function listar($response){
               
          $topico = Topico::find($this->topico->id);
          
          
           $corpo = "{posts:[";
           
           foreach($topico->posts as $t){
               
               /*$corpo = $corpo . $t->to_json(array(
                    'include' => array('usuario')
                )) . ",";*/
               #$corpo = $corpo . $t->to_json() . ",";
               $corpo .=  "{";
               $corpo .=  " id:'" . $t->id . "',";
               $corpo .=  " updated_at:'" . $t->updated_at . "',";
               $corpo .=  " userid:'" . $t->userid . "',";
               $corpo .=  " primeiroNome:'" . $t->usuario->firstname . "',";
               $corpo .=  " ultimoNome:'" . $t->usuario->lastname . "',";
               $corpo .=  " subject:'" . $t->subject . "',";
               $corpo .=  ' message:' . json_encode(preg_replace('/\\\"/','"',preg_replace('/(\\\\){2,}/','\\',$t->message)))  . ',';
               $corpo .=  ' anexo:"' . $t->recuperarUrlArquivo() . '",';
               $corpo .=  ' nome_anexo:"' . preg_replace('/^.*\\//','',$t->recuperarUrlArquivo()) . '"';
               
               if($t->parent != 0){
                    $corpo .=  ', citacaoMessage:' . json_encode(preg_replace('/\\\"/','"',preg_replace('/(\\\\){2,}/','\\',$t->citacao->message)))  . ',';
                    $corpo .=  ' citacaoId:"' . $t->citacao->id . '",';
                    $corpo .=  " citacaoPrimeiroNome:'" . $t->citacao->usuario->firstname . "',";
                    $corpo .=  " citacaoUltimoNome:'" . $t->citacao->usuario->lastname . "',";                   
                    $corpo .=  " citacaoUpdated_at:'" . $t->citacao->updated_at . "' ";                   
               }
               
               
               $corpo .=  "},";
           }

           $corpo = preg_replace('/,$/','',$corpo) . "]}";
           
           $this->json =  $corpo;
    }
    
    
    public function formulario($response){
        
    }
     
    
    /**
     * Insere um novo post
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
    public function inserir($response){
        $this->post->userid=$response->s['USER']->id;
        $this->post->discussion = $this->topico->id;
        
        
        
        if(preg_match('/^( *(&nbsp;)* *(<.?br *.?>)* *)*$/',$this->post->message) != 0){
            $this->post->message =null;
        }

        if($this->post->save()){
            $post_id = $this->post->id;
            $this->post->carregar_arquivo_do_upload();
            $this->post->save();
            $this->json = "{success:true, data:{id:$post_id }}";            
        }else{
            
            if($this->post->errors->is_invalid('message')){
                $text_erro = $this->post->errors->on('message'); 
                $this->json = "{success:false,errors:{'post[message]':'$text_erro'}}";            
            }else if ($this->post->errors->is_invalid('subject')){
                $text_erro = $this->post->errors->on('subject'); 
                $this->json = "{success:false,errors:{'post[subject]':'$text_erro'}}";            
            }


        }


    }
    
    
    /**
     * Apresenta o formulário de inserir um novo post
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
    public function inserir_visao($response){
        
        
    }

    
    
    /**
     * Apresenta o formulário de visão para alterar um determinado post
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
    public function alterar_visao($response){
        $this->post = Post::find($this->post->id);
        $this->post_json = "[";
        $this->post_json = $this->post_json . "{id:'post[subject]', value:" . json_encode($this->post->subject) . "},";
        $this->post_json = $this->post_json . "{id:'attachment', value:" . json_encode($this->post->attachment) . "},";
        $this->post_json = $this->post_json . "{id:'post[message]', value:" . json_encode(preg_replace('/\\\"/','"',preg_replace('/(\\\\){2,}/','\\',$this->post->message))) . "}]" ;
        
        
    }

    
    /**
     * Altera um post
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
    public function alterar($response){
        $post_antigo = Post::find($this->post->id);
        
        if($post_antigo->userid == $response->user->id){
                if(preg_match('/^( *(&nbsp;)* *(<.?br *.?>)* *)*$/',$response->r['post']['message']) != 0){
                    $response->r['post']['message'] =null;
                }

                if($post_antigo->update_attributes($response->r['post'])){
                    $post_antigo = Post::find($this->post->id);
                    
                    $post_id = $post_antigo->id;

                    if($response->r['upload'] == 'true'){
                        $post_antigo->carregar_arquivo_do_upload();
                        $post_antigo->save();
                    }

                    $this->json = "{success:true, data:{id:$post_id }}";          
                }else{
                    if($post_antigo->errors->is_invalid('message')){
                        $text_erro = $post_antigo->errors->on('message'); 
                        $this->json = "{success:false,errors:{'post[message]':'$text_erro'}}";            
                    }else if ($post_antigo->errors->is_invalid('subject')){
                        $text_erro = $post_antigo->errors->on('subject'); 
                        $this->json = "{success:false,errors:{'post[subject]':'$text_erro'}}";            
                    }


                }            
        }else{
            $this->json = "{success:false,errors:{'dump':'Você não é o autor deste comentário. Portanto não pode alterá-lo.'}}";            
        }
        
        

        
        
         
 
    }
    
 
    /**
     * Remove um determinado post
     * @param type $response é o response com os parametros vindos da url e sessão
     * $response->s : equivale a sessão
     * $response->user : ao usuário 
     *  $response->r : equivale ao response, tanto do get como do post
     */
    public function deletar($response){
        $this->post = Post::find($this->post->id);
        
       if($this->post->userid != $response->user->id){
            $this->json = "{success:false,errors:{'dump':'Você não é o autor deste comentário. Portanto não pode alterá-lo.' }}";            
            
       }else if ($this->post->ja_fui_citado()) {
           $this->json = "{success:false,errors:{'dump':'Este comentário já foi citado, portanto não pode ser removido.' }}";            
       
       }else if ($this->post->ainda_posso_ser_alterado()) {
           $this->json = "{success:false,errors:{'dump':'Este comentário já não pode ser removido.'}}";            
       }else{
            if($this->post->delete()){
                $this->json = '{success:true}';
            }else{
                $this->json = '{success:false}';
            }   
       } 
        
    }
}
?>
