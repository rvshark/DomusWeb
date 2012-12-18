<div id="formulario" style="text-align: left"></div>
<?php 

   include 'formulario.php'
 ?>

<script>
    form = new Ext.FormPanel({
        title:'Topico',
        renderTo:'formulario',
        frame:true,
        width:650,
        height:450,
        items:formularioCampos,
        buttons:[{
                text:'Alterar',
                handler: function(){
                    form.getEl().mask('Enviando dados', 'x-mask-loading');
                    form.getForm().submit({
                        url:'<?php echo MainController::$caminho ?>',
                        success: function(form,response){
                            facadeTopico.store.reload(response.result.data.id);
                            windowTopico.close();
                            
                            form.getEl().unmask();
                        },
                        error:function(response,action){
                            for(erro in  action.result.errors){
                                Ext.MessageBox.show({title:'Aviso',msg:action.result.errors[erro],icon:Ext.MessageBox.ERROR});
                            }
                            formTopico.getEl().unmask();
                        },
                        params:{'topico[id]':<?php echo $controlador->topico->id ?>,controller:'topico',action:'alterar'} 
                        
                    });
                    
                }
            
        },{text:'Fechar',handler:function(){
            windowTopico.close();
        } }]
    });
    
    form.getForm().setValues(<?php echo $controlador->topico_json ?>)
</script>    