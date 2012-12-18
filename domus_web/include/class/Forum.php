<?php
    require_once("Query.php");
    require_once("db.php");   

    class Forum{

            var $tituloLink;
	
			var $sessao;
            
			var $titulo;
            
            var $texto;

            var $data;
            
		    var $id;			

 

        function forumx($txtTitulo, $txtTexto, $txtData){

                        $this->titulo = $txtTitulo;

                        $this->texto = $txtTexto;

                        $this->data = $txtData;

          }
           

        function mostrarForum(){

                        echo "<center>".strtoupper($this->titulo)." - ".$this->data."</center><br/>";

                        echo html_entity_decode($this->texto);
                        echo "<center><br /><br /><a href='javascript:history.back();'>| Voltar |</a></center>"; 
                        
                        
                   
          }
			
         
		  function mostarCategoria($txtSessao, $txtid, $txtTituloLink){
				
				$this->id = $txtid;
				$this->tituloLink = $txtTituloLink;
				$this->sessao = $txtSessao;

				$db = new db();
	    		$con = $db->abreBd(); 
	    		
	    		$s = "SELECT id, titulo, date_format(data_2, '%d/%m/%Y') FROM tb_forum_perguntas WHERE id_categoria = ".$this->id." ORDER BY id DESC";
	    
	   			$Select = new Query();
				$Select->select($s);
				
					
				echo "<center><table bgcolor='#FFFFFF'>";
				echo "<tr bgcolor='#c0c0c0'><td width='700' align='center' valign='middle' colspan='3'>
				<div align='left' style='background-color:#FFFFFF;'><strong>
				<font color='#000000'>".$this->tituloLink."</strong></font><br/><br/>";
				if ($Select->nregistros == 0){
	
					echo "Nenhum registro encontrado.";
	    	
	    		}else{

	    			$Select_x = new Query();
				    $bg_1 = "#FFFFFF";
				    $bg_2 = "C0C0C0";
				    $j = 1;	    			
				    echo"<table align='center' border='0' width='690'><tr bgcolor='#cccccc'><td align='center'>Titulo : </td><td align='center'>Data : </td><td align='center'>n°. Respostas : </td></tr>";
	    			for ($i = 0; $i < $Select->nregistros; $i++) {
                        
	    				$x = "SELECT COUNT(*) Total FROM tb_forum_respostas WHERE id_pergunta = ".mysql_result($Select->querys,$i, 0)."";
	    			    $Select_x->select($x);
	    			    echo "<tr  bgcolor=".(($j++& 1)?$bg_1:$bg_2)." ><td width='75%'>";
	    				echo "<a href='pForum.php?&id=".mysql_result($Select->querys,$i, 0)."'>:: ".mysql_result($Select->querys,$i, 1)."</a>&nbsp;";
	    				echo "</td><td align='center' width='10%'>".mysql_result($Select->querys,$i, 2)."</td>";
	    				
	    				for ($y = 0; $y < $Select_x->nregistros; $y++) {

	    					echo "<td align='center' width='15%'>".mysql_result($Select_x->querys,$y, 0)."</td></tr>";
	    				
	    				}
	    			}
	                echo "</table>";   
	    			echo "</td></tr>";
				  }
				
								
			    echo "</table></center>";
			    
			   $db->fechaBd($con);
			}

			function mostarPerguntasRespostas($txtid){
				
				$this->id = $txtid;
				
				$db = new db();
	    		$con = $db->abreBd(); 
	    		
	    		$s = "SELECT id, id_categoria, titulo,texto, id_usuario,ids_conceitos, date_format(data_2, '%d/%m/%Y') FROM tb_forum_perguntas WHERE id = ".$this->id."";
	    
	   			$Select = new Query();
				$Select->select($s);
				echo "<center><table border = '0' width='700' bgcolor='#FFFFFF'>";
				echo "<tr><td width='700' align='center' valign='middle' colspan='3'>
				<div align='left' style='background-color:#FFFFFF;'><strong>";
				if ($Select->nregistros == 0){
                   echo "<a href='index.php'>:: Indice do Forum</a><br/><br/>";  	
				   echo "Nenhum registro encontrado.";
	    	
	    		}else{
	    	        echo "<a href='index.php'>:: Indice do Forum</a><br/><br/>";
	    			echo "<table width='690' border='1'>";
	    	        
	    			$Select_y = new Query();
	    	        $Select_c = new Query();
	    			
	    	        for ($i = 0; $i < $Select->nregistros; $i++) {
	    				
				if(mysql_result($Select->querys,$i, 5) != ""){	    					
	    			    $c = "SELECT id, titulo FROM tb_conceitos WHERE id IN (".mysql_result($Select->querys,$i, 5).")";
	    			    $Select_c->select($c);
	    			    
	    			    $titulo = mysql_result($Select->querys,$i, 2);
	                    
	    			    echo "<tr><td width='20%' valign='top'><div id='fConceito'>Conceitos :<br/>";
	    			      			    
	    			    for ($j = 0; $j < $Select_c->nregistros; $j++) {

	    					echo "<a href='conceitos.php?id=".mysql_result($Select_c->querys,$j, 0)."'>&nbsp;:: &nbsp;".mysql_result($Select_c->querys,$j, 1)."</a><br/>";
	    				
	    				}
	    			  }  
	    			   // echo "".mysql_result($Select->querys,$i, 5)."";
	    			    
	    			    echo "</div> <br/></td>"; 
	    				echo "<td width='80%'>";
	                    echo "<div id='fTitulo'>Titulo : ".mysql_result($Select->querys,$i, 2)." &nbsp; Data : ".mysql_result($Select->querys,$i, 6).""; 
	    				echo "&nbsp;&nbsp; Autor : ".mysql_result($Select->querys,$i, 4)."";
	    				echo "</div><br/><br/>";
	                    echo "<div id='fPergunta'>Texto : ".html_entity_decode(mysql_result($Select->querys,$i, 3))."</div><br/>
	    				<br/>";
	    				echo "<font color='#FFFFFF'><a href='#' onclick=\"mostar('".mysql_result($Select->querys,$i, 0)."'); return false\">Enviar Comentario</a></font>";
				        echo "<div id='".mysql_result($Select->querys,$i, 0)."' style='display:block;'>&nbsp;";
                        $id_pergunta = mysql_result($Select->querys,$i, 0);
				        include("inserirComentario.php");
				        
				        	   
				        echo "</div></td>";
					}

					echo "</td></tr></table>";
                      $Select_x = new Query();
                      $x = "SELECT texto, id_usuario, date_format(data_2, '%d/%m/%Y') FROM tb_forum_respostas WHERE id_pergunta = ".$id_pergunta."";
	    			  $Select_x->select($x);
	    			  
	    			  $Select_z = new Query();
	    			  for ($i = 0; $i < $Select_x->nregistros; $i++) {
	                    
                      	$z = "SELECT login FROM tb_login WHERE id = '".mysql_result($Select_x->querys,$i, 1)."'";
	    			    $Select_z->select($z);
	    			  
	    			    echo "<tr><td width='80%'>";
	                    echo "<div id='fRTitulo'>RE : ".$titulo." &nbsp; Data : ".mysql_result($Select_x->querys,$i, 2).""; 
	    			    echo "&nbsp;&nbsp; Autor : ".mysql_result($Select_x->querys,$i, 1)."";
	    				echo "</div>";
	    				
	    				echo "<div id='fResposta'>&nbsp;Texto : ".html_entity_decode(mysql_result($Select_x->querys,$i, 0))."</div><br/>
	    				<br/>";
				        echo "</td></div>";
				        
					} 
	    			  echo "</td></tr></table>"; 
	    		}
												
			    echo "</table></center>";
			    
			   $db->fechaBd($con);
			}
          
			
	  }

?>

