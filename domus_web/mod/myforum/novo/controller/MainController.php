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
 * É a classe de controle geral responsável por receber todas as solicitações
 * Ela deve receber um controlador e uma ação.
 * Este controlador é o ponto de entrada para todas as requisções do fórum
 * Parametros
 *      controller : é o controlador que será acionado para executar a ação
 *      action: é a ação que será executada. O nome da ação é igual ao método
 *      que será acionado na classe controller. Por exemplo, se a o controller TemaController
 *      e a ação inserir forem passados para o MainController então o método inserir
 *      será invocado na classe TemaController 
 *      
 */
class MainController {
    
    //Caminho do main controller
    static $caminho = "../controller/MainController.php";
    
   
    static function acionarMetodo($response,$CFG){
    
        
        //Faz um mapa relacionando o nome da classe controller com o seu respectivo
        //controlador
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
        //Cria um response que será passado como parametro para o método que será invocado
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
        
        
        
       //Invoca a ação do controlador através de reflection
       $controladorClass->getMethod($action)->invoke($controlador,$r);
       
       //Adiciona o log da ação executada
       add_to_log($r->s['curso_myforum'], "myforum", "$objetoControlador-$action ", preg_replace('/^.*MainController.php/','MainController.php',$_SERVER ['REQUEST_URI']), $objetoControlador);  
            
       //Invoca a visão correspondente ao método
       include "../view/$controler_name/$action.php";
            
        }catch(Exception $e){
            //Se ocorrer alguma exceção ela será apresentada 
            echo $e->getMessage();
        }    
       # objetoControlador 'listar';
    }
    
    //Este método é responsável por preencher os atributos da classe através de
    //reflection
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
  //Transforma o post e o get em um response.
   $response = null;
   if($_POST){
       $response = $_POST;
   }else{
       $response = $_GET;
   }
   //Aciona o método do MainController para invocar os métodos passados como parametro
   MainController::acionarMetodo($response,$CFG);
?>