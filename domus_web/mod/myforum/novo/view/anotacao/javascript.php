<script>
/**
 * Reune todos os javascripts relacionados a anotação
 */

function FacadeAnotacao(){
    
   
    
    /**
     * Salva o bloco de anotações
     */
    this.alterar = function (text){
        
        temaId = temaSelecionado.id;
        
        Ext.getCmp('anotacaoTab').body.mask('Salvando','x-mask-loading');
        
        Ext.Ajax.request({
                   url: '<?php echo MainController::$caminho ?>',
                   success: function(){
                       Ext.getCmp('anotacaoTab').body.unmask();
                       Ext.MessageBox.show({
                           title: 'Aviso',
                           msg: 'Anotação alterada com sucesso.',
                           buttons: Ext.MessageBox.OK,
                           icon: Ext.MessageBox.INFO
                       });
                   },
                   failure: function(){
                       Ext.getCmp('anotacaoTab').body.unmask();
                       Ext.MessageBox.show({
                           title: 'Aviso',
                           msg: 'Este conceito já está relacionado com o tópico informado!',
                           buttons: Ext.MessageBox.OK,
                           icon: Ext.MessageBox.ERROR
                       });
                   },
                   params: { controller: 'anotacao', action: 'alterar','tema[id]':temaId, 'anotacao[text]':text} 
                });
          
     };
        
     
    
    
    
    
   
                        
           
         
    
}

facadeAnotacao = new FacadeAnotacao();


</script>