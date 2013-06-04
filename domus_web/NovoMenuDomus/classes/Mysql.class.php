<?php

class Mysql{
        


        private $my_servidor = "mysql.pro.pucpr.br";  // Servidor mysql
        private $my_user     = "md_domus";//"glpi"; // Usuario do banco
        private $my_senha    = "CDE#2013";//"mysql@anac"; // Senha do banco
		private $nome_bd     = "moodle_homo";
        private $con;
		private static $instance;
      
        private function __construct() 
        {
        		
				$this->con = mysql_connect($this->my_servidor,$this->my_user,$this->my_senha);
				mysql_select_db($this->nome_bd);
		}
       
	   public static function getinstance() {
            if(!isset(self::$instance)) {
                $c = __CLASS__;
                self::$instance = new $c;
            }
            return self::$instance;
        }
       
		public function processa($sql){
                
				return mysql_query($sql, $this->con);
                             

        }
        
        public function fecharConexao() {
				//unset(self::$instance);
                mysql_close($this->con);
				
        }

}

?>
