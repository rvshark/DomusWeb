jQuery(document).ready(function() {
	jQuery('#excRegistro').dialog({
		"resizable" : false,
		"closeText" : "Fechar",
		"title" : "Excluir usuário",
		"modal" : true,
		"stack" : false,
		"autoOpen" : false,
		"draggable" : false,
		open : function() {
			$('body').css('overflow', 'hidden');
		},
		close : function() {
			$('body').css('overflow', 'auto');
		}
	}).dialog('option', 'buttons', [{
		text : "OK",
		click : function() {
		}
	}, {
		text : "Cancelar",
		click : function() {
			$(this).dialog('close');
		}
	}]);
});
</script>