<?php


class myCon{
        
        private $my_servidor = "";  // Servidor Oracle
        private $my_user        = ""; // Usuario do banco
        private $my_senha      = ""; // Senha do banco
        private $my_conecta;
		private $my_banco;
        private $sql;
        private $resultado;
        
        
        public function __construct($server,$user,$pass){
        	
        	$this->my_servidor	=	$server;
        	$this->my_user		=	$user;
        	$this->my_senha		=	$pass;
        	
        	
        }
        
        private function AbriConexao() {
                
                $this->my_conecta = mysql_connect($this->my_servidor,$this->my_user,$this->my_senha);
                $this->my_banco   = mysql_select_db("moodle");
                if(!$this->my_banco) {
                        echo "<p>N&atilde;o foi possivel conectar-se ao servidor mysql.</p>\n" 
                                 .
                                 "<p><strong>Erro my: " . mysql_error() . "</strong></p>\n";
                                 exit();
                } 
                
        }
        
        public function processa($sql){
               
                $this->AbriConexao();
                
                $this->sql = $sql;
                
                $this->resultado = mysql_query($this->sql, $this->my_conecta);
                
                if($this->resultado){
                        $this->fecharConexao();
                        return $this->resultado;
                }  else {
                        exit("<p>Erro Mysql: " . mysql_error() . "</p>");
                        $this->fecharConexao();
                }

        }
        
        private function fecharConexao() {
                return mysql_close($this->my_conecta);
        }

}

class myUtils{
	
	
	/* Formata��o Avisos do sistema */
	static $aviso	= "-moz-border-radius:6px;-webkit-border-radius:6px;border:1px #DAA520 solid;padding:5px;background-color:#FFF8DC; width:70%;margin:0 auto; margin-top:10px;margin-bottom:10px;font-weight:bold;text-align:center;";
	static $erro 	= "erro{-moz-border-radius:6px;-webkit-border-radius:6px;border:1px #FF82AB solid;padding:5px;background-color:#FFE4E1; width:70%;margin:0 auto; margin-top:10px;margin-bottom:10px;font-weight:bold;text-align:center;";
	static $ok 		= "-moz-border-radius:6px;-webkit-border-radius:6px;border:1px #228B22 solid;padding:5px;background-color:#B5DA87; width:70%;margin:0 auto; margin-top:10px;margin-bottom:10px;font-weight:bold; text-align:center;";
	
	// Cria e popula a variavel mensagem de sucesso
	static function setSuccessMensagem($valor){
	
		echo  "<div style='".self::$ok."'>{$valor}</div>";
	
	}
	// Cria e popula a variavel mensagem de erro
	static function setErrorMensagem($valor){
	
		echo "<div style='".self::$erro."'>{$valor}</div>";
	
	}
	// Cria e popula a variavel mensagem de alerta
	static function setWarningMensagem($valor){
	
		echo "<div style='".self::$aviso."'>{$valor}</div>";
	
	}
	
	
	
	
	
	
}

?>
