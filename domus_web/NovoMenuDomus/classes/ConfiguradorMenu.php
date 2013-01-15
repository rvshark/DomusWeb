<?php
require_once "Mysql.class.php";
require_once "Menu.php";



class ConfiguradorMenu{
	
	private $con;
	private $listaMenus = array();
	
	public function __construct(){
	
		$this->con = Mysql::getInstance(); 						// Manipulador mysql
		$this->geraTitulos();							// gera titulos de menu de acordo co a config do moodle
		$this->geraPrimeiroNivel();						// gera o primeiro nive de menu de acordo com a config do moodle
		
		//$this->imprimeConfigurador();
		//$this->con->fecharConexao();					// encerra conexão
		//$this->d($this->log,0);							// mostra log de ações, mude de 0(zero) para 1(um) para ativar o stop apos impressão do menu.
	}
	public function getListaMenus(){
		//$this->d($this->listaMenus,1);
	
		return $this->listaMenus;
	
	}
	
	//adiciona os titulos de getCourseCategories ao menu
	private function geraTitulos(){
	
		foreach ($this->getCourseCategories() as $x){
	
			$this->empilhador(new Menu2($x->id,$x->name,0,"linkSUPER"));
	
	
		}
	
	}
	
	// guarda opções de menus na pilha
	public function empilhador($newMenu){
	
	
		foreach($this->listaMenus as $x){									// verifica se enu ja existe na pilha
	
			if($x->id == $newMenu->id){								// se existir volta sem fazer nada
				return;
			}
	
	
		}
	
		array_push($this->listaMenus,$newMenu);							// empilha
	
		return;
	
	
	}
	
	//adiciona os titulos de getCourses ao menu
	private function geraPrimeiroNivel(){
		$categorias = $this->getCourseCategories();
		foreach ($categorias as $cat){
	
			$this->empilhador(new Menu2($cat->id,$cat->name,0,""));		// alimenta lista menus para usar no configurador
			$cursosDaCategoria = $this->getCourses($cat->id);
			foreach ($cursosDaCategoria as $x){
				$this->empilhador(new Menu2($x->courseId,$x->fullname,$cat->id,""));		// alimenta lista menus para usar no configurador
				$this->geraSubniveis($x);									// chama cofigurador automatico do menu.
	
			}
	
		}
	}
	public function geraSubniveis($menuPai){
	
		$seqOk = $this->buscaSequenciaFiltradaDeMenu($menuPai->courseId);	// Busca a sequencia que cntem apenas os ids filhos de um menu
		$seqFull = explode(",",$menuPai->courseSequenceMenu);				// Busca a sequencia que contem todos os itens relacionados ao menu(menus, arquivos, links... etc.)
		foreach( $seqFull as $x){											// Percorro toda a sequencia de itens relacionados ao menu
	
			if(in_array($x,$seqOk)){										// verifico se o id atual realmente pertence ao conjunto de ids de menu.
	
				$newMenu = $this->getOneMenu($x);							// buusco todo o conteudo do menu
	
				$this->empilhador(new Menu2($newMenu->moduleId,$newMenu->name,0,""));											// Adiciono o novo item de menu ao menu
	
			}
		}
	}
	
		
	//Medodos de acesso a base
	
	
	// busca as categorias dos cursos (Titulos do menu. ex: conteudo, domus, etc...)
	private function getCourseCategories(){
	
	
		//instâcia um array.
		$arrayList = array();
		$sql="select * from mdl_course_categories ORDER BY sortorder";
		$query = $this->con->processa($sql);
		while($tempOBJ = mysql_fetch_object($query))
			array_push($arrayList,$tempOBJ);
		return $arrayList;
	
	
	}
	
	// busca os conteudos de cada categoria (Filhos de 1º das categorias: Domus, RQT, etc...)
	public function getCourses($category = null){
	
	
		//instâcia um array.
		$arrayList = array();
		$sql="select * from `vw_menu_vertical`";
		//echo $sql;
		if(!is_null($category)) $sql .= " where category = {$category}";
		$query = $this->con->processa($sql);
		while($tempOBJ = mysql_fetch_object($query))
			array_push($arrayList,$tempOBJ);
		return $arrayList;
	
	
	}
	
	
	// Metodo Auxiliar do metodo geraSubNiveis: Pega  array sequencia completa dos menus
	private function buscaSequenciaFiltradaDeMenu($cursoId = null){
	
	
		//instâcia um array.
		$arrayList = array();
		// SQL para paramentos completos: select r.*,rr.id as 'moduleId', rr.indent from mdl_resource as r
		$sql="
		select rr.id from mdl_resource as r
		inner join
		(
		select m.id,m.indent,m.instance from mdl_course_modules as m where  exists (select vw.courseSequenceMenu from vw_menu_vertical as vw where courseId = {$cursoId}) and m.course = {$cursoId} and m.visible =1
		)
		as rr
		on r.id = rr.instance
		and r.name not like '%LINK%'
		and r.course = {$cursoId}
		order by r.name";
		//echo "$sql <br/>OPA<br/> ";
		$query = $this->con->processa($sql);
		while($tempOBJ = mysql_fetch_array($query))
			array_push($arrayList,$tempOBJ[0]);
			return $arrayList;
	
	
	}
	
	
	private function getOneMenu($id){
	
		$arrayList = array();
		$sql="select c.*,m.id as 'moduleId', m.indent from mdl_resource as c inner join mdl_course_modules as m on (c.id = m.instance) where m.id in( {$id}) ";
		//echo "=>$sql <br/>";
		$query = $this->con->processa($sql);
		return mysql_fetch_object($query);
	}
	
	
	
	public function searchItemConfigurado($idMenu){
		//instâcia um array.
		
		$sql="select * from mdl_menu_vertical where idModule={$idMenu}";
		//echo $sql."<br/>";
		$query = $this->con->processa($sql);
		$obj =  mysql_fetch_object($query);
		//$this->d($obj);
		if(!empty($obj) && $obj->idModule == $idMenu){
				return $obj;
		}
	
			return false;
	}
	// função debug
	private function d($value="",$stop = 0){
		echo "<br/>";
		echo "<pre>";print_r($value);echo "</pre><br/>";if($stop)exit();
	
	}
	###CRUD
	
	
	
	
}