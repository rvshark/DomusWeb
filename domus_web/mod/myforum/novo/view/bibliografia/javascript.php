<script>
function FacadeBibliografia(){
    
    this.excluir = function (bibliografiaNome,bibliografiaId){
         Ext.MessageBox.confirm("Confirmação", 'Você deseja excluir a bibliografia  ?', function(btn){
             bibliografiaExcluir = bibliografiaId;
             if(btn!='no'){
                              facadeBibliografia.tab().body.mask('Excluindo registro','x-mask-loading'); 
                 Ext.Ajax.request({
                       url: '<?php echo MainController::$caminho ?>',
                       success: function(){
                           Ext.get('bibliografiaItem' + bibliografiaExcluir ).slideOut('t', {    easing: 'easeOut', 
                               duration: .5,    
                               remove: true,    
                               useDisplay: false,
                                callback: function(){
                                    facadeBibliografia.tab().body.unmask(); 
                                    facadeBibliografia.store.removeAt(facadeBibliografia.store.find('id',bibliografiaId));
                                    //facadeBibliografia.store.reload();
                                }});
                           
                       },
                       failure: function(){
                           facadeBibliografia.tab().body.unmask(); 
                       },
                       headers: {
                           'my-header': 'foo'
                       },
                       params: { controller: 'bibliografia', action: 'deletar','bibliografia[id]':bibliografiaId, 'topico[id]': topicoSelecionado.id }
                    });
             }
         });
    };
    
    this.tab = function(){
        return Ext.getCmp('bibliografiaTab');
    }
    this.alterarOuCriar = function (bibliografiaId){
              var url = '<?php echo MainController::$caminho ?>?controller=bibliografia&action=inserir_visao&topico[id]=' + topicoSelecionado.id
              var title = 'Adicionar Bibliografia';
             if(typeof bibliografiaId != 'undefined'){
                 url = '<?php echo MainController::$caminho ?>?controller=bibliografia&action=alterar_visao&bibliografia[id]=' + bibliografiaId;
                 title = 'Alterar Bibliografia'
             }
                        windowBibliografia = new Ext.Window({
                            title:title,
                            width:563,
                            height:482,
                            autoLoad:{
                                url:url,
                                scripts:true
                            }
                        });
                        windowBibliografia.show();    
        };
        
        //Store conceitoDataView
      this.store = new Ext.data.JsonStore({
        url: '<?php echo MainController::$caminho ?>',
        root: 'bibliografias',
        filterByWord: function(word){
        this.clearFilter();
        this.filterBy(function(record){
                  
                        if( record.data['text'].match(new RegExp(word,'gi')) ){
                             return true;
                        }else{
                            return false;
                        }

                    },this
                )
         },
        reload:function(){
            this.removeAll();
            if(typeof facadeBibliografia.tab().body != 'undefined'){
                    facadeBibliografia.tab().body.mask('Carregando','x-mask-loading');
            }
            this.load({params:{ 'topico[id]':topicoSelecionado['id'], 'controller':'bibliografia','action':'listar'},  callback: function(){ 
                    if(typeof facadeBibliografia.tab().body != 'undefined'){
                        facadeBibliografia.tab().body.unmask();
                    }
                    
                }});
        },
        fields: ['id', 'title','text','updated_at','userid','nome_usuario']
    });
    
    
    
    
    //DataView conceitos
    this.dataView = new Ext.DataView({
				singleSelect: true,
                                overClass:'x-view-over',
				itemSelector: 'div.search-item',
				emptyText : 'Não há bibliografias relacionados a este tópico.',
                                autoScroll:true,
                                draggable:true,
				store: this.store,
                                tpl: new Ext.XTemplate(
                                    '<tpl for=".">',
                                    '<div class="search-item" id="bibliografiaItem{id}">',
                                        '<h3><span>{updated_at:date("M j, Y")}<br /> por {nome_usuario}</span>',
                                        '<a href="#" target="_blank">{title}</a></h3>',
                                        '</br>',
                                        '<p>{text}</p>',
                                        '<tpl if="this.podeEditar(values)">',
                                            '<div style="text-align:right"><a href="#" onclick="facadeBibliografia.alterarOuCriar({id})" target="_blank">Editar</a> | <a href="#" onclick="facadeBibliografia.excluir(\'{title}\',{id})" target="_blank">Excluir</a></div>',
                                        '</tpl>', 
                                    '</div></tpl>',{                                                                    // 5 
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
                                                    v.getRecord(sourceEl).data.tipo = 'bibliografia';
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

    facadeBibliografia = new FacadeBibliografia();


</script>