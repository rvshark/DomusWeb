<?php
	
	class Query{
 	    
		var $querys;
		var $nregistros;
		var $id_insert;
 	    
		function select($sql) {

	  		$this->querys = mysql_query($sql) or die (mysql_error());

	  		$this->nregistros = (mysql_num_rows($this->querys) > 0) ? mysql_num_rows($this->querys) : null;
	  		
		}
    	
		function insert($sql) {

	  		$this->querys = mysql_query($sql) or die (mysql_error());

	  		$this->id_insert = mysql_insert_id();
          
		}
		
		function update($sql) {

	  		$this->querys = mysql_query($sql) or die (mysql_error());
           
		}
		function delete($sql) {

	  		$this->querys = mysql_query($sql) or die (mysql_error());
  		
		}
	}    	
?>