<script>
function FacadeTema(){
    
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
    
    this.criar = function (cursoId){
              var url = '<?php echo MainController::$caminho ?>?controller=tema&action=inserir_visao&curso[id]=' + cursoId;
              var title = 'Adicionar Tema';
             this.criarJanela(title,url);
                         
        };
        
    this.alterar = function (temaSelecionado){
             var  url = '<?php echo MainController::$caminho ?>?controller=tema&action=alterar_visao&tema[id]=' + temaSelecionado.id;
             var    title = 'Alterar Tema'
             this.criarJanela(title,url);
                         
        };
              
                 
             
        
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
                        
           
         
    
}

    facadeTema = new FacadeTema();


</script>