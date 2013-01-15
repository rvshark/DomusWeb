<?php


require_once "Mysql.class.php";
require_once "Menu.php";

class TreeMenu2{

	private $itens = array();							//armazenas os menus
	public $log= array();
	


	public function __construct(){
		
	}

	public function addItem( Menu2 $menu){ 				// recebe um menu e o adiciona a posição correta

		$pai = $this->search($menu); 					// verifica se o pai do novo menu existe na raiz

		if($pai->pai == -1 ){							// se o pai do resutado resultar em -1
			array_push($this->itens,$menu);				// adiciona o novo menu na raiz principal
			return $this;								// e retorna a raiz completa

		}else{											// senão
			$pai->addChild($menu);						// adiciona o novo menu no pai encontrado
			return $this;								// e retorna a raiz principal

		}




	}

	private function search($menu){						// busca por um menu na raiz principal

		$res = new Menu2(-1,"vazio",-1);					// cria um menu negativo (serve como retorno)
		foreach($this->itens as $root){					// percorre todos os itens da rais principal
			if($root->id == $menu->pai){				// se o pai do menu procurado for o menu atual
				return $root;							// devolve o nodo atual
			}else{										// senao
				$ret = $root->search($menu);			// busca nos possiveis filhos do nodo atual

				if($ret->id > -1)						// se o retorno for positivo
					return $ret;							// retorna o nodo pai
			}
		}
		return $res;									// caso não tenha sucesso na busca retorna um nodo negativo

	}

	private function imprime($vet){

		$str="";
		foreach($vet as $root){

			$str .= "<div class='tituloMenu'>".$root->nome."</div>";
			if(count($root->children)){
				$str .= "<ul>".$root->imprime($root->children)."</ul>";
			}


		}
		return $str;

	}

	public function show(){
		$this->getMenus();
		$str = "<div id='smoothmenu2' class='ddsmoothmenu-v'> ";
		$str .= $this->imprime($this->itens);
		$str .= "<br style='clear: left' /> </div>";
		return $str;

	}
	
	
	
	private function getMenus(){
	
		$this->con = Mysql::getinstance(); 						// Manipulador mysql
		//instâcia um array.
		$arrayList = array();
		$sql="select * from mdl_menu_vertical order by id";
		$query = $this->con->processa($sql);
		while($tempOBJ = mysql_fetch_object($query))
		$this->addItem(new Menu2($tempOBJ->idModule, $tempOBJ->nome,$tempOBJ->pai,$tempOBJ->link));
		
	
	
	}

	
	// função debug
	function d($value="",$stop = 0){
		echo "<br/>";
		echo "<pre>";print_r($value);echo "</pre><br/>";if($stop)exit();

	}
	
	// função log
	public function log($texto){array_push($this->log,$texto);}





}
