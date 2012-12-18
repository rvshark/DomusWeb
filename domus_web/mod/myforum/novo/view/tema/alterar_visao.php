<div id="formulario" style="text-align: left"></div>
<?php 

   include 'formulario.php'
 ?>

<script>
    form = new Ext.FormPanel({
        title:'Tema',
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
                        success: function(basicForm,response){
                            facadeTema.store.reload(response.result.data.id);
                            windowTema.close();
                            form.getEl().unmask();
                        },
                        failure:function(response,action){
                            for(erro in  action.result.errors){
                                Ext.MessageBox.show({title:'Aviso',msg:action.result.errors[erro],icon:Ext.MessageBox.ERROR});
                            }
                            form.getEl().unmask();
                        },
                        params:{'tema[id]':<?php echo $controlador->tema->id ?>,controller:'tema',action:'alterar'} 
                        
                    });
                    
                }
            
        },{text:'Fechar',handler:function(){
            windowTema.close();
        } }]
    });
    
    form.getForm().setValues(<?php echo $controlador->tema_json ?>)
</script>    