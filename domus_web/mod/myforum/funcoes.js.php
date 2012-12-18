<?php
	global $CFG, $USER;
?>
<script src="jdmenu/jquery-1.3.2.js" language="javascript"></script> 
<script src="jdmenu/jquery.jdMenu.js" language="javascript"></script> 
<script src="jdmenu/jquery.dimensions.js" language="javascript"></script> 
<script src="jdmenu/jquery.bgiframe.js" language="javascript"></script>
<script src="jdmenu/jquery.positionBy.js" language="javascript"></script>
<script type="text/javascript">
	function excluir_post(id,post){
		//alert(id+' '+post);
		//return false;
		if (confirm("Deseja realmente Excluir este post?")){
			location.href="<?php echo $CFG->wwwroot?>/mod/myforum/post.php?id="+id+"&acc=delete&post="+post;
			parent.frame_topico.location.reload();
			//parent.location.reload()
		}
	}
	function interromper_post(id,post){
		if (confirm("Deseja realmente interromper este post?")){
			location.href="<?php echo $CFG->wwwroot?>/mod/myforum/post.php?id="+id+"&acc=prune&post="+post;
			parent.frame_topico.location.reload();
		}
	}
	function avaliar(id,post,rate){
		if (rate==""){
			alert("Selecione a nota!");
			return false
		}
		if (confirm("Deseja confirmar?")){
			location.href="<?php echo $CFG->wwwroot?>/mod/myforum/post.php?id="+id+"&acc=rating&post="+post+"&rate="+rate;
			//parent.frame_topico.location.reload();
		}
	}
	
	
</script>