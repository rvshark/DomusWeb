<!-- The menu can be adjusted, just add or delete the following ul items based on your own needs -->


	<script type="text/javascript">

	function TestaCPF(cpf) {

	    cpf = cpf.replace(/[^\d]+/g,'');

	    if(cpf == '') return false;

	    // Elimina CPFs invalidos conhecidos
	    if (cpf.length != 11 || 
	        cpf == "00000000000" || 
	        cpf == "11111111111" || 
	        cpf == "22222222222" || 
	        cpf == "33333333333" || 
	        cpf == "44444444444" || 
	        cpf == "55555555555" || 
	        cpf == "66666666666" || 
	        cpf == "77777777777" || 
	        cpf == "88888888888" || 
	        cpf == "99999999999")
	        return false;

	    // Valida 1o digito
	    add = 0;
	    for (i=0; i < 9; i ++)
	        add += parseInt(cpf.charAt(i)) * (10 - i);
	    rev = 11 - (add % 11);
	    if (rev == 10 || rev == 11)
	        rev = 0;
	    if (rev != parseInt(cpf.charAt(9)))
	        return false;

	    // Valida 2o digito
	    add = 0;
	    for (i = 0; i < 10; i ++)
	        add += parseInt(cpf.charAt(i)) * (11 - i);
	    rev = 11 - (add % 11);
	    if (rev == 10 || rev == 11)
	        rev = 0;
	    if (rev != parseInt(cpf.charAt(10)))
	        return false;

	    return true;

	}
	
	function carregaForm(Txtemail){
	$.ajax({
		type:"POST",
		dataType: "json",
		url:"<?php $CFG->wwwroot ?>theme/powerdomus/formAjax.php",
		data: {email: Txtemail},
		cache: false,  				
		success: function(data){  		



				$("#txtNome").val(data.nome);
				$("#cpf").val(data.cpf);
				if(data.cidades_go){
				carregaCidade(data.estados_go,data.cidades_go);
			    }
			    $("#estados_go").val(data.estados_go);
				$("#txtPais").val(data.pais);
				$("#txtTelefone").val(data.telefone);
				$("#txtInstituicao").val(data.instituicao);					
               return true;

		}
	});
	}
	
		function carregaCidade(estado,cidade){
			if(cidade > 0 ){
			
				   if(document.getElementById('cidade_div_html') != null)
				{
				   
			  
					$.ajax({
						type:"POST",
						dataType: "json",
						url:"../../lib/cidades.php?search=",
						data: {id_estado: estado},
						cache: false,  				
						success: function(j){  		

							var options = '';	

							for (var i = 0; i < j.length; i++) {
								if(j[i].id_cidade == cidade){
					options += '<option value="'+j[i].id_cidade+'" selected="selected">' + j[i].nome + '</option>';
								}

							}
						   
								$('#carregando_cidade').hide();
								$("#cidades_go").html(options);


								$('#cidades_go').show();

						}

					});
				
				
			}
				}
			

		}


	    $(document).ready(function(){

	       //valida cpf Guilherme T. 20/03/2013
	   

		$('#cpf').bind('blur', function(){
		   $('#cpf').removeClass('error');
		});
		$('#cpf').bind('focus', function(){
		  $('#cpf').addClass('error');
		});
		$('#txtEmail').click(function(){
			if( $(this).val() ) {
			carregaForm($(this).val());
			}
		});
		carregaForm($('#txtEmail').val());
	
	   
	
			$('#estados_go').change(function(){
				if( $(this).val() ) {

	            $('#cidades_go').hide();
	              $('#carregando_cidade').show();
				$.ajax({
					type:"POST",
					dataType: "json",
					url:"../../lib/cidades.php?search=",
					data: {id_estado: $(this).val()},
					cache: false,  				
					success: function(j){  		

						var options = '';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].id_cidade + '">' + j[i].nome + '</option>';
						}
						 $('#carregando_cidade').hide();
						$('#cidades_go').html(options).show();
					}

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
	    $('#cpf').mask('999.999.999-99');
    	
  		//Dialogo com o formulário de preenchimento para download do arquivo
  		$('#formDownload').dialog({
			autoOpen: false,
	        modal: true,
	        draggable: false,
	        closeOnEscape: false,
	        resizable: false,
	        position: 'center',
	        width: 500,
	        title: 'Cadastro Solicitação Domus',
	        open: function(){ 
	        	inicializaCampos();	
	        	carregarCampos("");
	
	           
	          
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
             	"cpf": { required:true },
	            "txtInstituicao" : { required:true },
	            "cidades_go" : { required:true },
	            "estados_go" : { required:true },
	            "txtPais" : { required:true }                 
	        }
	    });
	});
	
	//Envia o formulário para a para gravação e download do arquivo
	function submitForm(){
	
		if(parseInt('<?php echo $USER->id ?>') > 0){
				if(carregarCampos($('#txtEmail').val()) && $('#formCadDownload').validate().form()){			
		  			_gaq.push(['_setAccount','UA-27676049-1']);
					_gaq.push(['_trackPageview','/util/index.php?acao=download&arquivo=' + $('#arquivo').val()]);					
					$('#formCadDownload').submit();		
					$('#formDownload').dialog('close');
				}	
			
		}else{
		if(TestaCPF($('#cpf').val())){
		if(carregarCampos($('#txtEmail').val()) && $('#formCadDownload').validate().form()){			
  			_gaq.push(['_setAccount','UA-27676049-1']);
			_gaq.push(['_trackPageview','/util/index.php?acao=download&arquivo=' + $('#arquivo').val()]);					
			$('#formCadDownload').submit();		
			$('#formDownload').dialog('close');
		}
		
		}else{
		    if($('#cpf').val() != ''){
			alert('CPF Inválido');
			
			$('#cpf').focus();

		    $('#trNome,#trTelefone,#trCPF,#trCidade,#trPais,#trInstituicao,#trEstado').show();
		  }else{
		if($('#formCadDownload').validate().form()){
		 	alert('CPF necessário');	
	    	$('#cpf').focus();
		}	
		  }
		}
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
					$('#trNome,#trTelefone,#trCPF,#trCidade,#trPais,#trInstituicao,#trEstado').show();		
					
					return false;		
				}
				else{					
					$('#verificarEmail').val('false');
					$("#txtNome").val(data.nome);
					$("#cpf").val(data.cpf);
					if(data.cidades_go){
					carregaCidade(data.estados_go,data.cidades_go);
				    }
					$("#estados_go").val(data.estados_go);
				    
				    $("#txtEmail").val(data.email);
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
	   // $('#trNome,#trTelefone,#trCPF,#trCidade,#trPais,#trInstituicao,#trEstado').hide();
		//$("#txtNome,#txtTelefone,#txtInstituicao").val('');
		//$('#txtPais').val(0);  			
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
				<tr id='trCPF'>
					<td style="text-align: right;width: 8%">CPF*:</td>
					<td style="text-align: left;width: 92%"><input type="text" style="width:94%" id="cpf" name="cpf"></td>
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
					<td style="text-align: right;width: 8%">Estado*:</td>
					<td style="text-align: left;width: 92%">
					<div id="div_estado_append"><div id="div_estado_html">
					<select name='estados_go' id='estados_go'>
					<option value="">-- Selecione o estado --</option>
					<option value="1">Acre</option>
					<option value="2">Alagoas</option>
					<option value="4">Amapá</option>
					<option value="3">Amazonas</option>
					<option value="5">Bahia</option>
					<option value="6">Ceará</option>
					<option value="7">Destrito Federal</option>
					<option value="8">Espírito Santo</option>
					<option value="9">Goiás</option>
					<option value="10">Maranhão</option>
					<option value="13">Mato Grosso</option>
					<option value="12">Mato Grosso do Sul</option>
					<option value="11">Minas Gerais</option>
					<option value="14">Pará</option>
					<option value="15">Paraíba</option>
					<option value="18">Paraná</option>
					<option value="16">Pernambuco</option>
					<option value="17">Piauí</option>
					<option value="19">Rio de Janeiro</option>
					<option value="20">Rio Grande do Norte</option>
					<option value="23">Rio Grandre do Sul</option>
					<option value="21">Rondônia</option>
					<option value="22">Rorâima</option>
					<option value="24">Santa Catarina</option>
					<option value="26">São Paulo</option>
					<option value="25">Sergipe</option>
					<option value="27">Tocantins</option>
					</select>
					</div></div>
					</td>
				</tr>
			<tr id='trCidade'>
				<td style="text-align: right;width: 8%">Cidade*:</td>
				<td style="text-align: left;width: 92%"><div id="carregando_cidade" style="display:none;">Carregando..</div><div id="cidade_div_append"><div id="cidade_div_html"><select name='cidades_go'  id='cidades_go'>
			    <option value=''>-- Escolha uma cidade --</option>
				</select></div></div></td>
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
			<li>
		<a href="javascript:void(0)" onclick="ShowVideoF4V('/apresentacao/Domus Procel Edifica_20-03_v1_002.f4v  ','Plataforma de Disseminação');">Plataforma de Disseminação</a></a>
			</li>
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


