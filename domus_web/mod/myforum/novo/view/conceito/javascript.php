<script>
    /**
     * Controla as responsabilidades da visão do conceito
     */
function FacadeConceito(){
    
    /**
     * Visão para excluir um conceito
     * Passa o nome e o id do conceito a ser excluido
     */
    this.excluirConceito = function(conceitoNome,conceitoId){
         Ext.MessageBox.confirm("Confirmação", 'Você deseja excluir o conceito ' + conceitoNome + " ?", function(btn){
             conceitoExcluir = conceitoId;
             if(btn!='no'){
                 facadeConceito.tab().body.mask('Excluindo registro.','x-mask-loading')
                 Ext.Ajax.request({
                       url: '<?php echo MainController::$caminho ?>',
                       success: function(event,action){
                           Ext.get('conceitoItem' + conceitoExcluir ).slideOut('t', {    easing: 'easeOut', 
                               duration: .5,    
                               remove: true,    
                               useDisplay: false,
                                callback: function(){
                                    facadeConceito.tab().body.unmask();
                                    facadeConceito.store.removeAt(facadeConceito.store.find('id',conceitoId));
                                 //   facadeConceito.store.reload();
                                }});
                           
                       },
                       failure: function(){
                           facadeConceito.tab().body.unmask();
                       },
                       headers: {
                           'my-header': 'foo'
                       },
                       params: { controller: 'conceito', action: 'deletar','conceito[id]':conceitoId, 'topico[id]': topicoSelecionado.id }
                    });
             }
         });
    };
    
    /**
    * Retorna o componente da aba do conceito
     */
    this.tab = function(){
        return Ext.getCmp('conceitoTab');
    }
    
    
    /**
     * Altera ou cria um conceito
     */
    this.alterarOuCriarConceito = function (conceitoId){
              var url = '<?php echo MainController::$caminho ?>?controller=conceito&action=inserir_visao&topico[id]=' + topicoSelecionado.id
              var title = 'Adicionar conceito';
             if(typeof conceitoId != 'undefined'){
                 url = '<?php echo MainController::$caminho ?>?controller=conceito&action=alterar_visao&conceito[id]=' + conceitoId;
                 title = 'Alterar conceito';
             }
                        windowConceito = new Ext.Window({
                            title:title,
                            width:563,
                            height:482,
                            autoLoad:{
                                url:url,
                                scripts:true
                            }
                        });
                        windowConceito.show();    
        };
        
        
        /**
        * Carrega os dados relacionados aos conceitos relativos a um tópico
         */
        //Store conceitoDataView
      this.store = new Ext.data.JsonStore({
        url: '<?php echo MainController::$caminho ?>',
        root: 'conceitos',
        filterByWord: function(word){
        this.clearFilter();
        this.filterBy(function(record){
                  
                        if(record.data['title'].match(new RegExp(word,'gi')) || record.data['text'].match(new RegExp(word,'gi')) ){
                             return true;
                        }else{
                            return false;
                        }

                    },this
                )
         },
        reload:function(){
            this.createSortFunction('title','asc');
            this.removeAll();
            if(typeof facadeConceito.tab().body != 'undefined'){
                facadeConceito.tab().body.mask('Carregando','x-mask-loading');
            }
            this.load({params:{ 'topico[id]':topicoSelecionado['id'], 'controller':'conceito','action':'listar'},  callback: function(){ 
                    
                    if(typeof facadeConceito.tab().body != 'undefined'){
                        facadeConceito.tab().body.unmask();
                        
                    }
                    facadeConceito.store.sort('title','asc');
                    
                }});
        },
        fields: ['id', 'title','text','updated_at','userid','nome_usuario']
    });
    
    
    
    
    //DataView conceitos
    /**
    * Componente para apresentar os conceitos na aba conceito
     */
    this.conceitosDataView = new Ext.DataView({
				singleSelect: true,
                                overClass:'x-view-over',
				itemSelector: 'div.search-item',
				emptyText : 'Não há conceitos relacionados a este tópico.',
                                autoScroll:true,
                                draggable:true,
				store: this.store,
                                tpl: new Ext.XTemplate(
                                    '<tpl for=".">',
                                    '<div class="search-item" id="conceitoItem{id}">',
                                        '<h3><span>{updated_at:date("M j, Y")}<br /> por {nome_usuario}</span>',
                                        '<a href="#" target="_blank">{title}</a></h3>',
                                        '</br>',
                                        '<p>{text}</p>',
                                        '<tpl if="this.podeEditar(values)">',
                                            '<div style="text-align:right"><a href="#" onclick="facadeConceito.alterarOuCriarConceito({id})" target="_blank">Editar</a> | <a href="#" onclick="facadeConceito.excluirConceito(\'{title}\',{id})" target="_blank">Excluir</a></div>',
                                        '</tpl>', 
                                    '</div></tpl>'   ,{                                                                    // 5 
                                        podeEditar : function(registro) { 
                                            return registro.userid == <?php echo $_SESSION['USER']->id?> ;
                                        }
                                    }
                                ), listeners: {
                                    render: function(v) {
                                        v.dragZone = new Ext.dd.DragZone(v.getEl(), {

                                            getDragData: function(e) {
                                                var sourceEl = e.getTarget(v.itemSelector, 10);
                                                if (sourceEl) {
                                                    d = sourceEl.cloneNode(true);
                                                    d.id = Ext.id();
                                                    v.getRecord(sourceEl).data.tipo = 'conceito';
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

facadeConceito = new FacadeConceito();


</script>