<?php
    require_once __DIR__ . '/../../../../ActiveRecord.php';
    require_once(__DIR__ . "/../../../../config.php");
//    require_once(__DIR__ . "/../../lib_forum.php");
//    require_once(__DIR__ . "/../../lib.php");

    $connections = array(
    'development' => "$CFG->dbtype://$CFG->dbuser:$CFG->dbpass@$CFG->dbhost/$CFG->dbname;charset=utf8"
  );
    
    // initialize ActiveRecord
    ActiveRecord\Config::initialize(function($cfg) use ($connections){
        $cfg->set_model_directory(__DIR__ . '/../../../../modelos_domus/');
        $cfg->set_connections($connections);
    });    
    
    
    include 'TopicoController.php';
    include 'ConceitoController.php';
    include 'BibliografiaController.php';
    include 'AnotacaoController.php';
    include 'PostController.php';
    include 'TemaController.php';
    include 'RecursoController.php';
    include 'ApplicationController.php';

  


/**
 * Description of MainController
 *
 * @author Luiz Loja
 */
class MainController {
    
    static $caminho = "../controller/MainController.php";
    
   
    static function acionarMetodo($response,$CFG){
    
        
         $mapa = array(
                'topico' => 'TopicoController',
                'conceito' => 'ConceitoController',
                'bibliografia' => 'BibliografiaController',
                'anotacao' => 'AnotacaoController',
                'post' => 'PostController',
                'tema' => 'TemaController',
                'recurso' => 'RecursoController'
         );
         
       try{
           
        //print_r($_SESSION['USER']);
           
        $objetoControlador = $mapa[$response['controller']];
        
        
        $controler_name = $response['controller'];

        $controladorClass = new ReflectionClass($objetoControlador);
        

        $controlador = $controladorClass->newInstance();
        

        $propriedades = $controladorClass->getProperties();
        

        foreach($propriedades as $propriedade) {

           MainController::preencher($propriedade->getValue($controlador),$propriedade,$response,$controlador);    
        }
        
        
        $action = $response['action'];
        $r->r =  $response;
        $r->s =  $_SESSION;
        $r->user =  $_SESSION['USER'];
        
        
        //Determinar se o usuário estará logado ou não
        if($controler_name == 'tema' && $action == 'visao'){
            $curso_modulo = CursoModulo::find($r->r['id']);
            require_login($curso_modulo->curso->id); 
            $r->s['curso_myforum'] = $curso_modulo->curso->id;
        }else{
            require_login($r->s['curso_myforum']); 
        }
        
        
        
       
       $controladorClass->getMethod($action)->invoke($controlador,$r);
       
       add_to_log($r->s['curso_myforum'], "myforum", "$objetoControlador-$action ", preg_replace('/^.*MainController.php/','MainController.php',$_SERVER ['REQUEST_URI']), $objetoControlador);  
            
       include "../view/$controler_name/$action.php";
            
        }catch(Exception $e){
            echo $e->getMessage();
        }    
       # objetoControlador 'listar';
    }
    
    
    static function preencher($atributo,$pro,$response, $controlador){


         if (get_class($atributo) != NULL && $atributo != null) {
             $atributo_reflection = new ReflectionClass(get_class($atributo)); 
                 
                 foreach($response[$pro->getName()] as $key => $value) {
                     if (!is_array($value)){
                         $atributo->$key = $value;
                     }else{
                         //código para preencher class interna
                     }
                     
                 }
             
         }else{
              $atributo = $pro->getName();
              $controlador->$atributo = $response[$pro->getName()];
         }
        
    }

    
}
  header("Content-Type: text/html; charset=utf-8"); 
   $response = null;
   if($_POST){
       $response = $_POST;
   }else{
       $response = $_GET;
   }
   MainController::acionarMetodo($response,$CFG);
?>