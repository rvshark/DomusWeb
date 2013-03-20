<!-- The menu can be adjusted, just add or delete the following ul items based on your own needs -->


	<script type="text/javascript">

	$(function(){
	$.getJSON('../../lib/estados.php?search=',{estados: 2013, ajax: 'true'}, function(j){
					var options = '<option value=""></option>';	
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].id_estado + '">' + j[i].nome_estado + '</option>';
					}	
					$('#estados_go').html(options).show();

	});
	});
	    $(document).ready(function(){

	       //Cidades-estados Guilherme T. 20/03/2013
		function carregaEstados(){
			$.getJSON('../../lib/estados.php?search=',{estados: 2013, ajax: 'true'}, function(j){
							var options = '<option value=""></option>';	
							for (var i = 0; i < j.length; i++) {
								options += '<option value="' + j[i].id_estado + '">' + j[i].nome_estado + '</option>';
							}	
							$('#estados_go').html(options).show();

			});
		
		
		}
 		$('#estados_go').live('click',function(){
		   
				if( $(this).val() ) {


					$.getJSON('../../lib/cidades.php?search=',{id_estado: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].id_cidade + '">' + j[i].nome + '</option>';
						}	
						$('#cidades_go').html(options).show();

					});
				} else {
					$('#cidades_go').html('<option value="">– Escolha uma cidade –</option>');
				}
		});
		
		$('#estados_go').change(function(){
			if( $(this).val() ) {


				$.getJSON('../../lib/cidades.php?search=',{id_estado: $(this).val(), ajax: 'true'}, function(j){
					var options = '<option value=""></option>';	
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].id_cidade + '">' + j[i].nome + '</option>';
					}	
					$('#cidades_go').html(options).show();

				});
			} else {
				$('#cidades_go').html('<option value="">– Escolha uma cidade –</option>');
			}
		});

    	//Inicio - Monta o menu horizontal --------------------
		$("#nav li").hover(
			function(){ $("ul", this).fadeIn("fast"); }, 
			function() { } 
		);
		
		//if (document.all) {
		//	$("#nav li").hoverClass ("sfHover");
		//}
	    
	  
		$.fn.hoverClass = function(c) {
			return this.each(function(){
				$(this).hover( 
					function() { $(this).addClass(c);  },
					function() { $(this).removeClass(c); }
				);
			});
		};	
		//Fim - Monta o menu horizontal -----------------------
    	
    	
    	$('#txtTelefone').mask('(99) 9999-9999');
    	
  		//Dialogo com o formulário de preenchimento para download do arquivo
  		$('#formDownload').dialog({
			autoOpen: false,
	        modal: true,
	        draggable: false,
	        closeOnEscape: false,
	        resizable: false,
	        position: 'center',
	        width: 450,
	        title: 'Cadastro Solicitação Domus',
	        open: function(){ 
	        	inicializaCampos();	
	        	carregarCampos("");
	            carregaEstados();
	        },                        
	        buttons: {
				"Ok": function() {
			  		submitForm();
				}, 
				"Cancelar": function() { 
					$(this).dialog("close"); 
				} 
			}
		});
		
		$('#divVideo').dialog({
			autoOpen: false,
	        modal: true,
	        draggable: false,
	        closeOnEscape: false,
	        resizable: false,
	        position: 'center',
	        width: 890,
	        close: function(){ 
	        	$('#divVideo').html("");
	        },   
	        buttons: { 
				"Fechar": function() { 
					$(this).dialog("close"); 
				} 
			}
		});
		
		//Validação do formulário
		$('#formCadDownload').validate(
	    {
	        invalidHandler: function (e, validator) {
	            var errors = validator.numberOfInvalids();
	            if (errors) {
	                var message = errors == 1
	                ? 'Existe 1 erro no formulário favor verificar!'
	                : 'Existem ' + errors + ' erros no formulário favor verificar!';
	                $("div.error span").html(message);
	                $("div.error").show();
	            } else {
	                $("div.error").hide();
	            }
	        },
	        rules: {
	            "txtNome": { required: true },
	            "txtEmail": { required:true },
	            "txtInstituicao" : { required:true },
	            "txtCidade" : { required:true },
	            "txtPais" : { required:true }                 
	        }
	    });
	});
	
	//Envia o formulário para a para gravação e download do arquivo
	function submitForm(){
		if(carregarCampos($('#txtEmail').val()) && $('#formCadDownload').validate().form()){			
  			_gaq.push(['_setAccount','UA-27676049-1']);
			_gaq.push(['_trackPageview','/util/index.php?acao=download&arquivo=' + $('#arquivo').val()]);					
			$('#formCadDownload').submit();		
			$('#formDownload').dialog('close');
		}
	}
	
	//Busca os dados do usuário para verificar se já é cadastrado na base
	function carregarCampos(strEmail){
		
		
		if($('#verificarEmail').val() == 'false')
			return true;
				
		$('#verificarEmail').val('false');
		
		$.ajax({
			type:"POST",
			dataType: "json",
			url:"<?php $CFG->wwwroot ?>theme/powerdomus/formAjax.php",
			data: {email: strEmail},
			cache: false,  				
			success: function(data){  		
							  					
				if(strEmail != '' && data.email == '')
				{					
					alert('E-mail não cadastrado, favor preencher os campos do formulário!')
						
					inicializaCampos();
					$('#trNome,#trTelefone,#trCidade,#trPais,#trInstituicao,#trEstado').show();		
					
					return false;		
				}
				else{					
					$('#verificarEmail').val('false');
					$("#txtNome").val(data.nome);
					$("#txtEmail").val(data.email);
					$("#txtCidade").val(data.cidade);
					$("#txtPais").val(data.pais);
					$("#txtTelefone").val(data.telefone);
					$("#txtInstituicao").val(data.instituicao);					
					
					return true;
				}									
			}
		});		
		
		//Quando o campo email é alterado a verificação de email deve ser feita novamente
		$('#txtEmail').keypress(function(){$('#verificarEmail').val('true')})	
		
		//Quando o campo email perde o focus ele realiza a consulta novamente
		$('#txtEmail').blur(function(){ carregarCampos($(this).val())});
	}
	
	//Iniciliza os campos do formulário
	function inicializaCampos(){
		$('#trNome,#trTelefone,#trCidade,#trPais,#trInstituicao,#trEstado').hide();
		$("#txtNome,#txtTelefone,#txtInstituicao").val('');
		$('#txtPais').val(0);  			
	}
	
	function ShowVideo(id_video, titulo)
	{
		var iframe = '<iframe width="853" height="480" src="http://www.youtube.com/embed/' + id_video + '" frameborder="0" allowfullscreen></iframe>';
		
		$('#divVideo').html(iframe);
		if(titulo == 'Trailer08032013'){
			titulo = 'Trailer de vídeo-aula';
		}		
		$('#divVideo').dialog("option","title",titulo).dialog('open'); 
		
	}
	
	
	function ShowVideoF4V(link, titulo)
	{
		
		var iframe = '<iframe width="853" height="480" src="/mapa_r/videos/engine/swf/player.swf?url=' + link + '&volume=100" frameborder="0" allowfullscreen></iframe>';
		
		$('#divVideo').html(iframe);
		
		$('#divVideo').dialog("option","title",titulo).dialog('open'); 
		
	}
	
	
	//Ações do menu horizontal
	function historico(){  //17-12-2012 13:00 -- Guilherme Trevisan de Oliveira
			window.open("<?php echo $CFG->wwwroot."/download/"; ?>historico.html","_blank");
	}
	
        function arquivo_climatico(){  //17-12-2012 13:00 -- Guilherme Trevisan de Oliveira
                        window.open("<?php echo $CFG->wwwroot."/download/"; ?>Domus-ClimasExt.exe","_blank");
        }
	function avaliacao(){  //07-01-2012 16:00 -- Guilherme Trevisan de Oliveira
			window.open("<?php echo $CFG->wwwroot."/download/"; ?>primeira_avaliacao_do_domus-procel_edifica.pdf","_blank");
	}
	function Acao(name, arquivo)
	{
		if(name == 'download')
		{
			if(arquivo == 'domus.exe' || arquivo == 'domus-release.exe'){				 
            	
            	$('#arquivo').val(arquivo);
				
				if(parseInt('<?php echo $USER->id ?>') > 0){
					$('#txtNome').val('<?php echo $USER->username . ' ' .$USER->lastname ?>');
					$('#txtEmail').val('<?php echo $USER->email ?>');
					$('#txtCidade').val('<?php echo $USER->city ?>');
					$('#txtPais').val('<?php echo $USER->country ?>');
					$('#txtInstituicao').val('Domus');
					$('#arquivo').val(arquivo);
					$('#verificarEmail').val('false');
					submitForm();					
				}	
				else									
					$('#formDownload').dialog('open');				
			}
							
		}
		else if(name != '')
		{
			window.open("<?php echo $CFG->wwwroot ?>/util/index.php?acao=" + name + "&arquivo=" + arquivo,"_blank");
			_gaq.push(['_setAccount', 'UA-27676049-1']);
			_gaq.push(['_trackPageview', "<?php echo $CFG->wwwroot ?>/util/index.php?acao=" + name + "&arquivo=" + arquivo]);			
		}
		else
		{
			alert('Ação indisponível no momento');
		}
	}	
		
</script>
	
<div id="formDownload" style="display: none">
	<form action="<?php echo $CFG->wwwroot ?>/util/index.php?acao=download" method="post" id="formCadDownload">
		<table style="width: 100%">			
			<tr>
				<td style="text-align: right;width: 8%">Email*:</td>
				<td style="text-align: left;width: 92%"><input type="text" style="width:94%" id="txtEmail" class="textBox email" name="txtEmail"></td>
			</tr>
			<tr id='trNome'>
				<td style="text-align: right;width: 8%">Nome Completo*:</td>
				<td style="text-align: left;width: 92%"><input type="text" style="width:94%" id="txtNome" name="txtNome"></td>
			</tr>
			<tr id='trTelefone'>
				<td style="text-align: right;width: 8%">Telefone:</td>
				<td style="text-align: left;width: 92%"><input type="text" style="width:50%" id="txtTelefone" name="txtTelefone"></td>
			</tr>
			<tr id='trInstituicao'>
				<td style="text-align: right;width: 8%">Instituição*:</td>
				<td style="text-align: left;width: 92%"><input type="text" style="width:94%" id="txtInstituicao" name="txtInstituicao"></td>
			</tr>
				<tr id='trEstado'>
					<td style="text-align: right;width: 8%">Estado:</td>
					<td style="text-align: left;width: 92%">
					 <select name='estados_go' id='estados_go'>
						<option value=''>-- Escolha um estado --</option></select>
					</td>
				</tr>
			<tr id='trCidade'>
				<td style="text-align: right;width: 8%">Cidade:</td>
				<td style="text-align: left;width: 92%"><select name='cidades_go'  id='cidades_go'>
			    <option value=''>-- Escolha uma cidade --</option>
				</select></td>
			</tr>
			
			
			<tr id='trPais'>
				<td style="text-align: right;width: 8%">País*:</td>
				<td style="text-align: left;width: 92%">
					<select id="txtPais" name="txtPais" style="width:95%" >
						<option value="">Selecione</option>
						<?php foreach (get_list_of_countries() as $key => $value): 
								echo '<option value="'.$key.'">'.$value.'</option>';
						     endforeach 
						     ?>
					</select>					
				</td>
			</tr>			
			<tr>
				<td colspan="2" style="text-align: right;width: 100%;height: 20px;">
					<div style="position: absolute; bottom: 0">
					<font size="2"><font size="2" color="#FF0000">*</font>Campos obrigatórios</font>
					</div>			
				</td>		
			</tr>	
		</table>
		<input type="hidden" value="true" id="verificarEmail" name="verificarEmail" />
		<input type="hidden" id="arquivo" name="arquivo" />
	</form>
</div>
<div id="divVideo"></div>
<ul id="nav">

		<li><a href="<?php echo $CFG->wwwroot .'/' ?>" target="_self">Apresentação</a></li>
	<li><a href="#menu3_t">Download</a>
	<ul>
	<li><a href="javascript:void(0)" onclick="historico();">Histórico de versões</a></li>
	<li><a href="javascript:void(0)" onclick="Acao('download','domus.exe');"><?php echo $CFG->versao_domus_teste ?></a></li>
	<li><a href="#">Vídeos Demonstrativos</a>
	<ul>
		<li><a href="javascript:void(0)" onclick="ShowVideo('lpE7K768D3A','Trailer de Vídeo-Aula');">Trailer de Vídeo-Aula</a></li>
		<li><a href="javascript:void(0)" onclick="ShowVideo('UGvx_OBCZpI','Visão geral do Domus');">Visão geral do Domus</a></li>
	<li><a href="javascript:void(0)" onclick="ShowVideo('3zox9ivMbFM','Desenho de edificação');">Desenho de edificação</a></li>
	<li><a href="javascript:void(0)" onclick="ShowVideo('brGLxqh-BCo','Importando dxf');">Importando dxf</a></li>
	<li><a href="javascript:void(0)" onclick="ShowVideo('lKCbc2JVwuw','Importando idf');">Importando idf</a></li>
	<li><a href="javascript:void(0)" onclick="ShowVideo('XiqrEkfaiJI','Configuração de climatização');">Configuração de climatização</a></li>
		<li><a href="javascript:void(0)" onclick="ShowVideo('Uac08MbIy_4','Método prescritivo');">Método prescritivo</a></li>
			<li><a href="javascript:void(0)" onclick="ShowVideo('KJmLkfeltYU','Método da simulação');">Método da simulação</a></li>
	
	</ul>
	</li>
	
	<li>
		<a href="javascript:void(0)" onclick="arquivo_climatico();">Instalador de Climas (411 cidades)</a>
	</li>

	<li>
<a href="javascript:void(0)" onclick="ShowVideoF4V('/temp/teste.f4v','Teste');">Teste</a></a>
	</li>

	<li>
		<a href="javascript:void(0)" onclick="Acao('pdf','Domus-tutorial.pdf');">Tutorial do Domus</a>
	</li>
	
	
	</ul>
    </li>

<li><a href="#menu3_t">Documentação</a>
	<ul>
    <li><a href="javascript:void(0)" onclick="Acao('pdf','	primeira_avaliacao_do_domus-procel_edifica.pdf');">Avaliação</a></li>
    <li><a href="javascript:void(0)" onclick="Acao('pdf','FAQs.pdf');">Perguntas Frequentes</a></li>
<li><a href="javascript:void(0)" onclick="Acao('pdf','Temas_de_pesquisa.pdf');">Temas de Pesquisa</a></li>
    <li><a href="javascript:void(0)" onclick="Acao('pdf','ORIENTACOES_CONCLUIDAS_ASSOCIADAS_AO_DOMUS.pdf');">Publicações e Orientações</a></li>

<li><a href="#">Validação</a>
			<ul>
<li><a href="javascript:void(0)" onclick="Acao('pdf','01_DOMUS_ASHRAE 1052-RP_.pdf');">ASHRAE 1052-RP</a></li>
<li><a href="javascript:void(0)" onclick="Acao('pdf','02_DOMUS_ANSI ASHRAE Standard 140-2007_Envelope_.pdf');">ASHRAE 140-2007</a></li>
<li><a href="http://jen.sagepub.com/content/30/1/7.full.pdf" target="_blank">Response-factor vs. Finite-volume</a></li>
<li><a href="javascript:void(0)" onclick="Acao('pdf','03_DOMUS_Additional Validations and Verifications_.pdf');">Additional Validation</a></li>

			</ul>
</li>
	<li><a href="javascript:void(0)" onclick="Acao('pdf','Historico_Domus.pdf');">Histórico de Desenvolvimento</a></li>

		</ul>	
		
		</li>


	
	
	<li style="width:150px; height:28px; padding: 3px 0 0 0">
		<form method="post" action="<?php echo $CFG->wwwroot."/files/pesquisa_domus.php"?>">
	<input type='text' name="pesquisa" size=15/><input type="submit" alt='pesquisar' title="pesquisar" value="" id="bot_pesquisa_domus"  />
			</form>
	</li>


</ul>


