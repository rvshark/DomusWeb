<div id="formulario" style="text-align: left"></div>
<?php 

   include 'formulario.php'
 ?>

<script>
    form = new Ext.FormPanel({
        title:'Conceito',
        renderTo:'formulario',
        frame:true,
        width:550,
        height:450,
        items:formularioCampos,
        buttons:[{
                text:'Alterar',
                handler: function(){
                    form.getEl().mask('Enviando dados', 'x-mask-loading');
                    form.getForm().submit({
                        url:'<?php echo MainController::$caminho ?>',
                        success: function(response,action){
                            facadeConceito.store.reload();
                            windowConceito.close();
                            form.getEl().unmask();
                        },
                        failure:function(response,action){
                            for(erro in  action.result.errors){
                                Ext.MessageBox.show({title:'Aviso',msg:action.result.errors[erro],icon:Ext.MessageBox.ERROR});
                            }
                            form.getEl().unmask();
                        },

                        params:{'conceito[id]':<?php echo $controlador->conceito->id ?>,controller:'conceito',action:'alterar'} 
                        
                    });
                    
                }
            
        },{text:'Fechar',handler:function(){
            windowConceito.close();
        } }]
    });
    
    form.getForm().setValues(<?php echo $controlador->conceito_json ?>)
</script>    