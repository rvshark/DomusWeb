<?php

class BibliografiaController {
    
    public $topico ;
    public $bibliografia ;
    public $bibliografia_json ;
    public $json;
    
    public function __construct() {
        $this->topico = new Topico();
        $this->bibliografia = new Bibliografia();
    }
     
    public function listar($response){
               
          $topico = Topico::find($this->topico->id);
          
          
           $corpo = "{bibliografias:[";
           
           foreach($topico->bibliografia_topico as $t){
               $id =  $t->bibliografia->id;
               $descricao =  $t->bibliografia->text;
               
               $corpo .= preg_replace('/} *$/', '', $t->bibliografia->to_json());
               $corpo .= ',nome_usuario: "' . $t->bibliografia->usuario->firstname . " " . $t->bibliografia->usuario->lastname . '" ';        
               $corpo .=         "},";


           }

           $corpo = preg_replace('/,$/','',$corpo) . "]}";
           
           $this->json =  $corpo;
    }
    
    
    public function formulario($response){
        
    }
     
    public function inserir($response){
        $this->bibliografia->userid=$response->s['USER']->id;
        if(preg_match('/^( *(&nbsp;)* *(<.?br *.?>)* *)*$/',$this->bibliografia->text) != 0){
            $this->bibliografia->text =null;
        }            
        
        try{
            if($this->bibliografia->save()){
                $bibliografia_topico = new BibliografiaTopico();
                $bibliografia_topico->biblio_id = $this->bibliografia->id;
                $bibliografia_topico->discussion_id = $this->topico->id;
                $bibliografia_topico->save();
                $this->json = '{success:true}';            
            }else{
                $text_erro = $this->bibliografia->errors->on('text'); 
                $this->json = "{success:false,errors:{'bibliografia[text]':'$text_erro'}}";            
            }
            
        }catch(Exception $e){
            $this->json = "{success:false,errors:{'dump':'Erro ao gravar bibliografia. " . $e->getMessage() . " '}}";            
        }


    }
    
    public function inserir_visao($response){
        
        
    }

    
    
    
    public function alterar_visao($response){
        $this->bibliografia = Bibliografia::find($this->bibliografia->id);
        
        $this->bibliografia_json = "[";
        $this->bibliografia_json = $this->bibliografia_json . "{id:'bibliografia[text]', value:'" . $this->bibliografia->text . "'}]" ;
        
        
    }

    public function alterar($response){
        $bibliografia_antigo = Bibliografia::find($this->bibliografia->id);

        if(preg_match('/^( *(&nbsp;)* *(<.?br *.?>)* *)*$/',$response->r['bibliografia']['text']) != 0){
            $response->r['bibliografia']['text'] =null;
        }              
        
        try{
            if($bibliografia_antigo->update_attributes($response->r['bibliografia'])){
                $this->json = '{success:true}';
            }else{
                $text_erro = $bibliografia_antigo->errors->on('text'); 
                $this->json = "{success:false,errors:{'bibliografia[text]':'$text_erro'}}";            
            }
            
        }catch(Exception $e){
            $this->json = "{success:false,errors:{'dump':'Erro ao gravar bibliografia. " . $e->getMessage() . " '}}";            
        }        
        
    }
    
    public function relacionar_novo_topico($response){
        $bibliografia_topico = new BibliografiaTopico();
        $bibliografia_id = $this->bibliografia->id;
        $topico_id = $this->topico->id;
        
        if (!BibliografiaTopico::exists(array('conditions' => "biblio_id = $bibliografia_id and discussion_id= $topico_id"))){
            $bibliografia_topico->biblio_id = $this->bibliografia->id;
            $bibliografia_topico->discussion_id = $this->topico->id;
            $bibliografia_topico->save();
            $this->json = '{success:true}';
        }else{
            $this->json = '{success:false}';
        }
        
        
        
    }
    
    public function deletar($response){
        $bibliografia_id = $this->bibliografia->id;
        $topico_id = $this->topico->id;
        
        $bibliografia_topico = BibliografiaTopico::find(array('conditions' => "biblio_id = $bibliografia_id and discussion_id= $topico_id"));    
        $bibliografia_topico->delete();
        

        
        $this->json = '{success:true}';
    }
}
?>
