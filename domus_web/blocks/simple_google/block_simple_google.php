<?php // code by PanicSoftware.co.uk


class block_simple_google extends block_list {
  
    function init() {
        $this->title = "Buscar no Google";
        $this->version = 2009281001;
	}
	
    function has_config() {
        return false;
    }  
    	function get_content() {
	    if ($this->content !== NULL) {
	        return $this->content;
		}
	
		
        
		$this->content->icons  = '';
		$this->content->footer = ''; 		
		$this->content->items[] .= "<!-- Google Block By Panic Software-->
		<center>
		
<form action='http://www.google.com.br/cse' id='cse-search-box' target='_blank'>
  <div>
    <input type='hidden' name='cx' value='partner-pub-6254809892762656:bfrdgi-tjfn' />
    <input type='hidden' name='ie' value='ISO-8859-1' />
    <input type='text' name='q' size='31' />
    <input type='submit' name='sa' value='Search' />
  </div>
</form>
<script type='text/javascript' src='http://www.google.com.br/cse/brand?form=cse-search-box&amp;lang=pt'></script>

		</center><!--End of Google Block-->";
		return $this->content;
	} 
}
?>