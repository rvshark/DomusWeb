<?php
$urlBase = $CFG -> wwwroot . "/mod/resource/view.php?id=";
?>
<div id="modalFiles" title="Gerenciamento de curso" style="display: none">
	<div class="modalOptions">
		<input type="button" id="btnTexto" name="filtroFile" arquivo="doc" title="Textos" />
		<input type="button" id="btnSlide" name="filtroFile" arquivo="ppt" title="Slides" />
		<input type="button" id="btnImagem" name="filtroFile" arquivo="img" title="Imagens" />
		<input type="button" id="btnPdf" name="filtroFile" arquivo="pdf" title="Pdf" />
		<input type="button" id="btnVideo" name="filtroFile" arquivo="video" title="Videos" />
		<input type="button" id="btnAtividade" title="Atividade" />
		<input type="button" id="btnForum" title="Fórum de problemas" />
		<input type="button" id="btnTarefa" title="Tarefa" />
		<input type="hidden" id="type" name="type" value="all" />
	</div>
	<div style="text-align: center;">
		<table border="0" style="margin-left:auto;margin-right:auto" width="640">
			<tr>
				<td colspan="2">
				<table border="0" width="640">
					<tr>
						<td align="center" id="tdIframe"></td>
					</tr>
				</table></td>
			</tr>
		</table>
	</div>
</div>
	

<script type="text/javascript">
	$(document).ready(function() {
		$("#modalFiles").dialog({
			autoOpen : false,
			height : 660,
			width : 830,
			modal : true,
			draggable : true,
			closeOnEscape : true,
			resizable : false,
			open : function() {
				//$("body").css("overflow-y", "hidden");
			},
			close : function() {
				//$("body").css("overflow-y", "auto");
			}
		});
	
		$('[name=filtroFile]').click(function(e){
			var arquivo = 'all';
			
			if(!$(this).hasClass('act'))
			{
				$(document).find('[name=filtroFile]').attr('class','');
				arquivo = $(this).attr("arquivo");
				$(this).attr("class","act")	
			}
			else{
				$(document).find('[name=filtroFile]').attr('class','');	
			}
			
			$('[name=ibrowser2]').contents().find('#typeFile').val(arquivo);
			$('[name=ibrowser2]').contents().find('#btnBuscar').click();				
		});
		
		$('#btnAtividade').click(function(){
			window.open($(this).attr("href"))
		});
	});

	function gerenciarArquivos(curso_id,conteudo_id,conteudo) {
		//Retira a classe de botão ativo caso houver
		$(document).find('[name=filtroFile]').attr('class','');
	    	    
	    //Adiciona link externo para a atividade
		$('#btnAtividade').attr("href","<?php echo $urlBase ?>" + conteudo_id)
	
		//Adiciona o iframe com o gerenciador de arquivos da atividade
		$('#tdIframe').html('<iframe scrolling="no"" id="iBrowserFiles" name="ibrowser2" src="<?php echo $CFG->wwwroot ?>/files/gerenciar_arquivos_modal.php?id=' + curso_id + '&conteudo_id=' + conteudo_id + '&type=all&choose=" style=" width:790px; height:570px; border:2px solid gray"></iframe>');
	
		//opcoes do modal do gerenciador de arquivos
		$("#modalFiles").dialog('option','title','Gerenciar Arquivos ' + conteudo);
		$("#modalFiles").dialog('open');
	}
</script>
