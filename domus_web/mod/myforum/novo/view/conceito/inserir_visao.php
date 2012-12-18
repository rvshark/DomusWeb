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
                text:'Incluir',
                handler: function(){
                    form.getEl().mask('Enviando dados', 'x-mask-loading');
                    form.getForm().submit({
                        url:'<?php echo MainController::$caminho ?>',
                        success: function(response){
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
                        params:{'topico[id]':<?php echo $controlador->topico->id ?>,controller:'conceito',action:'inserir'} 
                        
                    });
                    
                }
            
        },{text:'Fechar',handler:function(){
            windowConceito.close();
        } }]
    });
</script>    