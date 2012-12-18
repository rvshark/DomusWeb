<script>
function FacadePost(){
    
    this.excluir = function (postNome,postId){
         Ext.MessageBox.confirm("Confirmação", 'Você deseja excluir este post?', function(btn){
             postExcluir = postId;
             if(btn!='no'){
                 facadePost.tab().body.mask("Excluindo comentário.");
                 Ext.Ajax.request({
                       url: '<?php echo MainController::$caminho ?>',
                       success: function(objeto1,objeto2){
                           response = Ext.decode(objeto1.responseText)
                           if(response.success){
                             Ext.get('postItem' + postExcluir ).slideOut('t', {    easing: 'easeOut', 
                               duration: .5,    
                               remove: true,    
                               useDisplay: false,
                                callback: function(){
                                    facadePost.tab().body.unmask();
                                }});
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
                           facadePost.tab().body.unmask();
                       },
                       headers: {
                           'my-header': 'foo'
                       },
                       params: { controller: 'post', action: 'deletar','post[id]':postExcluir}
                    });
             }
         });
    };
    
    this.campoAttachment = function(){
      return Ext.getCmp('arquivoUpload');
    }
    
    this.alterarOuCriar = function (postId){
              var url = '<?php echo MainController::$caminho ?>?controller=post&action=inserir_visao&topico[id]=' + topicoSelecionado.id
              var title = 'Adicionar Comentário';
             if(typeof postId != 'undefined'){
                 url = '<?php echo MainController::$caminho ?>?controller=post&action=alterar_visao&post[id]=' + postId;
                 title = 'Alterar Comentário'
             }
                        windowPost = new Ext.Window({
                            title:title,
                            width:663,
                            height:482,
                            autoLoad:{
                                url:url,
                                scripts:true
                            }
                        });
                        windowPost.show();    
        };
        
        
    this.responder = function (postId){
              var url = '<?php echo MainController::$caminho ?>?controller=post&action=responder_visao&topico[id]=' + topicoSelecionado.id + '&post[id]=' + postId
              var title = 'Responder Comentário';
                        windowPost = new Ext.Window({
                            title:title,
                            width:663,
                            height:482,
                            autoLoad:{
                                url:url,
                                scripts:true
                            }
                        });
                        windowPost.show();    
        };
        
        //Store conceitoDataView
      this.store = new Ext.data.JsonStore({
        url: '<?php echo MainController::$caminho ?>',
        root: 'posts',
        reload:function(postId){
            this.removeAll();
            
            if(typeof facadePost.tab().body != 'undefined'){
                facadePost.tab().body.mask('Carregando','x-mask-loading');
            }
            
            if(typeof postId != 'undefined'){
                facadePost.postId = postId;
            }else{
                facadePost.postId = undefined;
            }
            
            this.load({params:{ 'topico[id]':topicoSelecionado['id'], 'controller':'post','action':'listar'},  callback: function(){ 
                    if(typeof facadePost.tab().body != 'undefined'){
                        facadePost.tab().body.unmask();
                    }
                    facadePost.irParaPost();
                }});
        },
        fields: ['id', 'updated_at','userid','message','subject','primeiroNome','ultimoNome','citacaoPrimeiroNome','citacaoUltimoNome','citacaoUpdated_at','citacaoMessage','citacaoId','anexo','nome_anexo']
    });
    
    this.tab = function(){
        return Ext.getCmp('postTab');
    }
    
    
    this.irParaPost = function(postId){
            if(typeof postId == 'undefined' && typeof facadePost.postId != 'undefined' ){
                postId = facadePost.postId;
            }
    
            if(typeof postId != 'undefined'){
                var scrollPanel = Ext.get(facadePost.tab().getEl().dom.children[0].children[0])
                postIdCompleto = 'postItem' + postId;
                var scrollar = Ext.get(postIdCompleto).getOffsetsTo(scrollPanel)[1] + Ext.get(postIdCompleto).dom.offsetHeight + scrollPanel.dom.scrollTop  - Ext.get(postIdCompleto).dom.offsetHeight;
                scrollPanel.scrollTo('top',scrollar,{duration:1.5,callback:function(){
                        Ext.get(postIdCompleto).highlight();
                }})                
            }

    };
    
    
    //DataView conceitos
    this.dataView = new Ext.DataView({
				singleSelect: true,
                                overClass:'x-view-over',
			        itemSelector: 'div.item',
                                bubbleEvents:['onClick','onclick','click','dblclick'],
				emptyText : 'Não há comentários relacionados a este tópico.',
                                autoScroll:true,
                                draggable:true,
				store: this.store,
                                tpl: new Ext.XTemplate(
                                    '<tpl for=".">',
                                    '<div id="postItem{id}" class="search-item">',
                                        '<h3><span style="width:130px">{updated_at:date("M j, Y H:m:s")}<br /> por {primeiroNome} {ultimoNome}</span>',
                                        '<a href="#" target="_blank"><img class="item" height="60px" width="60px"   src="<?php echo $CFG->wwwroot?>/user/pix.php/{userid}/f1.jpg"  /></a> {subject}</h3>',
                                        '<tpl if=" values.citacaoMessage != \'\' ">',                       // 3 
                                            '</br>',
                                            '<div style="display:block; cursor:pointer; _cursor:hand " onclick="facadePost.irParaPost({citacaoId})">',
                                                '<div style="float:left;width:2%;display:block;">',
                                                    '<img src="../images/16/aspas.png">',
                                                '</div>',
                                                '<div style="padding-left:5px;display:block;float:right;width:96%;padding-top:10px;border-left: 1px solid #C0C0C0;">',
                                                    '{citacaoMessage}',
                                                    '</br>',
                                                    '<span style="color:#C0C0C0">por {citacaoPrimeiroNome} {citacaoUltimoNome} as {citacaoUpdated_at:date("M j, Y H:m:s")}</span> ',
                                                '</div>',    
                                            '</div>',
                                        '</br>',
                                        '</br>',                                        
                                        '</br>',  
                                        '</tpl>', 

                                        '</br>',
                                        '<p>{message}</p>',
                                        '<div style="text-align:right">',
                                            '<tpl if="this.temAnexo(values)">',
                                                '<a href="javascript:return false;" onclick="facadePost.recuperarAnexo(\'{anexo}\');return false;" >{nome_anexo}</a> | ',
                                            '</tpl>',                                                                                    
                                            '<a href="javascript:return false;" onclick="facadePost.responder({id});return false;" >Responder</a> ',
                                            '<tpl if="this.podeEditar(values)">',
                                                '| <a href="javascript:return false;" onclick="facadePost.alterarOuCriar({id});return false;" >Editar</a> ',
                                                '| <a href="javascript:return false;" onclick="facadePost.excluir(\'{title}\',{id});return false;" >Excluir</a>',
                                            '</tpl>', 
                                        '</div>',
                                    '</div></tpl>',{                                                                    // 5 
                                        podeEditar : function(registro) { 
                                            return registro.userid == <?php echo $_SESSION['USER']->id?> ;
                                        },
                                        temAnexo : function(registro) { 
                                            return !registro.anexo.match(/^(( *)|(null)|(undefined))$/);
                                                
                                             
                                        }
                                    })
			});
                        
           
                        this.recuperarAnexo = function(anexo){
                                window.open(anexo);
                        
                        }
    
    
}

    facadePost = new FacadePost();


</script>