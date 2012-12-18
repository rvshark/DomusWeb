<?php
/**
 * @author HERSILIO BELINI DE OLIVEIRA
 * @version 2.0
 * @package util
 */
class CursosDomus {

	var $array_cursos;
	var $text;

	function CursosDomus() {
		$this -> array_cursos = array();
		$this -> text = '';
	}

	/**
	 * Altera o id dos array_pais para ficar em sequência
	 */
	function AlteraidPais() {

		$array = $this -> array_cursos;
		$count = 1;
		foreach ($this->array_cursos as $key => $value) {
			if ($value['qtd_filhos'] > 0) {
				for ($i = 0; $i < sizeof($array); $i++) {
					if ($array[$i]['id'] == $value['id']) {
						$this -> array_cursos[$i]['pai_id'] = $count;
						//unset($array[$i]);
					} else if ($array[$i]['pai'] == $value['id'] && $array[$i]['nome'] != '') {
						$this -> array_cursos[$i]['pai'] = $count;
						$array['nome'] = '';
						//unset($array[$i]);
					}
				}
				$count += 1;
			}
		}
	}

	/**
	 * Função para retornar os ids que tem filhos
	 */
	function ArrayPais() {

		$array_temp = array();

		foreach ($this->array_cursos as $key => $arr) {
			$count = 0;
			for ($i = 0; $i < sizeof($this -> array_cursos); $i++) {
				if ($arr['pai_id'] == $this -> array_cursos[$i]['pai'] && $arr['pai_id'] != 0)
					$count += 1;
			}

			if ($count > 0)
				array_push($array_temp[] = array('pai_id' => $arr['pai_id'], 'qtd_filhos' => $count));
		}

		return $array_temp;
	}

	/**
	 * Preenche o pai do nó e a quantidade de filhos que o nó contém
	 */
	function MenuPai($array) {
		$indent = '';
		$pai = '';
		$arrTemp = array();

		//Correr todo o array para pegar os pais
		foreach ($array as $key => $row) {

			//Se for o primeiro nivel e apenas adiciona na nova array e continua o foreach
			if ($row['indent'] == -1) {
				$x = array('id' => $row['id'], 'nome' => $row['nome'], 'indent' => $row['indent'], 'pai_id' => $row['id'], 'qtd_filhos' => 0, 'pai' => 0);
				$array[$key] = $x;
				$count += 1;
				continue;
			}

			$indent = $row['indent'];
			for ($i = $key; $indent >= $row['indent']; $i--) {
				$arrTemp = $array[$i];
				$indent = $arrTemp['indent'];
				$pai = $arrTemp['id'];
			}

			$x = array('id' => $row['id'], 'nome' => $row['nome'], 'indent' => $row['indent'], 'pai_id' => $row['pai_id'], 'qtd_filhos' => 0, 'pai' => $pai);
			$array[$key] = $x;
		}

		reset($array);
		$arrTemp = array();
		foreach ($array as $key => $row) {
			$count = 0;

			for ($i = 0; $i < sizeof($array); $i++) {
				$arrTemp = $array[$i];
				if ($arrTemp['pai'] == $row['id'])
					$count += 1;
			}

			$x = array('id' => $row['id'], 'nome' => $row['nome'], 'indent' => $row['indent'], 'pai_id' => $row['pai_id'], 'qtd_filhos' => $count, 'pai' => $row['pai']);
			$array[$key] = $x;
		}

		return $array;
	}

	/**
	 * Retorna a sequencia certa dos nós
	 */
	function Sequence($id_course, $nome = '') {
		global $USER, $CFG, $COURSE;

		$array = array();
		$array_sequence = array();

		/**
		 * @var $sql - Query para buscar a sequ�ncia para mostrar
		 *             o menu do curso
		 */
		$sql = "SELECT sequence FROM {$CFG->prefix}course_sections
	  			  WHERE visible = 1
	  			    AND section = 0
	  			    AND course = $id_course";

		array_push($array_sequence, $id_course);

		$sequence = get_recordset_sql($sql);
		$rs = rs_fetch_record($sequence);

		$array_sequence = array_merge($array_sequence, split(',', $rs -> sequence));
		//Quebra o resultado da qry em uma array;

		/**
		 * @var $sql1 - Query para buscar a indenta??o dos m?dulos
		 */
		$sql1 = "SELECT distinct cm.id,cm.indent,r.name
				  FROM {$CFG->prefix}resource r, 
				  {$CFG->prefix}course_modules cm
				  WHERE r.id = cm.instance
				  AND r.course = $id_course
				  AND cm.visible = 1";

		$indent = get_recordset_sql($sql1);

		/**
		 * Cria o array na sequencia definida no banco com sua respectiva indenta�ao
		 **/
		$i = $count = 0;
		$pai = '';
		foreach ($array_sequence as $key => $value) {
			if ($i == 0) {
				$x = array('id' => $id_course, 'nome' => $nome, 'indent' => -1, 'pai_id' => 0, 'qtd_filhos' => 0, 'pai' => 0);
				array_push($array[] = $x);
				$i += 1;
			}
			while ($rs1 = rs_fetch_next_record($indent)) {
				if ($value == $rs1 -> id) {
					if (!self::IsLink($rs1 -> name)) {
						$x = array('id' => $rs1 -> id, 'nome' => $rs1 -> name, 'indent' => $rs1 -> indent, 'pai_id' => 0, 'qtd_filhos' => 0, 'pai' => 0);
						array_push($array[] = $x);
						break;
					}
				}
			}
			$indent = get_recordset_sql($sql1);
		}

		return $this -> MenuPai($array);
	}

	/**
	 * Função para verificar se é link
	 */
	function IsLink($name) {
		if (strstr($name, "[-LINK]"))
			return true;
		return false;
	}

	/**
	 * Função para Concatenar arrays
	 */
	function Concat() {
		$vars = func_get_args();
		$array = array();
		foreach ($vars as $var) {
			if (is_array($var)) {
				foreach ($var as $val) {$array[] = $val;
				}
			} else {
				$array[] = $var;
			}
		}
		return $array;
	}

	/**
	 * Define as cores do menu principal
	 */
	function CoresMenu() {
		return "'#dedede','','#dedede','#409db5','#409db5','#cdcdcd','','#c0c0c0',
				'','','','','#409db5','#ffffff','#ffffff','#409db5','#409db5',";
	}

	/**
	 * Fazer cache do menu gerado
	 */
	function SetMenuCache($menu) {
		global $CFG;

		$sql = "INSERT INTO {$CFG->prefix}cache_menu VALUES (1,'menu_curso','" . str_replace("'", "\'", $menu) . "',UNIX_TIMESTAMP())";

		$menumembers = get_recordset_sql($sql);

	}

	/**
	 * Recuperar menu do cache
	 */
	function GetMenuCache() {
		global $CFG;

		$sql = "SELECT value FROM {$CFG->prefix}cache_menu  WHERE id = '1'";
		$menumembers = get_recordset_sql($sql);

		return $menumembers -> fields["value"];
	}

	/**
	 * Limpar o cache do menu
	 */
	function LimparCache() {
		global $CFG;
		$sql = "DELETE FROM {$CFG->prefix}cache_menu WHERE id = '1'";
		execute_sql($sql,false);
	}

	/**
	 * Imprime array para montar Arvore dos cursos e suas atividades nas galerias
	 */
	function ImprimirTree() {
		global $CFG;

		/**
		 /* CURSOS DO DOMUS
		 **/
		$SQL = "SELECT distinct cu.fullname, cu.id
			      FROM {$CFG->prefix}course cu
			     INNER JOIN {$CFG->prefix}course_categories cat ON cat.id = cu.category
			     WHERE cat.id = 2
			       AND cu.visible = 1
			       AND cat.visible = 1
			     ORDER BY cu.sortorder";

		$menumembers = get_recordset_sql($SQL);

		if ($menumembers != false) {

			$countPai = 0;

			while ($rs = rs_fetch_next_record($menumembers)) {
				$this -> array_cursos = $this -> Concat($this -> array_cursos, $this -> Sequence($rs -> id, $rs -> fullname));
			}
			return $this -> MenuPai($this -> array_cursos);
		}
	}	
	 
	 /**
	 * @method HtmlBlocoMenu: Monta o html padrão de cada bloco do menu	  
	 * @var $codigo: Codigo que identifica o bloco	  
	 * @var $titulo: Titulo do bloco
	 * @var $strm: Conjunto de códigos js para montar o menu
	 * @return String
	 */
	function HtmlBlocoMenu($codigo, $titulo, $strm)
	{
		$bloco_id = '';
		
		switch($codigo) {
			case 'cooperacao': $bloco_id = 0; break;
			case 'cursos': $bloco_id = 1; break;
			case 'conteudos': $bloco_id = 2; break;
			default: $bloco_id = 0; break;
		}
		
		return '<div class="coperacao" style="display:none">
					<div class="header">
						<div class="title"><h2>'.$titulo.'</h2></div>
					</div>
					<div class="contentCoperacao"><div id="PLVFOXXIEHV'.$bloco_id.'Div" style="z-index: 49;position:relative"><div></div>
				    <script type="text/javascript" language="javascript">
						$(document).ready(function(){
							' . $strm . 'XXIEHV'.$bloco_id.'.init("PLVFOXXIEHV'.$bloco_id.'",strm);
						});
					</script>
				</div></div></div>';		
	}
	
	/**
	 * @method BlocoCooperacao: Monta bloco de links de cooperação 
	 * @return String
	 */
	function BlocoCooperacao()
	{		
		global $CFG, $COURSE;	
		$menu = '';		
		$sql_cop = "SELECT m.name, cm.module, cm.id
				      FROM {$CFG->prefix}modules m
				     INNER JOIN {$CFG->prefix}course_modules cm ON m.id = cm.module
				     WHERE cm.visible=1
  					   AND cm.course = 1
					   AND cm.section = 13
					   AND m.id <> 13
				     ORDER BY m.name = 'forum'DESC,
					        m.name = 'book' DESC,
					        m.name = 'chat' DESC,
					        m.name = 'wiki' DESC";
		$menucop = get_recordset_sql($sql_cop);

		if ($menucop != false) {
						
			$strm = '';

			while ($rs = rs_fetch_next_record($menucop)) {

				//Traduzindo os nomes para o português.
				switch($rs->name) {

					case "book" :
						$rs -> name1 = "Livro";
						break;
					case "glossary" :
						$rs -> name1 = "Gloss&aacute;rio";
						break;
					case "lightboxgallery" :
						$rs -> name1 = "Galeria";
						break;
					case "forum" :
						$rs -> name1 = "F&oacute;rum Domus";
						break;
					default :
						$rs -> name1 = $rs -> name;
						break;
				}

				$strm .= "0,0,'" . ucwords(strtolower($rs -> name1)) . "','" . ucwords(strtolower($rs -> name1)) . "','" . $CFG -> wwwroot . '/mod/' . $rs -> name . '/view.php?id=' . $rs -> id . "','','','',0,0,";
			}
			$strm = "var strm = [0," . $menucop -> NumRows() . "," . $this -> CoresMenu() . substr($strm, 0, strlen($strm) - 1) . "];";
			$menu .= $this->HtmlBlocoMenu("cooperacao","Cooperação",$strm);
		}
		
		return $menu;
	}
	
	/**
	 * @method BlocoCursos: Monta o bloco dos cursos
	 * @return String
	 */
	function BlocoCursos()
	{
		global $CFG, $COURSE;
		$this -> array_cursos = $arrCurso = array();
		$sql_cat = "SELECT id, name FROM {$CFG->prefix}course_categories ORDER BY sortorder ";
		$cursos = get_recordset_sql($sql_cat);		
		$strm = "var strm = [0," . $cursos -> NumRows() . "," . $this -> CoresMenu();
		
		while ($rs_curso = rs_fetch_next_record($cursos)) {
			
			$arrCurso[$cursos -> CurrentRow()] = $rs_curso -> id;
			$strm .= "0," . $cursos -> CurrentRow() . ",'" . $rs_curso -> name . "','" . $rs_curso -> name . "','javascript:void(0)','','','',0,0,";
			
			//Montar o menu de pesquisa 
			if($rs_curso -> id == 4)
				$this -> array_cursos = $this -> concat($this -> array_cursos, $this -> Sequence(25, ""));
		}
		
		for($i = 1; $i <= $cursos -> NumRows(); $i++)
		{	
			if($arrCurso[$i] == 4)
			{
			    //TODO Alterar para dinamica o numero de itens do curso pesquisa
				$strm .= "$i,".sizeof($this -> array_cursos).",". $this -> CoresMenu();
				
				foreach ($this -> array_cursos as $key => $row) {
					if ($row['pai'] == 25) {
						$strm .= "0,0,'" . $row['nome'] . "','" . $row['nome'] . "','$CFG->wwwroot/mod/resource/view.php?id=" . $row['id'] . "','','','',0,0,";
					}
				}													
			}
			else{
				//TODO alterar o ID do forum
				$strm .= "$i,3,". $this -> CoresMenu();
				//$strm .= "0,0,'Atividades','Atividades','".$CFG->wwwroot."/mod/assignment/index.php?id=".$arrCurso[$i]."','','','',0,0,
				$strm .= "0,0,'Atividades','Atividades','".$CFG->wwwroot."/course/view.php?id=21','','','',0,0,
						  0,0,'Wiki','Wiki','".$CFG->wwwroot."/mod/wiki/index.php?id=".$arrCurso[$i]."','','','',0,0,
						  0,0,'Fórum','Fórum','".$CFG->wwwroot."/mod/myforum/novo/controller/MainController.php?controller=tema&action=visao&id=761','','','',0,0,";
			}
		}	
		
		return $this->HtmlBlocoMenu("cursos","Cursos",substr($strm, 0, strlen($strm) - 1) . '];');
	}

	/**
	 * @method BlocoConteudos: Monta o bloco de conteúdos do curso selecionado
	 * @var $idCurso: Código do curso para selecionar os seus conteúdos
	 * @return String
	 */
	function BlocoConteudos($idCurso)
	{
		global $CFG, $COURSE;		
		$countCurso = 0;
		$this -> array_cursos = array();
		
		$sql_conteudos = "SELECT distinct cu.fullname, cu.id
					        FROM {$CFG->prefix}course cu
					       INNER JOIN {$CFG->prefix}course_categories cat ON cat.id = cu.category
					   	   WHERE cat.id = $idCurso
					         AND cu.visible = 1
					         AND cat.visible = 1
					       ORDER BY cu.sortorder";
		$conteudos = get_recordset_sql($sql_conteudos);
		
		while ($rs_conteudo = rs_fetch_next_record($conteudos)) {
			$this -> array_cursos = $this -> concat($this -> array_cursos, $this -> Sequence($rs_conteudo -> id, $rs_conteudo -> fullname));
		}
		$this -> AlteraidPais();
		$strm = "var strm = [0," . $conteudos -> NumRows() . "," . $this -> CoresMenu();

		foreach ($this->array_cursos as $key => $row) {
			if ($row['indent'] == -1) {
				$id = $row['qtd_filhos'] > 0 ? $row['pai_id'] : 0;
				$strm .= "0," . $id . ",'" . $row['nome'] . "','" . $row['nome'] . "','javascript:void(0);','','','',0,0,";
			}
		}

		reset($this -> array_cursos);
		$array_pais = $this -> ArrayPais();

		foreach ($array_pais as $keyPai => $rowPai) {

			$strm .= $rowPai['pai_id'] . "," . $rowPai['qtd_filhos'] . "," . $this -> CoresMenu();

			foreach ($this -> array_cursos as $key => $row) {
				if ($row['pai'] == $rowPai['pai_id']) {
					// Verifica se o filho do pai contêm filhos também
					$id = $row['qtd_filhos'] > 0 ? $row['pai_id'] : 0;
					$strm .= "0," . $id . ",'" . $row['nome'] . "','" . $row['nome'] . "','$CFG->wwwroot/mod/resource/view.php?id=" . $row['id'] . "','','','',0,0,";
				}
			}
		}
			
		return $this->HtmlBlocoMenu("conteudos","Conteúdos",substr($strm, 0, strlen($strm) - 1) . '];');
	}

	/**
	 * @method ImprimirMenu: Monta o bloco do menu principal
	 */
	function ImprimirMenu() {
		global $USER, $CFG, $COURSE;

		//$this -> LimparCache();
		$menu = $this -> GetMenuCache();
		
		if($menu == ""){
			//Atualiza o arquivo js para criar os blocos de menus
			require_once ("menu_js.php");			
			new MenuJs(3);
			
			//Monta os blocos de cada menu
			$menu = $this->BlocoConteudos(2)
			  	   .$this->BlocoCursos()
			  	   .$this->BlocoCooperacao();
				   
			//Salva o código gerado na tabela de cache do menu
			$this -> SetMenuCache($menu);			 
		}
		return $menu;
	}
}
?>