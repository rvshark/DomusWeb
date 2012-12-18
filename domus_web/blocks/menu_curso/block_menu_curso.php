<?php

class block_menu_curso extends block_base{

	function init(){
		
		//$this->title = "Conteúdo";
		$this->header = "";
		$this->version = 01;
		$this->menu_curso = TRUE;		
		$this->cursos_domus = new CursosDomus();
	}

	function get_content(){
			
		global $USER, $CFG, $COURSE;
		
		$this->content = new stdClass;
		$this->content->items = array();
		$this->content->text = '';
		$this->content->footer = '';

		if (empty($this->instance)) {
			return $this->content;
		}
		
		$this->content->text = $this->cursos_domus->ImprimirMenu();
		
		return $this->content;
	}

		
	function instance_allow_config(){
		return true;
	}


	function specialization() {
		if(!empty($this->config->title)){
			$this->title = $this->config->title;
		}else{
			$this->config->title = 'Simple Html 2';
		}
		if(empty($this->config->text)){
			$this->config->text = 'Algum texto.';
		}
	}

	/**
	 * Funcao feita para auxiliar na ocultação de itens no menu principal
	 */
	function is_link($name)
	{

		if(strstr($name, "[-LINK]"))
		return true;
			
		return false;

	}
}

?>