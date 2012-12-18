<?php  // $Id: view.php,v 1.4 2006/08/28 16:41:20 mark-nielsen Exp $


/// (Replace myforum with the name of your module)
    $id = optional_param('id', 0, PARAM_INT); // Course Module ID, or

    if ($id) {
        if (! $cm = get_record("course_modules", "id", $id)) {
            error("Course Module ID was incorrect");
        }
    
        if (! $course = get_record("course", "id", $cm->course)) {
            error("Course is misconfigured");
        }
    
  

    } 
	
	

/// Print the page header
    if ($course->category) {
        $navigation = "<a href=\"../../course/view.php?id=$course->id\">$course->shortname</a> ->";
    } else {
        $navigation = '';
    }

    $strmyforums = get_string("modulenameplural", "myforum");
    $strmyforum  = get_string("modulename", "myforum");

    print_header("$course->shortname: $myforum->name", "$course->fullname",
                 "$navigation <a href=index.php?id=$course->id>$strmyforums</a> -> $myforum->name", 
                  "", "", true, update_module_button($cm->id, $course->id, $strmyforum), 
                  navmenu($course, $cm));



?>
<br>
<script  type="text/javascript" src="../ext/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="../ext/ext-all.js"></script>
<script src='<?php echo $CFG->wwwroot?>/lib/editor/fckeditor/fckeditor.php?id=<?php echo $course->id?>'></script>
<script src='<?php echo $CFG->wwwroot?>/lib/editor/fckeditor/editor/dialog/fck_image/fck_image.js?id=<?php echo $course->id?>'></script>
<script type="text/javascript" src="../ext/examples/ux/FCKeditor.js"></script>
<script type="text/javascript" src="../ext/examples/ux/fileuploadfield/FileUploadField.js"></script>
<script type="text/javascript" src="../ext/src/locale/ext-lang-pt_BR.js"></script>
<script type="text/javascript" src="../ext/examples/ux/Spinner.js"></script>
<script type="text/javascript" src="../ext/examples/ux/SpinnerField.js"></script>
<script type="text/javascript" src="../ext/examples/ux/SearchField.js"></script>

<style>
    
.blackboard_16{background-image:url(../images/16/blackboard.png) !important; }   
.books_16{background-image:url(../images/16/books.png) !important; }   
.dictionary_16{background-image:url(../images/16/dictionary.png) !important; }   
.question_and_answer_16{background-image:url(../images/16/question_and_answer.png) !important; }   
.add2_16{background-image:url(../images/16/add2.png) !important; }   
.bookmark_16{background-image:url(../images/16/bookmark.png) !important; }   
.toolbox_16{background-image:url(../images/16/toolbox.png) !important; }   
.document_edit_16{background-image:url(../images/16/document_edit.png) !important; }   
.disk_blue_16{background-image:url(../images/16/disk_blue.png) !important; }   
.edit_16{background-image:url(../images/16/edit.png) !important; }   
.delete2_16{background-image:url(../images/16/delete2.png) !important; }   
.telescope_16{background-image:url(../images/16/telescope.png) !important; }   
.index_16{background-image:url(../images/16/index.png) !important; }   
.receiver2_16{background-image:url(../images/16/receiver2.png) !important; }   
.find_text_16{background-image:url(../images/16/find_text.png) !important; }   
.graph_edge_directed_16{background-image:url(../images/16/graph_edge_directed.png) !important; }   
.photo_scenery_16{background-image:url(../images/16/photo_scenery.png) !important; }   
.document_16{background-image:url(../images/16/document.png) !important; }   
.film_16{background-image:url(../images/16/film.png) !important; }   


    

.search-item {
    font:normal 11px tahoma, arial, helvetica, sans-serif;
    padding:3px 10px 3px 10px;
    border:1px solid #fff;
    border-bottom:1px solid #eeeeee;
    white-space:normal;
    color:#555;
}

.search-item p {

    padding-left:10px ;
    padding-top:5px ;
    padding-bottom:5px ;
}

.search-item h3 {
    display:block;
    font:inherit;
    font-weight:bold;
    color:#222;
}

.search-item h3 span {
    float: right;
    font-weight:normal;
    margin:0 0 5px 5px;
    width:100px;
    display:block;
    clear:none;
}

.x-view-over{
    border:1px solid #dddddd;
    background: #efefef url(../../resources/images/default/grid/row-over.gif) repeat-x left top;
    font:normal 11px tahoma, arial, helvetica, sans-serif;
    padding:3px 10px 3px 10px;
    border:1px solid #fff;
    border-bottom:1px solid #eeeeee;
    white-space:normal;
    color:#555;
    cursor:pointer;
}
    

body{
    text-align: left;
}
</style>

<?php  print_footer($course); ?>
<link rel='stylesheet' type="text/css" href="../ext/resources/css/ext-all.css">
<link rel="stylesheet" type="text/css" title="gray" href="../ext/resources/css/xtheme-gray.css" />
<link rel="stylesheet" type="text/css" title="gray" href="../ext/resources/css/xtheme-gray.css" />
<link rel="stylesheet" type="text/css" title="gray" href="../ext/examples/ux/fileuploadfield/css/fileuploadfield.css" />
<link rel="stylesheet" type="text/css" title="gray" href="../ext/examples/ux/css/Spinner.css" />


<?php include '../view/conceito/javascript.php' ?>
<?php include '../view/bibliografia/javascript.php' ?>
<?php include '../view/anotacao/javascript.php' ?>
<?php include '../view/post/javascript.php' ?>
<?php include '../view/topico/javascript.php' ?>
<?php include '../view/tema/javascript.php' ?>

<script>






  
    


 
                     


                        
    
function initializeDropZone(g) {
        g.dropZone = new Ext.dd.DropZone(g.getView().scroller, {

//      If the mouse is over a target node, return that node. This is
//      provided as the "target" parameter in all "onNodeXXXX" node event handling functions
        getTargetFromEvent: function(e) {
            return e.getTarget('.x-grid3-row-table');
        },

//      On entry into a target node, highlight that node.
        onNodeEnter : function(target, dd, e, data){ 
            Ext.fly(target).addClass('.x-view-over');
        },

//      On exit from a target node, unhighlight that node.
        onNodeOut : function(target, dd, e, data){ 
            Ext.fly(target).removeClass('.x-view-over');
        },

//      While over a target node, return the default drop allowed class which
//      places a "tick" icon into the drag proxy.
        onNodeOver : function(target, dd, e, data){ 
            return Ext.dd.DropZone.prototype.dropAllowed;
        },

//      On node drop, we can interrogate the target node to find the underlying
//      application object that is the real target of the dragged data.
//      In this case, it is a Record in the GridPanel's Store.
//      We can use the data set up by the DragZone's getDragData method to read
//      any data we decided to attach.
        onNodeDrop : function(target, dd, e, data){
            var rowIndex = g.getView().findRowIndex(target);
            var h = g.getStore().getAt(rowIndex);
            
            var targetEl = Ext.get(target);
            
            

            //Ext.Msg.alert('Relacionando conceitos', 'Dropped patient ' + data.patientData.name + ' on hospital ' + h.data.name);
            
            var params = {}
            if (data.data.tipo == 'conceito'){
              params =    { controller: 'conceito', action: 'relacionar_novo_topico','topico[id]':h.id, 'conceito[id]':data.data.id }
            
            }else if(data.data.tipo == 'bibliografia'){
              params =  { controller: 'bibliografia', action: 'relacionar_novo_topico','topico[id]':h.id, 'bibliografia[id]':data.data.id } 
            } 
            Ext.Ajax.request({
                   url: '<?php echo MainController::$caminho ?>',
                   success: function(){
                       Ext.MessageBox.show({
                           title: 'Aviso',
                           msg: 'Relacionamento criado com sucesso!',
                           buttons: Ext.MessageBox.OK,
                           icon: Ext.MessageBox.INFO
                       });
                       
                   },
                   failure: function(){
                       Ext.MessageBox.show({
                           title: 'Aviso',
                           msg: 'Este conceito já está relacionado com o tópico informado!',
                           buttons: Ext.MessageBox.OK,
                           icon: Ext.MessageBox.ERROR
                       });
                   },
                   params: params
                });
            
            return true;
        }
    });
}    
    
    


  Ext.onReady(function(){
  
  
  Ext.BLANK_IMAGE_URL = '../ext/resources/images/default/s.gif';
  
  
        viewPort = new Ext.Panel({
            renderTo:'container',

            frame:true,
            width:'100%',
            height:600,
            layout:'border',
            items:[{
                    region:'west',
                    layout:'border',
                    id:'acordionId',
                    title:'Temas e Tópicos ',
                    split:true,
                    
                    collapsible: true,
                    width: 220,
                    minSize: 175,                    //xtype:'panel',
                    maxSize: 400,
                      margins:'0 0 0 5',
                      layoutConfig:{
                        animate:true
                      },                    
                    items:[{xtype:'panel',
                            title:'Temas',
                            iconCls:'blackboard_16',
                            region:'center',
                            height:100,
                            split:true,
                            layout:'fit',
                            items:[new Ext.grid.GridPanel({
                                    style:'background:#FFFFFF',                 
                                    multiSelect: false,
                                    id:'gridTemas',
                                    store: facadeTema.store,
                                    frame:true,
                                    reserveScrollOffset: true,
                                    bbar:[{ text:'Adicionar novo tema',
                                            iconCls:'add2_16',
                                            xtype:'splitbutton',
                                            hidden:<?php echo($controlador->usuario->souProfessorEditor()?'false':'true') ?>,
                                            menu:[
                                                {text:'Alterar tema selecionado', style:'font-size:11px',iconCls:'edit_16', handler:function(){
                                                  facadeTema.alterar(temaSelecionado);        
                                                }},
                                                {text:'Excluir tema selecionado', style:'font-size:11px',iconCls:'delete2_16', handler:function(){
                                                    facadeTema.excluir(temaSelecionado);    
                                                } }
                                            ],
                                            handler:function(){
                                                facadeTema.criar(<?php echo $controlador->curso->id?>);
                                            }
                                
                                    }]
                                    
                                    ,listeners: {
                                           rowclick:function(grid,rowIndex,event){
                                               temaSelecionado = grid.getStore().getAt(rowIndex);
                                               facadePost.store.removeAll();
                                               facadeBibliografia.store.removeAll();
                                               facadeConceito.store.removeAll();
                                               facadeTema.trocarTema(temaSelecionado.id);
                                           },
                                           rowdblclick:function(grid,rowIndex,event){
                                               temaSelecionado = grid.getStore().getAt(rowIndex);
                                               facadePost.store.removeAll();
                                               facadeBibliografia.store.removeAll();
                                               facadeConceito.store.removeAll();                                               
                                               facadeTema.trocarTema(temaSelecionado.id);
                                             //  Ext.getCmp('acordionId').layout.setActiveItem(1);
                                           }
                                    },
                                    columns: [{
                                        header: 'id',
                                        dataIndex: 'id',
                                        hidden:true
                                    },{
                                        header: 'Nome',        
                                        width:180,
                                        dataIndex: 'name'
                                    }]
                                })]
                            
                            
                    }
                        
                        ,{xtype:'panel',
                        split:true,
                                    title:'Tópicos',
                                    iconCls:'bookmark_16',
                                     region:'south',
                            layout:'fit',
                           height:280,
                            items:[new Ext.grid.GridPanel({
                                    style:'background:#FFFFFF',                 
                                    multiSelect: false,
                                    id:'gridTopicos',
                                    store: facadeTopico.store,
                                    frame:true,
                                    reserveScrollOffset: true,
                                    bbar:[{ text:'Adicionar novo tópico',
                                            iconCls:'add2_16',
                                            hidden:<?php echo($controlador->usuario->souProfessorEditor()?'false':'true') ?>,
                                            xtype:'splitbutton',
                                            menu:[
                                                    {text:'Alterar tópico selecionado', 
                                                        width:150,
                                                        style:'font-size:11px;', 
                                                        iconCls:'edit_16',
                                                        handler:function(){
                                                	facadeTopico.alterar(topicoSelecionado.id);
                                                    } 
                                                },
                                                    {text:'Excluir tópico selecionado', 
                                                        style:'font-size:11px', 
                                                        iconCls:'delete2_16',
                                                        handler:function(){
                                                        facadeTopico.excluir(topicoSelecionado.data.name,topicoSelecionado.id);
                                                    } 
                                                },
                                                    {text:'Relacionar galeria ao tópico', 
                                                        style:'font-size:11px', 
                                                        iconCls:'graph_edge_directed_16',
                                                        handler:function(){
                                                        facadeTopico.mostrarJanela();
                                                    } 
                                                }
                                            ],
                                            handler:function(){
                                                facadeTopico.criar(temaSelecionado.id);
                                            }
                                
                                    }],
                                    listeners: {
                                           render: initializeDropZone,
                                           rowclick:function(grid,rowIndex,event){
                                               Ext.getCmp('centerPanelId').setActiveTab(1);
                                               topicoSelecionado = grid.getStore().getAt(rowIndex);
                                               facadeConceito.store.reload();
                                               facadeBibliografia.store.reload();
                                               facadePost.store.reload();
                                               facadeTopico.arvore_recurso.reload();
                                               
                                           }
                                    },
                                    columns: [{
                                        header: 'id',
                                        dataIndex: 'id',
                                        hidden:true
                                    },{
                                        header: 'Nome',        
                                        width:180,
                                        dataIndex: 'name'
                                        
                                    }]
                                })]
                          }]
            },{
                title:'',
                region:'center',
                xtype:'tabpanel',
                id:'centerPanelId',
                activeTab: 0,
                bbar:[{
                        xtype:'button',
                        iconCls:'index_16',
                        text:'Arquivo'
                }],
                items:[{ 
                        actived:true,
                        title:'Tema',
                        autoScroll:true,
                        id:'temaTab', 
                        layout:'fit',
                        iconCls:'blackboard_16',
                        html:'',
                        bbar:['->',{iconCls:'edit_16',text:'Alterar tema', handler: function(){
                                facadeTema.alterar(temaSelecionado); 
                        }}]
                        
                },{
                        title:'Discussão',
                        iconCls:'question_and_answer_16',
                        autoScroll:true,
                        id:'postTab',
                        items:[facadePost.dataView],
                        bbar:['->',{iconCls:'add2_16',text:'Adicionar novo comentário.',
                                handler:function(){
                                    facadePost.alterarOuCriar();
                                }
                                
                            }]
                        
                },{
                        title:'Conceito',
                        iconCls:'dictionary_16',
                        id:'conceitoTab',
                        autoScroll:true,
                        items:[facadeConceito.conceitosDataView],
                        tbar:['->',{iconCls:'find_text_16',text:'Pesquisar :'},new Ext.ux.form.SearchField({
                            emptyText:'Filtrar Dados',
                            width:130,
                             onTrigger2Click : function(){
                               facadeConceito.store.filterByWord(this.getValue());
                               this.hasSearch = true;
                               this.triggers[0].show();
                               if(this.getValue().toString().match(/^ *$/g)){
                                   this.hasSearch = false;
                                   this.triggers[0].hide();
                               }
                             },
                        onTrigger1Click : function(){
                                if(this.hasSearch){
                                  facadeConceito.store.filterByWord('.*');
                                  this.el.dom.value = '';
                                  this.hasSearch = false;
                                  this.triggers[0].hide();
                                }
                        }

                        })],
                        bbar:['->',
                            {text:'Adicionar novo conceito',
                            iconCls:'add2_16',
                            handler:function(){
                                    facadeConceito.alterarOuCriarConceito();
                            }
                        }]
                        
                },{
                        title:'Bibliografia',
                        id:'bibliografiaTab',
                        autoScroll:true,
                        iconCls:'books_16',
                        items:[facadeBibliografia.dataView],
                        tbar:['->',{iconCls:'find_text_16',text:'Pesquisar :'},new Ext.ux.form.SearchField({
                            emptyText:'Filtrar Dados',
                            width:130,
                             onTrigger2Click : function(){
                               facadeBibliografia.store.filterByWord(this.getValue());
                               this.hasSearch = true;
                               this.triggers[0].show();
                               if(this.getValue().toString().match(/^ *$/g)){
                                   this.hasSearch = false;
                                   this.triggers[0].hide();
                               }
                             },
                        onTrigger1Click : function(){
                                if(this.hasSearch){
                                  facadeBibliografia.store.filterByWord('.*');
                                  this.el.dom.value = '';
                                  this.hasSearch = false;
                                  this.triggers[0].hide();
                                }
                        }

                        })],
                        bbar:['->',{iconCls:'add2_16',text:'Adicionar nova bibliografia', handler: function(){
                                  facadeBibliografia.alterarOuCriar();
                        }}]
                        
                },{
                        title:'Anotações',
                        id:'anotacaoTab',
                        iconCls:'document_edit_16',
                        layout:'fit',
                        items:[{
                            xtype:'htmleditor',
                            id:'textAnotacoes'
                        }],
                        bbar:['->',{text:'Salvar anotações', iconCls:'disk_blue_16', handler: function(){
                                 facadeAnotacao.alterar(Ext.getCmp('textAnotacoes').getValue());   
                        }}]
                },{
                            xtype:'panel',
                            title:'Recursos Didáticos',
                            iconCls:'toolbox_16',
                            id:'recursoDidatidosTab',
                            autoScroll:true,
                            expanded:false,
                            items:[facadeTopico.arvore_recurso]
                    }]
            }]
        });
        
      facadeTema.store.reload();
  })


</script>

