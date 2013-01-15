<?php
class Mysql{
        
        private $my_servidor = "localhost";  // Servidor mysql
        private $my_user     = "root";//"glpi"; // Usuario do banco
        private $my_senha    = "123456";//"mysql@anac"; // Senha do banco
		private $nome_bd     = "moodle";
        private $my_conecta;
		private $my_banco;
        private $sql;
        private $resultado;
        
        
        public function AbriConexao() {
                
                $this->my_conecta = mysql_connect($this->my_servidor,$this->my_user,$this->my_senha);
		$this->my_banco   = mysql_select_db($this->nome_bd);
                if(!$this->my_banco) {
                        echo "<p>N&atilde;o foi possivel conectar-se ao servidor mysql.</p>\n" 
                                 .
                                 "<p><strong>Erro my: " . mysql_error() . "</strong></p>\n";
                                 exit();
                } 
        }
        
        public function processa($sql){
                
               // $this->AbriConexao();
                
                $this->sql = $sql;
                
                $this->resultado = mysql_query($this->sql, $this->my_conecta);
                        
                if($this->resultado){
                       // $this->fecharConexao();
                        return $this->resultado;
                }  else {
                       // exit("<p>Erro Mysql: " . mysql_error() . "</p>");
                        $this->fecharConexao();
						return false;
                }

        }
        
        public function fecharConexao() {
                return mysql_close($this->my_conecta);
        }

}

?>
