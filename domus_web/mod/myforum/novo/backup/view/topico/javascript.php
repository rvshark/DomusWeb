<script>
    
function FacadeTopico(){
   
   
this.excluir = function (topicoNome,topicoId){
        
         Ext.MessageBox.confirm("Confirmação", 'Você deseja excluir o Topico '+topicoNome+'?', function(btn){
             if(btn!='no'){
                 Ext.Ajax.request({
                       url: '<?php echo MainController::$caminho ?>',
                                              success: function(objeto1,objeto2){
                           response = Ext.decode(objeto1.responseText)
                           if(response.success){
                               facadeTopico.store.reload();
                           }else{
                               
                             for(key in response.errors){
                                  Ext.MessageBox.show({
                                       title: 'Erro',
                                       msg: response.errors[key],
                                       buttons: Ext.MessageBox.OK,
                                       icon: Ext.MessageBox.ERROR
                                   });                                 
                             }  

                           }
                       },
                       failure: function(){
                           alert('Deu erro');
                       },
                       params: { controller: 'topico', action: 'deletar','topico[id]':topicoId}
                    });
             }
         });
    };
    
    
    
    this.criarWindow = function(url,title){
                        windowTopico = new Ext.Window({
                            title:title,
                            width:663,
                            height:482,
                            autoLoad:{
                                url:url,
                                scripts:true
                            }
                        });
                        windowTopico.show();        
    }
    
    this.alterar = function (topicoId){
                 var url = '<?php echo MainController::$caminho ?>?controller=topico&action=alterar_visao&topico[id]=' + topicoId;
                 var title = 'Alterar Topico'
                 this.criarWindow(url, title);   

        };
        
    this.criar = function (temaId){
              var url = '<?php echo MainController::$caminho ?>?controller=topico&action=inserir_visao&tema[id]=' + temaId;
              var title = 'Adicionar Topico';
              this.criarWindow(url, title);   
        };
        
        
        //Store conceitoDataView
      this.store = new Ext.data.JsonStore({
        url: '<?php echo MainController::$caminho ?>',
        root: 'topicos',
        fields: ['id', 'name'],
        reload:function(topicoId){
            if(typeof topicoId != 'undefined'){
                topicoASelecionar = topicoId;
            }
            Ext.getCmp('gridTopicos').body.mask('Carregando','x-mask-loading');
            this.load({params:{'tema[id]':temaSelecionado.id,'controller':'topico','action':'listar'},
                    callback:function(){
                     Ext.getCmp('gridTopicos').body.unmask();
                     if(Ext.getCmp('gridTopicos').store.getCount() != 0){
                         var rowIndex = 0;
                        if(typeof topicoASelecionar !='undefined'){
                             rowIndex = Ext.getCmp('gridTopicos').store.find('id',topicoASelecionar);
                        }
                         
                        Ext.getCmp('gridTopicos').selModel.selectRow(rowIndex);  
                        topicoSelecionado = Ext.getCmp('gridTopicos').selModel.getSelected();
                        facadeConceito.store.reload();
                        facadeBibliografia.store.reload();
                        facadePost.store.reload();
                        facadeTopico.arvore_recurso.reload();
                    }
            }
            
        });
            
        }
    });
    
    
    this.getTabRecursosDidaticos = function(){
            return  Ext.getCmp('recursoDidatidosTab');
    }
    
    //DataView conceitos
    this.dataView = new Ext.DataView({
				singleSelect: true,
                                overClass:'x-view-over',
				itemSelector: 'div.search-item',
				emptyText : 'Não há Topicos relacionados a este tópico.',
                                autoScroll:true,
                                draggable:true,
				store: this.store,
                                tpl: new Ext.XTemplate(
                                    '<tpl for=".">',
                                    '<div class="search-item" id="TopicoItem{id}">',
                                        '<h3><span>{updated_at:date("M j, Y")}<br /> por Luiz</span>',
                                        '<a href="#" target="_blank">{title}</a></h3>',
                                        '</br>',
                                        '<p>{text}</p>',
                                        '<div style="text-align:right"><a href="#" onclick="facadeTopico.alterarOuCriar({id})" target="_blank">Editar</a> | <a href="#" onclick="facadeTopico.excluir(\'{title}\',{id})" target="_blank">Excluir</a></div>',
                                    '</div></tpl>'
                                ), listeners: {
                                    render: function(v) {
                                        v.dragZone = new Ext.dd.DragZone(v.getEl(), {

                                            getDragData: function(e) {
                                                var sourceEl = e.getTarget(v.itemSelector, 10);
                                                if (sourceEl) {
                                                    d = sourceEl.cloneNode(true);
                                                    d.id = Ext.id();
                                                    v.getRecord(sourceEl).data.tipo = 'Topico';
                                                    return v.dragData = {
                                                        sourceEl: sourceEl,
                                                        repairXY: Ext.fly(sourceEl).getXY(),
                                                        ddel: d,
                                                        data: v.getRecord(sourceEl).data
                                                    }
                                                }
                                            },

                                            getRepairXY: function() {
                                                return this.dragData.repairXY;
                                            }
                                        })
                                    }
                                }
			});
                        
                        
               topicoId = ""     
               
               
            this.mostrarJanela = function(){
            
                 this.janelaGaleria = new Ext.Window({
                          title: 'Galeria',
                          height: 400,
                          modal:true,
                          width: 500,
                          items: [new Ext.tree.TreePanel({
                            height: 375,
                            id:'arvorePermissao',
                            width: '100%',
                            useArrows:true,
                            autoScroll:true,
                            hiddenNodes: [],
                            animate:true,
                            enableDD:true,
                            containerScroll: true,
                            rootVisible: false,
                            root: {
                                nodeType: 'async'
                            },
                              tbar:[' ', {xtype:'label', text:'Filtrar Recursos: '},' ',' ',
                                          new Ext.form.TextField({
                                                width: 200,
                                                emptyText:'digite a palavra para a busca',
                                                enableKeyEvents: true,
                                                listeners:{
                                                    keyup: function(text,e){
                                                        valor = text.getValue();
                                                        arvore = Ext.getCmp('arvorePermissao');

                                                        Ext.each(arvore.hiddenNodes, function(n){
                                                             n.ui.show();
                                                        });

                                                            if(!valor){
                                                                     return;
                                                                 }

                                                            arvore.expandAll();

                                                            var re = new RegExp('^.*' + Ext.escapeRe(valor) + '.*', 'i');

                                                            arvore.root.cascade( function(n){
                                                              if (re.test(n.text)) {
                                                                n.ui.show();
                                                                n.bubble(function(){ this.ui.show(); });
                                                              } else {
                                                                  coisa = n
                                                                  if (n.leaf && n.text != 'Sair'){
                                                                        n.ui.hide();
                                                                        arvore.hiddenNodes.push(n);
                                                                  }
                                                              }
                                                            }, this);


                                                    },
                                                    scope: this
                                                }
                                            })

                                      ],
                            // auto create TreeLoader
                            loader: new Ext.tree.TreeLoader({
                                url:'<?php echo MainController::$caminho ?>?controller=topico&action=arvore_galeria',
                                requestMethod:'GET',
                                listeners:{'beforeLoad':function(treeLoader){
                                        treeLoader.url = '<?php echo MainController::$caminho ?>?controller=topico&action=arvore_galeria&topico[id]=' + topicoSelecionado.id
                                }}
                            }),
                            requestMethod:'GET',
                            baseParams:{controller:'topico',action:'arvore_galeria','curso[id]':13},
                            listeners: {
                                'checkchange': function(node, checked){
                                    if(checked){
                                      //  node.getUI().addClass('complete');
                                    }else{
                                      //  node.getUI().removeClass('complete');
                                    }
                                },
                                'load':function(node){
                                    Ext.getCmp('arvorePermissao').body.unmask();
                                },
                                'afterrender':function(){
                                    
                                    Ext.getCmp('arvorePermissao').body.mask('Carregando','x-mask-loading');
                                    
                                }
                            },

                            buttons: [{
                                text: 'Vincular ao Tópico',
                                handler: function(){
                                    facadeTopico.janelaGaleria.body.mask('Gravando','x-mask-loading');
                                    var arvore = Ext.getCmp('arvorePermissao')
                                    var parametros = new Object();

                                    var ids = '';
                                    
                                    var selNodes = arvore.getChecked();

                                    var i = 0 ;
                                    Ext.each(selNodes, function(node){
                                        if(ids.length > 0){
                                            ids += ',';
                                        }

                                        ids +=  node.id;

                                    });
                                    
                                    parametros['recurso[ids]'] = ids
                                    parametros['topico[id]'] = topicoSelecionado.id;
                                    parametros['controller'] = 'topico';
                                    parametros['action'] = 'gravar_galeria';
                                  
                                  Ext.Ajax.request({
                                       url: '<?php echo MainController::$caminho ?>',
                                       method:'POST',
                                       success: function(response,opt){
                                           facadeTopico.janelaGaleria.close();
                                           Ext.MessageBox.show({
                                               title: 'Aviso',
                                               msg: 'Relacionamento criado com sucesso!',
                                               buttons: Ext.MessageBox.OK,
                                               icon: Ext.MessageBox.INFO
                                           });
                                           facadeTopico.arvore_recurso.reload();
                                       },
                                       failure: function(response){
                                           facadeTopico.janelaGaleria.body.unmask();
                                           alert('Houve um erro ao atualizar recursos.')

                                       },
                                       params: parametros
                                    });
                                    

                                }
                            }]
                        })


                          ]
                      });
                      this.janelaGaleria.show();
            }  
               
            
   this.arvore_recurso =   new Ext.tree.TreePanel({
                            id:'arvoreRecursos',
                            useArrows:true,
                            autoScroll:true,
                            hiddenNodes: [],
                            animate:true,
                            enableDD:true,
                            containerScroll: true,
                            rootVisible: false,
                            reload:function(){
                                this.getLoader().load(this.getRootNode())
                            },
                            root: {
                                nodeType: 'async'
                            },
                              tbar:[' ', {xtype:'label', text:'Filtrar Recursos: '},' ',' ',
                                          new Ext.form.TextField({
                                                width: 200,
                                                emptyText:'digite a palavra para a busca',
                                                enableKeyEvents: true,
                                                listeners:{
                                                    keyup: function(text,e){
                                                        valor = text.getValue();
                                                        arvore = Ext.getCmp('arvoreRecursos');

                                                        Ext.each(arvore.hiddenNodes, function(n){
                                                             n.ui.show();
                                                        });

                                                            if(!valor){
                                                                     return;
                                                                 }

                                                            arvore.expandAll();

                                                            var re = new RegExp('^.*' + Ext.escapeRe(valor) + '.*', 'i');

                                                            arvore.root.cascade( function(n){
                                                              if (re.test(n.text)) {
                                                                n.ui.show();
                                                                n.bubble(function(){ this.ui.show(); });
                                                              } else {
                                                                  coisa = n
                                                                  if (n.leaf && n.text != 'Sair'){
                                                                        n.ui.hide();
                                                                        arvore.hiddenNodes.push(n);
                                                                  }
                                                              }
                                                            }, this);


                                                    },
                                                    scope: this
                                                }
                                            })

                                      ],
                            // auto create TreeLoader
                            loader: new Ext.tree.TreeLoader({
                                url:'<?php echo MainController::$caminho ?>?controller=topico&action=arvore_recursos_didaticos',
                                requestMethod:'GET',
                                listeners:{'beforeLoad':function(treeLoader){
                                        treeLoader.url = '<?php echo MainController::$caminho ?>?controller=topico&action=arvore_recursos_didaticos&topico[id]=' + topicoSelecionado.id
                                        facadeTopico.getTabRecursosDidaticos().body.mask('Carregando','x-mask-loading');
                                },'load':function(treeLoader){
                                        facadeTopico.getTabRecursosDidaticos().body.unmask();
                                },'loadexception':function(treeLoader){
                                        facadeTopico.getTabRecursosDidaticos().body.unmask();
                                }
                                
                                }
                            }),
                            requestMethod:'GET',
                            listeners: {
                                'dblclick': function(node, checked){
                                    
                                   if(node.attributes.tipo =='html'){

                                        var windowRecurso = new Ext.Window({
                                                title:node.attributes.text,
                                                width:800,
                                                height:600,
                                                autoScroll:true,
                                                modal:true,
                                                autoLoad:{
                                                    url:'<?php echo MainController::$caminho ?>?controller=recurso&action=mostrar_recurso&recurso[id]=' + node.attributes.id,
                                                    scripts:true
                                                }
                                            });
                                            windowRecurso.show();   
                                            
                                   }
                                   
                                   if(node.attributes.tipo =='arquivo' || node.attributes.tipo =='img' || node.attributes.tipo =='video' ){
                                        window.open('http://<?php echo $_SERVER['SERVER_NAME'] . ':' . ($_SERVER['PORT'] == ''?'80':$_SERVER['PORT']) . '/'   ?>' + node.attributes.url);
                                   }
                                },
                                'load':function(node){
                                    Ext.getCmp('arvoreRecursos').body.unmask();
                                },
                                'afterrender':function(){
                                    
                                    Ext.getCmp('arvoreRecursos').body.mask('Carregando','x-mask-loading');
                                    
                                }
                            }
                        })      
         
    
}

    facadeTopico = new FacadeTopico();


</script>
