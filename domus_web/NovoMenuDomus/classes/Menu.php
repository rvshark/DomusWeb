<?php
class Menu2{

	public $id;
	public $nivel;
	public $pai;
	public $nome;
	public $children;
	public $link;



	public function __construct($id,$nome,$pai = 0,$link = '#'){

		$this->id		= $id;
		$this->nome		= $nome;
		$this->link		= $link;
		$this->children	= array();
		if($pai === 0){
			$this->nivel	= 1;
		}
		$this->pai		= $pai;
	}


	public function addChild(Menu2 $child){
		array_push($this->children,$child);
	}


	public function search($menu){									// busca pelo novo menu nos filhos do menu atual
		$res = new Menu2(-1,"vazio",-1);								// configura menu vazio para retorno
		foreach($this->children as $child){							// percorre os filhos do menu

			if($child->id == $menu->pai){						// se o menu atual for for o pai do novo menu
				return $child;									// retorna o menu atual
			}else{
				$ret = $child->search($menu);					// realiza a busca no filho seguinte
				if($ret->id > -1)								// se o retorno for positivo
					return $ret;									// retorna o nodo pai

			}
		}
		return $res;												// se nao encontrou nada retorna o menu negativo
	}


	public function imprime($vetor){

		$str ="";
		foreach($vetor as $child){
			$str .= "<li alt='{$child->nome}' title='{$child->nome}'><a href='{$child->link}'>{$child->nome}</a>";
			;
			if(count($child->children)){
				$str .="<ul>{$this->imprime($child->children)}</ul>";
			}
			$str .= "</li>";
		}

		return $str;


	}

	public function __toString(){

		return $this->imprime($this->children);

	}





}