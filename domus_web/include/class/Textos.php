<?php
   
class Textos{

            var $tituloLink;
	
			var $sessao;
            
			var $titulo;
            
            var $texto;
            
            var $video;

            var $data;
            
		    var $id;			

 

            function texto($txtTitulo, $txtTexto, $txtData, $txtId){

                        $this->titulo = $txtTitulo;

                        $this->texto = $txtTexto;

                        $this->data = $txtData;
                        
                        $this->id = $txtId;

            }

           

            function mostrarTexto(){

                        echo "<center>".$this->titulo." - ".$this->data."&nbsp;&nbsp;<a href=\"javascript:top.f_dialogOpen('imprimir.php?id=".$this->id."', 'Impressão - Power Domus', 'width=750px, height=510px');\"><img src=\"images/print_icone.png \" border=\"0\" alt=\"Imprimir\"></a></center><br/>";

                        echo html_entity_decode($this->texto);
                        echo "<center><br /><br /><a href='javascript:history.back();'>| Voltar |</a></center>"; 
                        
                        
                   
            }
			function mostrarTextoConceito(){

                        echo "<center>".$this->titulo." - ".$this->data."&nbsp;&nbsp;<a href=\"javascript:top.f_dialogOpen('imprimirc.php?id=".$this->id."', 'Impressão - Power Domus', 'width=750px, height=510px');\"><img src=\"images/print_icone.png \" border=\"0\" alt=\"Imprimir\"></a></center><br/>";

                        echo html_entity_decode($this->texto);
                        echo "<center><br /><br /><a href='javascript:history.back();'>| Voltar |</a></center>"; 
                        
                        
                   
            }
			
			function mostrarTextoS(){

                        echo "<center>".$this->titulo." - ".$this->data."&nbsp;&nbsp;<a href=\"javascript:top.f_dialogOpen('imprimir.php?id=".$this->id."', 'Impressão - Power Domus', 'width=750px, height=510px');\"><img src=\"images/print_icone.png \" border=\"0\" alt=\"Imprimir\"></a></center><br/>";

                        echo html_entity_decode($this->texto);
                        
                        
                   
            }
            
			function mostrarTextoPrint(){

                        echo "<center>".$this->titulo." - ".$this->data."&nbsp;&nbsp;<a href=\"javascript:window.print();\"><img src=\"images/print_icone.png \" border=\"0\" alt=\"Imprimir\"></a></center><br/>";

                        echo html_entity_decode($this->texto);
                        
                        
                   
            }
			
			function mostrarVideo(){

				return "<center>".$this->video."&nbsp;</center>";
                        
            }
            
            function mostrarTextoVideo(){

                        echo "<center>".$this->titulo." - ".$this->data."&nbsp;&nbsp;<a href=\"javascript:top.f_dialogOpen('imprimir.php?id=".$this->id."', 'Impressão - Power Domus', 'width=750px, height=510px');\"><img src=\"images/print_icone.png \" border=\"0\" alt=\"Imprimir\"></a></center><br/>";

                        echo html_entity_decode($this->texto)."<br /><br />";
                        
                        
                   
            }
			
            			
			function mostarLink($txtSessao, $txtid, $txtTituloLink, $txtData){
				
				$this->id = $txtid;
				$this->tituloLink = $txtTituloLink;
				$this->sessao = $txtSessao;
				$this->data = $txtData;

			 	echo "<a href='?acao=".$this->sessao."&id=".$this->id."'>&nbsp;:: ".$this->tituloLink." - ".$this->data."&nbsp;<img src='images/html_icone.gif' border='0'></a></a><br/><br/>";
			 
			}
			
			function mostarLinkPdf($txtSessao, $txtTarget, $txtNome, $txtTituloLink, $txtData){
				$this->target = $txtTarget;
				$this->sessao = $txtSessao;
				$this->nome = $txtNome;
				$this->tituloLink = $txtTituloLink;
				$this->data = $txtData;

			 	echo "<a href='arquivos/".$this->sessao."/".$this->nome."' target='".$this->target."'>&nbsp;:: ".$this->tituloLink." - ".$this->data."&nbsp;<img src='images/pdf_icone.gif' border='0'></a><br/><br/>";
			}
			
			function mostarLinkPpt($txtSessao, $txtTarget, $txtNome, $txtTituloLink, $txtData){
				$this->target = $txtTarget;
				$this->sessao = $txtSessao;
				$this->nome = $txtNome;
				$this->tituloLink = $txtTituloLink;
				$this->data = $txtData;

			 	echo "<a href='arquivos/".$this->sessao."/".$this->nome."' target='".$this->target."'>&nbsp;:: ".$this->tituloLink." - ".$this->data."&nbsp;<img src='images/ppt_icone.gif' border='0'></a><br/><br/>";
			}

			function mostrarTextoPdf($s, $spdf, $sppt){
                   
				   $Select = new Query();
				   $Select->select($s);
				   
				   $Select_pdf = new Query();
				   $Select_pdf->select($spdf);
				   
				   $Select_ppt = new Query();
				   $Select_ppt->select($sppt);
				   
					if ($Select_pdf->nregistros == 0 && $Select->nregistros == 0 && $Select_ppt->nregistros == 0){
		
							echo "Nenhum registro encontrado.";
		    	
		    		}else{
		    	  		
					   if ($Select_pdf->nregistros == 0 && $Select_ppt->nregistros == 0 && $Select->nregistros == 1){	
						
							if($Select->nregistros == 1){
							
								 $v = "SELECT id, nome FROM tb_videos WHERE id_texto = ".mysql_result($Select->querys,0, 0)." ORDER BY id ASC";
    
								    $Select_v = new Query();
									$Select_v->select($v);
									if ($Select_v->nregistros != 0){
								   
								       echo"<div style='border:solid 1px; border-color:#FFFFFF; position:absolute; width:395px;'>";
								    		for ($i = 0; $i < $Select->nregistros; $i++) {
								
								    			 	$this->texto("".mysql_result($Select->querys,$i, 1)."", "".html_entity_decode(mysql_result($Select->querys,$i, 3))."", "".mysql_result($Select->querys,$i, 2)."", "".mysql_result($Select->querys,$i, 0)."");
								    			
												    $this->mostrarTextoVideo();
								    		}
											
								    		echo "</div>";	
											echo"<div style='border:solid 1px; border-color:#FFFFFF; position:absolute; top:0px; left:400px; '>";
						    		      	
											for ($i = 0; $i < $Select_v->nregistros; $i++) {

							                    $this->mostrarVideo(flv("arquivos/video/".mysql_result($Select_v->querys,$i, 1)."", 180, 100));
							    			    echo "<br/><br/>";
						    		         }	
							    		     echo "</center>";
							                 echo "</div>";
								
								    }else{
								
								
										for ($i = 0; $i < $Select->nregistros; $i++) {
										  $this->texto("".mysql_result($Select->querys,$i, 1)."", "".html_entity_decode(mysql_result($Select->querys,$i, 3))."", "".mysql_result($Select->querys,$i, 2)."", "".mysql_result($Select->querys,$i, 0)."");
						    			
										    $this->mostrarTextoS();
										}	
									}
							}
					   }else{
					   
							if ($Select->nregistros !=0){
				    			for ($i = 0; $i < $Select->nregistros; $i++) {
				
				    				$this->mostarLink("det_texto" , "".mysql_result($Select->querys,$i, 0)."", "".mysql_result($Select->querys,$i, 1)."", "".mysql_result($Select->querys,$i, 2).""); 	
				    			
								}
			    	  		}	
			    	 		 
			    	  		if($Select_pdf->nregistros != 0){
								 for ($i = 0; $i < $Select_pdf->nregistros; $i++) {
				
				    					$this->mostarLinkPdf("pdf","_blank","".mysql_result($Select_pdf->querys,$i, 0)."", "".mysql_result($Select_pdf->querys,$i, 1)."", "".mysql_result($Select_pdf->querys,$i, 2).""); 	
				    			
						 		}
			    	  		}
			    	  		
			    	  		if($Select_ppt->nregistros != 0){
								 for ($i = 0; $i < $Select_ppt->nregistros; $i++) {
				
				    					$this->mostarLinkPpt("ppt","_blank","".mysql_result($Select_ppt->querys,$i, 0)."", "".mysql_result($Select_ppt->querys,$i, 1)."", "".mysql_result($Select_ppt->querys,$i, 2).""); 	
				    			
						 		}
			    	  		}
			    	  		
						 }	
		    			
					}
        }


    /**
     *
     * @param <string> $s
     * @param <string> $spdf
     */
    function mostrarTextoMapa($s, $spdf){

				   $Select = new Query();
				   $Select->select($s);

				   $Select_pdf = new Query();
				   $Select_pdf->select($spdf);

					if ($Select_pdf->nregistros == 0 && $Select->nregistros == 0){

							echo "Nenhum registro encontrado.";

		    		}else{

					   if ($Select_pdf->nregistros == 0 && $Select->nregistros == 1){

							if($Select->nregistros == 1){

								 $v = "SELECT id, nome FROM tb_videos WHERE id_texto = ".mysql_result($Select->querys,0, 0)." ORDER BY id ASC";

								    $Select_v = new Query();
									$Select_v->select($v);
									if ($Select_v->nregistros != 0){

								       echo"<div style='border:solid 1px; border-color:#FFFFFF; position:absolute; width:395px;'>";
								    		for ($i = 0; $i < $Select->nregistros; $i++) {

								    			 	$this->texto("".mysql_result($Select->querys,$i, 1)."", "".html_entity_decode(mysql_result($Select->querys,$i, 3))."", "".mysql_result($Select->querys,$i, 2)."", "".mysql_result($Select->querys,$i, 0)."");

												    $this->mostrarTextoVideo();
								    		}

								    		echo "</div>";
											echo"<div style='border:solid 1px; border-color:#FFFFFF; position:absolute; top:0px; left:400px; '>";

											for ($i = 0; $i < $Select_v->nregistros; $i++) {

							                    $this->mostrarVideo(flv("arquivos/video/".mysql_result($Select_v->querys,$i, 1)."", 180, 100));
							    			    echo "<br/><br/>";
						    		         }
							    		     echo "</center>";
							                 echo "</div>";

								    }else{


										for ($i = 0; $i < $Select->nregistros; $i++) {
										  $this->texto("".mysql_result($Select->querys,$i, 1)."", "".html_entity_decode(mysql_result($Select->querys,$i, 3))."", "".mysql_result($Select->querys,$i, 2)."", "".mysql_result($Select->querys,$i, 0)."");

										    $this->mostrarTextoS();
										}
									}
                           }else{

                                if ($Select->nregistros !=0){
                                    for ($i = 0; $i < $Select->nregistros; $i++) {

                                        $this->mostarLink("det_texto" , "".mysql_result($Select->querys,$i, 0)."", "".mysql_result($Select->querys,$i, 1)."", "".mysql_result($Select->querys,$i, 2)."");

                                    }
                                }

                                if($Select_pdf->nregistros != 0){
                                     for ($i = 0; $i < $Select_pdf->nregistros; $i++) {

                                            $this->mostarLinkPdf("pdf","_blank","".mysql_result($Select_pdf->querys,$i, 0)."", "".mysql_result($Select_pdf->querys,$i, 1)."", "".mysql_result($Select_pdf->querys,$i, 2)."");

                                    }
                                }

                             }

                        }
                    }
    }
    
    /**
     *
     * @param <string> $sppt
     */
    function mostrarSlideMapa($sppt){

           $Select_ppt = new Query();
           $Select_ppt->select($sppt);

            if ($Select_ppt->nregistros == 0){

                    echo "Nenhum registro encontrado.";

            }else{

                if($Select_ppt->nregistros != 0){
                    for ($i = 0; $i < $Select_ppt->nregistros; $i++) {

                            $this->mostarLinkPpt("ppt","_blank","".mysql_result($Select_ppt->querys,$i, 0)."", "".mysql_result($Select_ppt->querys,$i, 1)."", "".mysql_result($Select_ppt->querys,$i, 2)."");

                    }
                }

             }

    }
    
    /**
     *
     * @param <string> $svideo
     */
    function mostrarVideoMapa($svideo){

           $Select_video = new Query();
           $Select_video->select($svideo);

            if ($Select_video->nregistros == 0){

                    echo "Nenhum registro encontrado.";

            }else{

                if($Select_video->nregistros != 0){
                    for ($i = 0; $i < $Select_video->nregistros; $i++) {

                         $this->mostrarVideo(flv("../arquivos/video/".mysql_result($Select_video->querys,$i, 1)."", 180, 100));
                         echo "<br/><br/>";

                    }
                }

             }

    }



			
}

?>
