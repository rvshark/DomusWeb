<?php

class db{
       
  	       var $host = "localhost";
  	 	   var $user = "root";
  	 	   var $pass = "";
  	 	   var $db = "powerdomus";
       
  	    	function abreBd() {
  
  	          $conn = mysql_connect($this->host,$this->user,$this->pass) or die ("<br><br><center>" . mysql_error() . "</center>");
  	          mysql_select_db($this->db) or die ("<br><br><center>" . mysql_error() . "</center>");
  	    
  	     	 return $conn;
      
  	       }
      
        	function fechaBd($conn) {
      
          	    mysql_close($conn);
	
	       }
   	}

?>