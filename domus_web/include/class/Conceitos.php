<?php
   require_once("Query.php");
   require_once("db.php");
   
   class Conceitos{   	

	   	function listarCategoria(){
	
	   		        $db = new db();
		    		$con = $db->abreBd(); 
		    		
		    		$s = "SELECT id, tipo, date_format(data_2, '%d/%m/%Y') FROM tb_forum_categoria ORDER BY tipo ASC";
		    
		   			$Select = new Query();
					$Select->select($s);
					
					if ($Select->nregistros == 0){
	
						echo "<option value=''>-----------------</option>";
			     
					}else{
	    	
	    			  for ($i = 0; $i < $Select->nregistros; $i++) {
	           		
	    	       			echo "<option value='" . mysql_result($Select->querys,$i, 0) . "'>" . mysql_result($Select->querys,$i, 1) . "</option>";
				
	    				}
		
				    }
			 
		    	$db->fechaBd($con);
	   		
	   	}
	   	
   		function listarCategoriaEdit($id_categoria){
	
	   		        $db = new db();
		    		$con = $db->abreBd(); 
		    		
		    		$s = "SELECT id, tipo, date_format(data_2, '%d/%m/%Y') FROM tb_forum_categoria ORDER BY tipo ASC";
		    
		   			$Select = new Query();
					$Select->select($s);
					
					if ($Select->nregistros == 0){
	
						echo "<option value=''>-----------------</option>";
			     
					}else{
	    	
	    			  for ($i = 0; $i < $Select->nregistros; $i++) {
	           		       if($id_categoria == mysql_result($Select->querys,$i, 0)){
	           		       	   $selected = "selected = 'selected'";
	           		       }else { $selected = " "; }
	    	       			echo "<option value='" . mysql_result($Select->querys,$i, 0) . "' ".@$selected.">" . mysql_result($Select->querys,$i, 1) . "</option>";
				
	    				}
		
				    }
			 
		    	$db->fechaBd($con);
	   		
	   	}
	     
   		function listarConceitos(){
			
	        $db = new db();
	        $con = $db->abreBd();
	        
	        $s = "SELECT id, titulo FROM tb_conceitos ORDER BY titulo ASC";
	    	
	   	  	$Select = new Query();
			$Select->select($s);    
			if ($Select->nregistros == 0){
	
				echo "<option value=''>-----------------</option>";
			     
			}else{
	    	
	    	  for ($i = 0; $i < $Select->nregistros; $i++) {
	           
	    	       echo "<option value=\"'". mysql_result($Select->querys,$i, 0) . "'\">" . mysql_result($Select->querys,$i, 1) . "</option>";
				
	    		}
		
		    }
			 
		    $db->fechaBd($con);
		}
		
	    function listarConceitosLink(){
				$db = new db();
		    	$con = $db->abreBd();
		
		        $s = "SELECT id, titulo FROM tb_conceitos ORDER BY titulo ASC";
		    	
		   	  	$Select = new Query();
				$Select->select($s);    
		   		
			   if ($Select->nregistros == 0){
				
					echo "<option value=''>-----------------</option>";
						     
				}else{
				    	
			   	  for ($i = 0; $i < $Select->nregistros; $i++) {
				           
			   	       echo "<option value=http://".$_SERVER['HTTP_HOST']."/forum/conceitos.php?id=".mysql_result($Select->querys,$i, 0)." target='_self'>" . mysql_result($Select->querys,$i, 1) . "</option>";
							
			   		}
		        }
	
		        $db->fechaBd($con);
	   }
	   
        function listarConceitosLinkPrincipal(){
				$db = new db();
		    	$con = $db->abreBd();
		
		        $s = "SELECT id, titulo FROM tb_conceitos ORDER BY titulo ASC";
		    	
		   	  	$Select = new Query();
				$Select->select($s);    
		   		
			   if ($Select->nregistros == 0){
				
					echo "<option value=''>-----------------</option>";
						     
				}else{
				    	
			   	  for ($i = 0; $i < $Select->nregistros; $i++) {
				           
			   	       echo "<option value=".$_SERVER['HTTP_HOST']."/?acao=conceitos&id=".mysql_result($Select->querys,$i, 0).">" . mysql_result($Select->querys,$i, 1) . "</option>";
							
			   		}
		        }
	
		        $db->fechaBd($con);
	   }
	   
	   function listarTextosLinkPrincipal(){
				$db = new db();
		    	$con = $db->abreBd();
		
		        $s = "SELECT id, titulo FROM tb_textos ORDER BY titulo ASC";
		    	
		   	  	$Select = new Query();
				$Select->select($s);    
		   		
			   if ($Select->nregistros == 0){
				
					echo "<option value=''>-----------------</option>";
						     
				}else{
				    	
			   	  for ($i = 0; $i < $Select->nregistros; $i++) {
				           
			   	       echo "<option value=".$_SERVER['HTTP_HOST']."/?acao=det_texto&id=".mysql_result($Select->querys,$i, 0).">" . mysql_result($Select->querys,$i, 1) . "</option>";
							
			   		}
		        }
	
		        $db->fechaBd($con);
	   }
       
	    function listarConceitosEdit($ids_conceito){
			
	        $db = new db();
	        $con = $db->abreBd();
	        
	        $s = "SELECT id, titulo FROM tb_conceitos ORDER BY titulo ASC";
	    	
	   	  	$Select = new Query();
			$Select->select($s);

			
			if ($Select->nregistros == 0){
	
				echo "<option value=''>-----------------</option>";
			     
			}else{
	    	  
			  $conceitos = explode(",", $ids_conceito);
	    	   
	    	  for ($i = 0; $i < $Select->nregistros; $i++) {
	    	    	
		    	 echo "<option value=\"'". mysql_result($Select->querys,$i, 0) . "'\""; 
	    	   	 foreach ($conceitos as $keys){	

	    	   	 	if($keys == "'". mysql_result($Select->querys,$i, 0) . "'"){ echo " selected = 'selected'"; }

	    	   	 }
	    	   	 echo ">" . mysql_result($Select->querys,$i, 1) . "</option>";
	    	    }
		
		   }
			 
		    $db->fechaBd($con);
		}
  }
?>