  <?php
	  
  class block_menu_cooperacao extends block_base{
  
	  function init(){	
		  $this->title = "Coopera&ccedil;&atilde;o";
		  $this->version = 01;		
	  }
  
	  function get_content(){
		  
		global $USER, $CFG, $COURSE;
	
			
		if ($this->content !== NULL) {
			return $this->content;
		}
			
		$this->content = new stdClass;
		$this->content->items = array();
		$this->content->text = '';
		$this->content->footer = '';
			
  
				
		if (empty($this->instance)) {
			return $this->content;
		}
		  
		$menumembersoptions='';
		$SQL="select a.name, a.id, b.module, b.id from {$CFG->prefix}modules a, {$CFG->prefix}course_modules b WHERE b.visible=0 and a.id = b.module and a.id <> 13 ORDER BY a.name";
		$menumembers = get_recordset_sql($SQL);
		
		if ($menumembers != false) {
		   
			while ($rs = rs_fetch_next_record($menumembers)) {
				
				//Traduzindo os nomes para o português.
				switch($rs->name){
				
					case "book":
						$rs->name1 = "Livro";
						break;
					case "glossary":
						$rs->name1 = "Gloss&aacute;rio";
						break;
					case "lightboxgallery":
						$rs->name1 = "Galeria";
						break;
					case "forum":
						$rs->name1 = "F&oacute;rum";
						break;
					default:
						$rs->name1 = $rs->name;
						break;				
				}
				
				$atag='<a ';
				
				if(strlen($rs->name1) < 17){
					$atag='<a class="MenuBarItemSubmenuComEspaco"';
				}
				else{
					$atag='<a class="MenuBarItemSubmenu" ';
				}
				
				$menumembersoptions .= '<li class="MenuBarItemIE">'.$atag.' href='.$CFG->wwwroot.'/mod/' . $rs->name . '/view.php?id='.$rs->id.'>'. ucwords(strtolower($rs->name1)).'</a></li>';
				
			}
		} 
		else{
			echo "sem membros no menu principal";
		}
		
		
	// Remove Blank Menus
	$menumembersoptions =str_replace('<ul></ul>','',$menumembersoptions);
	$this->content->text = "";
	//$this->content->text .='<script src="'.$CFG->wwwroot.'/blocks/menu_editor/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>';
	//<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
	
    if(!file_exists("$CFG->dataroot/".$COURSE->id."/do_not_delete/menu_cooperacao.css"))
    {
        $this->content->text.='<link href="'.$CFG->wwwroot.'/blocks/menu_cooperacao/menu_cooperacao.css" rel="stylesheet" type="text/css" />'."\n";
    }
    else
    {
        $this->content->text.='<link href="'.$CFG->wwwroot.'/file.php/'.$COURSE->id.'/do_not_delete/menu_cooperacao.css" rel="stylesheet" type="text/css" />'."\n";
    }
	$this->content->text.='	<!--[if IE6]>'."\n";
    $this->content->text.='<style type="text/css" media="screen">'."\n";
    $this->content->text.='body {'."\n";
    $this->content->text.='	behavior: url('.$CFG->wwwroot.'/blocks/menu_cooperacao/csshover2.htc); /* call hover behaviour file, needed for IE */'."\n";
    $this->content->text.='	font-size: 100%; /* enable IE to resize em fonts */'."\n";
    $this->content->text.='}'."\n";
    $this->content->text.='#menu_cooperacao ul li {'."\n";
    $this->content->text.='	float: left; /* cure IE5.x "whitespace in lists" problem */'."\n";
    $this->content->text.='	width: 100%;'."\n";
    $this->content->text.='	padding-bottom: 2px;'."\n";
    $this->content->text.='}'."\n";
    $this->content->text.='#menu_cooperacao ul li a {'."\n";
    $this->content->text.='	height: 1%; /* make links honour display: block; properly */'."\n";
    $this->content->text.='} '."\n";
    $this->content->text.='#menu_cooperacao h2 {'."\n";
    $this->content->text.='	font: 11px arial, helvetica, sans-serif; '."\n";
    $this->content->text.='	/* if required use ems for IE as it wont resize pixels */'."\n";
    $this->content->text.='}'."\n";
    $this->content->text.='.tab_holder {'."\n";
    $this->content->text.='	margin-right: 14px;'."\n";
    $this->content->text.='}'."\n";
    $this->content->text.='</style>'."\n";
    $this->content->text.='<![endif]-->'."\n";
    $this->content->text .='<script src="'.$CFG->wwwroot.'/blocks/menu_cooperacao/menu_cooperacao.js" type="text/javascript"></script>';
    $this->content->text .= '<ul class="MenuBarVertical" id="MenuBar1">'.$menumembersoptions.'</ul>';
    $this->content->text .='<script src="'.$CFG->wwwroot.'/blocks/menu_cooperacao/mcooperacao.js" type="text/javascript"></script>';

	// Checking User Mode
    if ($USER->editing)
    {	
        //$this->content->text .= '<div><a href="'.$CFG->wwwroot.'/blocks/menu_cooperacao/menueditor.php?courseid='.$COURSE->id.'">';
        //$this->content->text .= '<img src="'.$CFG->wwwroot.'/pix/i/edit.gif"/>'.'Menu Editor</a>';
        //$this->content->text .= "</div>";
    }
    
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
	  
	  
  }
	  
  ?>