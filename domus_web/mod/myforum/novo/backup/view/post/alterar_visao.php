<div id="formulario" style="text-align: left"></div>
<?php 

   include 'formulario.php'
 ?>

<script>
    form = new Ext.FormPanel({
        title:'Comentário',
        renderTo:'formulario',
        frame:true,
        fileUpload: true,
        width:650,
        height:450,
        items:formularioCampos,
        buttons:[{
                text:'Alterar',
                handler: function(){
                    form.getEl().mask('Enviando dados', 'x-mask-loading');
                   
                   
                    upload = facadePost.campoAttachment().getValue() != '<?php echo $controlador->post->attachment ?>'
                    
                    
                    form.getForm().submit({
                        url:'<?php echo MainController::$caminho ?>',
                      success: function(basicForm,response){
                            
                            facadePost.store.reload(response.result.data.id);
                            windowPost.close();
                            form.getEl().unmask();
                            
                            //facadePost.irParaPost(postId);
                        },
                        failure:function(response,action){
                            for(erro in  action.result.errors){
                                Ext.MessageBox.show({title:'Aviso',msg:action.result.errors[erro],icon:Ext.MessageBox.ERROR});
                            }
                            form.getEl().unmask();
                        },
                        params:{'post[id]':<?php echo $controlador->post->id ?>,controller:'post',action:'alterar','upload':upload} 
                        
                    });
                    
                }
            
        },{text:'Fechar',handler:function(){
            windowPost.close();
        } }]
    });
    
    form.getForm().setValues(<?php echo $controlador->post_json ?>)
</script>    