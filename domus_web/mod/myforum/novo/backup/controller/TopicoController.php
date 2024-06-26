<?php

   
class TopicoController {
    
    public $tema ;
    public $post ;
    public $curso ;
    public $topico ;
    public $json;
    public $usuario;
    
    public function __construct() {
        $this->post = new Post();
        $this->tema = new Tema();
        $this->topico = new Topico();
        $this->curso = new Curso();
    }
     
    public function listar($response){
        
          $tema = Tema::find($this->tema->id);

           $corpo = "{topicos:[";
           foreach($tema->topicos as $t){
               $corpo = $corpo . $t->to_json() . ",";
           }
           $corpo = preg_replace('/,$/','',$corpo) . "]}";
          
           $this->json =  $corpo;
    }
    
    
    public function montar_arvore($modulo){


                $recurso_nome = $modulo->recurso->name;
                $recurso_id = $modulo->recurso->id;
                
                $filhos = $modulo->meus_filhos();
                
                if(count($filhos) == 0 && $recurso_id ){
                   $existe = TopicoRecurso::exists(array('conditions' => " discussion_id = " . $this->topico->id . " and resource_id = $recurso_id "))==1?'true':'false';
                   
                   return "{text:'$recurso_nome',leaf:true, checked:$existe,id:$recurso_id},"; 
                   
                }else{
                    $corpo .= "{text:'$recurso_nome',cls:'folder', expanded:true , children:[ " ; 
                   foreach ($filhos as $key => $filho) {
                      $corpo .= $this->montar_arvore($filho);
                   } 
                     $corpo = preg_replace('/,$/','',$corpo) . "]},";
                     return $corpo;
                }
                
                //
                //Caso tenham a mesma indentação então o módulo atual não tem filho.
                
            

    }
    
    
    public function arvore_recursos_didaticos($response){
        $this->topico = Topico::find($this->topico->id);
        $nome_curto = $this->topico->name;
                
        $corpo = "[{text:'$nome_curto', expanded:true, children:["; 
        
        $recursos = $this->topico->recursos();
        
        foreach($recursos as $key => $recurso){
            
               //$corpo .= $this->montar_pasta('Categoria','html',$recursos);
            $titulo = $recurso->name;
            
            $corpo .="{text:'$titulo',cls:'folder', id:$recurso->id,expanded:false , tipo:'html', children:[ ";
            
            $virgula = 0;
            $arquivos = $recurso->carregar_arquivos_imagem();
            
            if(sizeof($arquivos) > 0 ){
                $corpo .= $this->montar_pasta('Imagem','img','photo_scenery_16',$arquivos);    
                $virgula = 1;
            }
            
            $arquivos = $recurso->carregar_arquivos_video();
            if(sizeof($arquivos) > 0 ){
                if($virgula){
                    $corpo .= ",";
                }
                $corpo .=$this->montar_pasta('Vídeo','video','film_16',$arquivos);
                $virgula = 1;
            }

            $arquivos = $recurso->carregar_arquivos_documento();
            if(sizeof($arquivos) > 0 ){
                if($virgula){
                    $corpo .= ",";
                }
                $corpo .=  $this->montar_pasta('Arquivos','arquivo','document_16',$arquivos);  
                
                $virgula = 1;
            }            
            
         //                   $corpo .="{text:'$key',leaf:true, tipo:'html'},";     
            //$corpo .= $this->montar_pasta('Arquivos','img',$recursos);    
            //$corpo .= $this->montar_pasta('Vídeos','img',$recursos);    

            $corpo = preg_replace('/,$/','',$corpo) . "]}, "; 
            

                
        }   
        

        $corpo = preg_replace('/,$/','',$corpo) . " ] }]"  ;
        $this->json =  $corpo;
    }
    
    public function montar_pasta($titulo,$tipo,$icon,$arquivos){
        $corpo = "";
        
        if(sizeof($arquivos) > 0 ){
            $corpo .="{text:'$titulo',cls:'folder', expanded:false , children:[ ";

            foreach($arquivos as $key => $arquivo){
                $nome = $arquivo['nome'];
                $url = $arquivo['url'];
                $ext = $arquivo['ext'];
                $corpo .="{text:'$nome',leaf:true, iconCls:'$icon', tipo:'$tipo',url:'$url',ext:'$ext'},";         
            }

            $corpo = preg_replace('/,$/','',$corpo) . "]} ";            
        }

        return $corpo;
    }
    
    public function arvore_galeria($response){
        $this->topico = Topico::find($this->topico->id);
        
        $this->curso =  $this->topico->tema->curso;
      //  $this->curso = Curso::find($this->topico->curso->id);
        //$this->curso = Curso::find(21);
        $cursos = Curso::all( array('conditions' => array('id in (19,13,21,20)'))  );
        $corpo = "[{text:'Cursos', expanded:true, children:[";

        foreach ($cursos as $key_curso => $curso) {
            
            $modulos =  $curso->modulo_curso_sequencia();
            $nome_curto = $curso->fullname;
            $corpo .= "{text:'$nome_curto', expanded:false, children:["; 
            foreach ($modulos as $key => $modulo) {
                if($modulo->indent == 0){
                    $corpo .= $this->montar_arvore($modulo);
                }
            }
            $corpo = preg_replace('/,$/','',$corpo) . " ] },"  ;
        }
        $corpo = preg_replace('/,$/','',$corpo) . " ] }]"  ;
        $this->json =  $corpo;
    }

    
    public function gravar_galeria($response){
        $this->topico = Topico::find($this->topico->id);
        $topico_id = $this->topico->id;
        TopicoRecurso::delete_all(array("topico = $topico_id"));
        
        foreach(split(",", $response->r['recurso']['ids']) as $resource_id){
            $topicoRecurso = new TopicoRecurso(array('discussion_id'=> $topico_id, 'resource_id'=> $resource_id  ));
            $topicoRecurso->save();
        }
    }

    public function inserir($response){
        $this->topico->userid=$response->s['USER']->id;
        $this->topico->forum=$this->tema->id;
        $this->usuario =  Usuario::find($response->s['USER']->id);
        
        
          try{
        if($this->usuario->souProfessorEditor() && $this->topico->save() ){
            
                    $this->post->subject = $this->topico->name;
                    $this->post->userid=$response->s['USER']->id;
                    $this->post->discussion = $this->topico->id;

                    $this->post->save();
                    
                    $this->post->carregar_arquivo_do_upload();
                    $this->post->save();


                    $this->topico->first_post_id = $this->post->id;
                    $this->topico->save();

                    
                    $topico_id = $this->topico->id;
                    $this->json = "{success:true, data:{id:$topico_id}}";

            }else{
                
                if($this->topico->errors->is_invalid('name')){
                        $name_erro = $this->topico->errors->on('name'); 
                        $this->json = "{success:false,errors:{'topico[name]':'$name_erro'}}";                  
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
    
    public function alterar($response){
    	$topico_antigo = Topico::find($this->topico->id);
    	$topico_antigo->name = $this->topico->name;
    	$topico_antigo->primeiro_post->message = $this->post->message;
        $this->usuario =  Usuario::find($response->s['USER']->id);
    	
    try{
        if($this->usuario->souProfessorEditor() && $topico_antigo->save()   ){
            
                    $topico_antigo->save();
                    $topico_antigo->primeiro_post->save();
                    $this->json = "{success:true, data:{id:$topico_antigo->id}}";

            }else{
                
                if($topico_antigo->errors->is_invalid('name')){
                        $name_erro = $topico_antigo->errors->on('name'); 
                        $this->json = "{success:false,errors:{'topico[name]':'$name_erro'}}";                  
                }else{
                    $this->json = "{success:false,errors:{'tema[intro]':'Usuário não possui permissão para esta ação.'}}";
                }


            }            
        }catch(Exception $e){
            $this->json = "{success:false,errors:{'dump':'Erro ao tentar gravar. " + $e->getMessage()+ "'}}";            
        }             
    	

    	
        
    }

    
    public function alterar_visao($response){
    	
    	$this->topico = Topico::find($this->topico->id);
    	
    		$this->topico_json = "[";
    		$this->topico_json = $this->topico_json . "{id:'topico[name]', value:" . json_encode($this->topico->name) . "},";
    		$this->topico_json = $this->topico_json . "{id:'post[message]', value:" . json_encode($this->topico->primeiro_post->message) . "}]" ;
    	
    	
    	
    }    
    
    public function deletar($response){
        $this->usuario =  Usuario::find($response->s['USER']->id);

    $this->topico = Topico::find($this->topico->id);
    	$postsDoTopico = Post::all(array('conditions' => array('discussion = ?', $this->topico->id)));
    	if (count($postsDoTopico) <= 1){ // Valida se o topico possui alguma resposta relacionada

	    		if($this->usuario->souProfessorEditor() && $this->topico->delete()    ){ // realiza o delete do topico
		            $this->json = '{success:true}';
		        }else{
		            $this->json = '{success:false}';
		        }
		        
    	}else{
    		$this->json = '{success:false}';
    		
    	} 
    }
    
    
    
 }





?>
