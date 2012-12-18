<script>
    formularioCampos =  [{
                fieldLabel:'Assunto',
                name:'topico[name]',
                width:500,
                xtype:'textfield'
        }, new Ext.ux.form.FileUploadField({
                width: 400,
                fieldLabel:"Arquivo",
                name:'attachment'}),{
                fieldLabel:'Descrição',
                xtype:'label'
        },new Ext.ux.form.FCKeditor({
                fieldLabel:'Descrição',
                hideLabel:true,
                id:'testando',
                name:'post[message]',
                xtype:'fckeditor',
                toolbarSet:'Aluno',
                BasePath:'<?php echo "$CFG->wwwroot/lib/editor/fckeditor/"?>'
        },{
            height:'300px',
            killWordOnPaste:true,
            toolbarSet:'Aluno',
            BasePath:'<?php echo "$CFG->wwwroot/lib/editor/fckeditor/"?>',
            fontname: {
                "Trebuchet":	'Trebuchet MS,Verdana,Arial,Helvetica,sans-serif',
                "Arial":	'arial,helvetica,sans-serif',
                "Courier New":	'courier new,courier,monospace',
                "Georgia":	'georgia,times new roman,times,serif',
                "Tahoma":	'tahoma,arial,helvetica,sans-serif',
                "Times New Roman":	'times new roman,times,serif',
                "Verdana":	'verdana,arial,helvetica,sans-serif',
                "Impact":	'impact',
                "Wingdings":	'wingdings'
            }
        })];
</script>    