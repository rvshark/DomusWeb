<?php
require_once "Mysql.class.php";
class CrudMenu{
	
	private $con;
	
	public function __construct($post){
	
		$this->con = Mysql::getInstance(); 						// Manipulador mysql
		$this->atualizador($post);
		//$this->con->fecharConexao();					// encerra conexão
		
	}
	
	
	
	
	public function atualizador($id){
		//$this->d($id,1);
		
		if($this->existeNoMenu($id)){
			//$this->d($id,1);
			$this->atualizaNoMenu($id);
			
		}else{
			$this->cadastraNoMenu($id);
		}
		return;
	
	}
	public function existeNoMenu($id){
		//nota: o metodo que for utilizar deve abrir a conexão.
		
		$sql="select id from mdl_menu_vertical where idModule = {$id['id']}"; 		//echo "=>$sql <br/>";
		$query = $this->con->processa($sql);
		$result = mysql_num_rows($query);
		//$this->d($result,1);
		return  $result;
	}
	
	//select (select m.id,c.name as nome from mdl_resource as c inner join mdl_course_modules as m on (c.id = m.instance) where m.id in( 204))= (select mn.id, mn.nome from mdl_menu_vertical as mn where mn.id = 204) as result
	private function atualizaNoMenu($id){
		//$this->d($id,1);
		//nota: quem usar que abre a conexao
		if ($id['excluir']){
			
			if($this->podeExcluir($id['id'])){
				$sql="delete from mdl_menu_vertical where idModule = {$id['id']}";
				//echo "=>$sql <br/>";exit();
				$query = $this->con->processa($sql);
				//mysql_fetch_object($query);
				return;
				
			}
			echo "<script>alert('Impossivel excluir este menu.  Dica: exclua os submenus deste menu, para entao apaga-lo.')</script>";
			return;			
		}else{
		$sql="update mdl_menu_vertical set pai = {$id['pai']}, link = '{$id['link']}'  where idModule = {$id['id']}";
		//echo "=>$sql <br/>";exit();
		$query = $this->con->processa($sql);
		//mysql_fetch_object($query);
		return;
		}
	
	}
	// auxiliar de atualizaNoMenu
	public function podeExcluir($id){
		//nota: o metodo que for utilizar deve abrir a conexão.
		$sql="select id from mdl_menu_vertical where pai = {$id}"; 	
		//echo "=>$sql <br/>";exit();
		$query = $this->con->processa($sql);
		$result = mysql_num_rows($query);
		//$this->d($result,1);
		if($result == 0){
			$result = true;
			
		}else{
			
			$result = false;
		}
		return  $result;
	}
	// auxiliar de cadastraNoMenu
	private function buscaMenuNoMoodle($id){
		//nota: quem usar que abre a conexao
		$sql="select m.id,c.name as nome from mdl_resource as c inner join mdl_course_modules as m on (c.id = m.instance) where m.id in({$id['id']})";//echo "=>$sql <br/>";
		echo "buscaMenuNoMoodle=>$sql <br/>";
		$query = $this->con->processa($sql);
		$result = mysql_fetch_object($query);
		//$this->d($result,1);	
		
		if (empty($result)){
			$result = $this->buscaCursoNoMoodle($id);
			
		}
		if (empty($result)){
			
		$result = $this->buscaCategoridaNoMoodle($id);
		}
		if(!isset($result) && $id['pai'] == 0){
				//$this->d($id,1);	
				$result = $this->buscaResourceNoMoodle($id);
				$result->id = $id['id'];
		}
			
		return $result; 
	
	
	}
	// auxiliar de buscaMenuNoMoodle
	private function buscaResourceNoMoodle($id){
		//nota: quem usar que abre a conexao
		$sql="select c.id,c.name as nome from mdl_resource as c  where c.id = (select instance from mdl_course_modules where id =  {$id['id']})";//echo "=>$sql <br/>";
	echo "buscaResourceNoMoodle=>$sql <br/>";
		$query = $this->con->processa($sql);
		$result = mysql_fetch_object($query);
		return $result;
	
	
	}
	// auxiliar de buscaMenuNoMoodle
	private function buscaCategoridaNoMoodle($id){
		//nota: quem usar que abre a conexao
		$sql="select c.id,c.name as nome from mdl_course_categories as c where c.id = {$id['id']}";//echo "=>$sql <br/>";
	echo "buscaCategoridaNoMoodle=>$sql <br/>";
		$query = $this->con->processa($sql);
		$result = mysql_fetch_object($query);
		return $result;
	
	
	}
	// auxiliar de buscaMenuNoMoodle
	private function buscaCursoNoMoodle($id){
		//nota: quem usar que abre a conexao
		$sql="select c.id,c.fullname as nome from mdl_course as c where c.id = {$id['id']}";
	echo "buscaCursoNoMoodle=>$sql <br/>";
		$query = $this->con->processa($sql);
		$result = mysql_fetch_object($query);
		return $result;
	
	
	}
	private function cadastraNoMenu($id){
		//nota: quem usar que abre a conexao
		$obj = $this->buscaMenuNoMoodle($id);
		//$this->d($obj,1);	
		$sql="insert into mdl_menu_vertical (idModule,nome,pai,link) values({$obj->id},'{$obj->nome}',{$id['pai']},'{$id['link']}')";
		//echo $sql;
		$query = $this->con->processa($sql);
		return;
	
	
	}
	
	
	// função debug
	private function d($value="",$stop = 0){
		echo "<br/>";
		echo "<pre>";print_r($value);echo "</pre><br/>";if($stop)exit();
	
	}
	
	
	
	
}