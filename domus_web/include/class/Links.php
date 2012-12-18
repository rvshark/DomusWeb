<?php

class Links{

            var $tituloLink;
	
			var $sessao;
			
			var $target;
            
			var $titulo;
            
            var $hyperLink;

            var $data;
            
		    var $id;			

 

            function link($txtTitulo, $txtHyperLink, $txtTarget){

                        $this->titulo = $txtTitulo;

                        $this->hyperLink = $txtHyperLink;

                        $this->target = $txtTarget;

            }

           

           function mostarLink($txtTarget, $txtHyperLink, $txtTituloLink){
				
				$this->hyperLynk = $txtHyperLink;
				$this->tituloLink = $txtTituloLink;
				$this->target = $txtTarget;
				
			 	echo "<a href='".$this->hyperLynk."' target='".$this->target."'>&nbsp; :: ".$this->tituloLink."&nbsp;<img src='images/link_icone.gif' border='0'></a><br/><br/>";
			 
			}

}

?>
