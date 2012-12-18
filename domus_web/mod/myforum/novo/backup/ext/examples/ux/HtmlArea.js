Ext.namespace('Ext.ux.form');

/*
 * extend setTimeout function to support arguments
 */
function setTimeoutEx(fRef, mDelay){
    if(typeof fRef == 'function'){
        var args = Array.prototype.slice.call(arguments, 2);
        var f = function(){
            fRef.apply(null, args);
        };
        return setTimeout(f, mDelay);
    }
    return setTimeout(fRef, mDelay);
}

Ext.ux.form.HtmlArea = function(config, fckconfig) { //add fckeditor config object
    this.config = config;
    this.fckconfig = fckconfig;
    Ext.ux.form.HtmlArea.superclass.constructor.call(this, config);
    this.instanceLoaded = false;    
    this.instanceValue = '';
    this.editorInstance = undefined;
};

Ext.extend(Ext.ux.form.HtmlArea, Ext.form.TextArea, {
    initEvents: function() {
        this.on('destroy', function() {
            if (typeof this.editorInstance != 'undefined') {
                delete this.editorInstance;
            }
        });
    },
    onRender: function(ct, position) {
        if (!this.el) {
            this.defaultAutoCreate = {
                tag: "textarea",
                style: "width:100px;height:60px;",
                width:'100px',
                height:'60px',
                autocomplete: "off"
            };
        }
        Ext.form.TextArea.superclass.onRender.call(this, ct, position);
        this.hideMode = "visibility";
        this.hidden = true;
        if (this.grow) {
            this.textSizeEl = Ext.DomHelper.append(document.body, {
                tag: "pre",
                cls: "x-form-grow-sizer"
            });
            if (this.preventScrollbars) {
                this.el.setStyle("overflow", "hidden");
            }
            this.el.setHeight(this.growMin);
        }
        this.fckconfig['_editor_'] =  this;
        setTimeoutEx(loadHtmlArea, 100, this.config.id, this.fckconfig); //setTimeoutEx support arguments
    },
    setIsLoaded : function(v) {
        this.instanceLoaded = v;
    },
    getIsLoaded : function() {
        return this.instanceLoaded;
    },
    setValue : function(value) {
        this.instanceValue = value;
        if (this.instanceLoaded) {
            this.HtmlAreaSetValue(value);
        }
        Ext.form.TextArea.superclass.setValue.apply(this, [value]);
    },
    getValue : function() {

        if (this.instanceLoaded) {

            value = this.HtmlAreaGetValue();
            Ext.form.TextArea.superclass.setValue.apply(this, [value]);
            return Ext.form.TextArea.superclass.getValue.call(this);
        } else {

            return this.instanceValue;
        }
    },
    getRawValue : function() {
        if (this.instanceLoaded) {
            value = this.HtmlAreaGetValue();
            Ext.form.TextArea.superclass.setRawValue.apply(this, [value]);
            return Ext.form.TextArea.superclass.getRawValue.call(this);
        } else {
            return this.instanceValue;
        }
    },
    HtmlAreaSetValue : function(value) {
        if(this.instanceLoaded == false){
            return;
        }
        var runner = new Ext.util.TaskRunner();
        var task = {
            run : function() {
                try {
                    var editor = this.editorInstance;
                    if (editor.EditorDocument.body) {
                        editor.setHTML(value);
                        runner.stop(task);
                    }
                } catch (ex) {
                }
            },
            interval : 100,
            scope : this
        };
        runner.start(task);
    },
    HtmlAreaGetValue : function() {
        var data = '';
        if(this.instanceLoaded == false){
            return data;
        }
        data = this.editorInstance.getHTML()
        return data;
    },
    isDirty:function(){
        return this.editorInstance.IsDirty();
    },
    resetIsDirty:function(){
        this.editorInstance.ResetIsDirty();
    }
});

Ext.reg('htmlarea', Ext.ux.form.HtmlArea);

function loadHtmlArea(element, config) {
    var oHtmlArea = new HTMLArea(element);
    for (var key in config) { //fckeditor config from object argument
        
        //if (typeof oHtmlArea.config[key] != 'undefined') {
            oHtmlArea.config[key] = config[key];
        //}
    }
    oHtmlArea.generate();
    oHtmlArea.editorInstance = config['_editor_'];
    oHtmlArea.instanceLoaded = true;
    config['_editor_'].instanceLoaded = true;
    config['_editor_'].editorInstance =  oHtmlArea;
}

function HtmlArea_OnComplete(editorInstance) {
    var activeEditor = Ext.getCmp(editorInstance.Name);
    activeEditor.editorInstance = editorInstance;
    activeEditor.instanceLoaded = true;
    activeEditor.HtmlAreaSetValue(activeEditor.instanceValue);
    editorInstance.Events.AttachEvent('OnBlur', HtmlArea_OnBlur);
    editorInstance.Events.AttachEvent('OnFocus', HtmlArea_OnFocus);
}

function HtmlArea_OnBlur(editorInstance) {
    editorInstance.ToolbarSet.Collapse();
}

function HtmlArea_OnFocus(editorInstance) {
    editorInstance.ToolbarSet.Expand();
}