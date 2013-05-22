<script>
/**
 * Responsável por gerenciar toda interface do Tema
 */
function FacadeTema(){
    
    /**
     * Exclui determinado o tema passado como parametro
     */
    this.excluir = function (temaSelecionado){
         Ext.MessageBox.confirm("Confirmação", 'Você deseja excluir o Tema ' + temaSelecionado.data.name + ' ?', function(btn){
             if(btn!='no'){
                 Ext.Ajax.request({
                       url: '<?php echo MainController::$caminho ?>',
                       success: function(objeto1,objeto2){
                           response = Ext.decode(objeto1.responseText)
                           if(response.success){
                               facadeTema.store.reload();
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
                           alert('Erro ao processar ação');
                       },
                       headers: {
                           'my-header': 'foo'
                       },
                       params: { controller: 'tema', action: 'deletar', 'tema[id]': temaSelecionado.id }
                    });
             }
         });
    };
    
    
    /**
    *  Cria uma janela com determinado título e apresenta a url dentro dela
     */
    this.criarJanela = function(title, url){
                  windowTema = new Ext.Window({
                            title:title,
                            width:663,
                            height:482,
                            autoLoad:{
                                url:url,
                                scripts:true
                            }
                        });
                        windowTema.show(); 
    }
    
    /**
     * Cria um tema para determinado curso
     */
    this.criar = function (cursoId){
              var url = '<?php echo MainController::$caminho ?>?controller=tema&action=inserir_visao&curso[id]=' + cursoId;
              var title = 'Adicionar Tema';
             this.criarJanela(title,url);
                         
        };
        
        /**
         * Cria uma janela para alterar o tema
         */
    this.alterar = function (temaSelecionado){
             var  url = '<?php echo MainController::$caminho ?>?controller=tema&action=alterar_visao&tema[id]=' + temaSelecionado.id;
             var    title = 'Alterar Tema'
             this.criarJanela(title,url);
                         
        };
              
                 
             
        /**
         * Método para trocar o tema
         */
        this.trocarTema = function(id){
             Ext.getCmp('centerPanelId').body.mask('Carregando','x-mask-loading');
             
             
                 Ext.Ajax.request({
                       url: '<?php echo MainController::$caminho ?>',
                       success: function(response){
                           Ext.getCmp('textAnotacoes').setValue(response.responseText);
                       },
                       failure: function(){
                           alert('Erro ao carregar anotações.');
                       },
                       params: { controller: 'anotacao', action: 'anotacao_tema','tema[id]':id}
                    });             
             
             
             Ext.getCmp('temaTab').load({
                   url:'<?php echo MainController::$caminho ?>', 
                   scripts:true,
                   params:{'tema[id]':id,controller:'tema',action:'tema_individual'},
                   callback:function(){
                       Ext.getCmp('centerPanelId').body.unmask();
                   }
              });
             
             facadeTopico.store.reload();
        };
        
        //Store conceitoDataView
        /**
        * Carrega os dados de todos os temas relacionados com o curso
         */
      this.store = new Ext.data.JsonStore({
        //url: 'lista_temas.php?forum.id=<?php echo $myforum->id?>',
        url: '<?php echo MainController::$caminho ?>?controller=tema&action=listar&curso[id]=<?php echo $controlador->curso->id?>',
        root: 'temas',
        fields: ['id', 'name'],
        reload:function(temaId){
            temaASelecionar = temaId;
            Ext.getCmp('gridTemas').body.mask('Carregando','x-mask-loading');
            this.load({
                    callback:function(){
                     Ext.getCmp('gridTemas').body.unmask();
                     if(Ext.getCmp('gridTemas').store.getCount() != 0){
                         
                         if(typeof temaASelecionar != 'undefined'){
                            var rowIndex = Ext.getCmp('gridTemas').store.find('id',temaASelecionar)
                            Ext.getCmp('gridTemas').selModel.selectRow(rowIndex); 
                            
                            facadePost.store.removeAll();
                            facadeBibliografia.store.removeAll();
                            facadeConceito.store.removeAll();
                            //Ext.getCmp('acordionId').layout.setActiveItem(1);
                         }
                         
                         if(typeof Ext.getCmp('gridTemas').getSelectionModel().getSelected() == 'undefined'){
                             Ext.getCmp('gridTemas').selModel.selectRow(0);  
                         }
                         
                         temaSelecionado = Ext.getCmp('gridTemas').getSelectionModel().getSelected();  
                         
                         facadeTema.trocarTema(temaSelecionado.id);
                         
                        

                    }
            }});
            
        }
    });
    
    
    
    /**
    * Apresenta os temas em uma lista
     */
    //DataView conceitos
    this.dataView = new Ext.DataView({
				singleSelect: true,
                                overClass:'x-view-over',
				itemSelector: 'div.search-item',
				emptyText : 'Não há Temas relacionados a este tópico.',
                                autoScroll:true,
                                draggable:true,
				store: this.store,
                                tpl: new Ext.XTemplate(
                                    '<tpl for=".">',
                                    '<div class="search-item" id="TemaItem{id}">',
                                        '<h3><span>{updated_at:date("M j, Y")}<br /> por Luiz</span>',
                                        '<a href="#" target="_blank">{title}</a></h3>',
                                        '</br>',
                                        '<p>{text}</p>',
                                        '<div style="text-align:right"><a href="#" onclick="facadeTema.alterarOuCriar({id})" target="_blank">Editar</a> | <a href="#" onclick="facadeTema.excluir(\'{title}\',{id})" target="_blank">Excluir</a></div>',
                                    '</div></tpl>'
                                ), listeners: {
                                    render: function(v) {
                                        v.dragZone = new Ext.dd.DragZone(v.getEl(), {

                                            getDragData: function(e) {
                                                var sourceEl = e.getTarget(v.itemSelector, 10);
                                                if (sourceEl) {
                                                    d = sourceEl.cloneNode(true);
                                                    d.id = Ext.id();
                                                    v.getRecord(sourceEl).data.tipo = 'Tema';
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
                        
           
    
    
    /**
    * Mostra a janela de cursos para fazer a cópia do tema
     */
    this.mostrarJanelaCursos = function(temaSelecionado){
            
                 this.janelaCurso = new Ext.Window({
                          title: 'Cursos',
                          height: 400,
                          modal:true,
                          width: 500,
                          temaSelecionado:temaSelecionado,
                          items: [new Ext.tree.TreePanel({
                            height: 375,
                            id:'arvoreCursos',
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
                              tbar:[' ', {xtype:'label', text:'Filtrar Cursos: '},' ',' ',
                                          new Ext.form.TextField({
                                                width: 200,
                                                emptyText:'digite a palavra para a busca',
                                                enableKeyEvents: true,
                                                listeners:{
                                                    keyup: function(text,e){
                                                        valor = text.getValue();
                                                        arvore = Ext.getCmp('arvoreCursos');

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
                                url:'<?php echo MainController::$caminho ?>?controller=tema&action=arvore_curso',
                                requestMethod:'GET',
                                timeout:100000,
                                listeners:{'beforeLoad':function(treeLoader){
                                        treeLoader.url = '<?php echo MainController::$caminho ?>?controller=tema&action=arvore_curso' 
                                }}
                            }),
                            requestMethod:'GET',
                            timeout:100000,
                            baseParams:{controller:'tema',action:'arvore_curso','curso[id]':13},
                            listeners: {
                                'checkchange': function(node, checked){
                                    if(checked){
                                      //  node.getUI().addClass('complete');
                                    }else{
                                      //  node.getUI().removeClass('complete');
                                    }
                                },
                                'load':function(node){
                                    Ext.getCmp('arvoreCursos').body.unmask();
                                },
                                'afterrender':function(){
                                    
                                    Ext.getCmp('arvoreCursos').body.mask('Carregando','x-mask-loading');
                                    
                                }
                            },

                            buttons: [{
                                text: 'Adicionar tema ao curso',
                                handler: function(){
                                    facadeTema.janelaCurso.body.mask('Gravando','x-mask-loading');
                                    var arvore = Ext.getCmp('arvoreCursos')
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
                                    
                                    parametros['cursos[ids]'] = ids
                                    parametros['tema[id]'] = facadeTema.janelaCurso.temaSelecionado.id;
                                    parametros['controller'] = 'tema';
                                    parametros['action'] = 'copiar_tema';
                                  
                                  Ext.Ajax.request({
                                       url: '<?php echo MainController::$caminho ?>',
                                       method:'POST',
                                       success: function(response,opt){
                                           facadeTema.janelaCurso.close();
                                           Ext.MessageBox.show({
                                               title: 'Aviso',
                                               msg: 'Tema copiado com sucesso!',
                                               buttons: Ext.MessageBox.OK,
                                               icon: Ext.MessageBox.INFO
                                           });
                                       },
                                       failure: function(response){
                                           facadeTema.janelaCurso.body.unmask();
                                           alert('Houve um erro ao copiar os temas.')

                                       },
                                       params: parametros
                                    });
                                    

                                }
                            }]
                        })


                          ]
                      });
                      this.janelaCurso.show();
            }
    
    
    
}

    facadeTema = new FacadeTema();


</script>