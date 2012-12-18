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

Ext.ux.form.AMYeditor = function(config, amyconfig) { //add fckeditor config object
    this.config = config;
    this.amyconfig = amyconfig;
    Ext.ux.form.AMYeditor.superclass.constructor.call(this, config);
    this.instanceLoaded = false;
    this.instanceValue = '';
    this.editorInstance = undefined;
};

Ext.extend(Ext.ux.form.AMYeditor, Ext.form.TextArea, {
    initEvents: function() {
        this.on('destroy', function() {
            if (typeof this.editorInstance != 'undefined') {
                delete this.editorInstance;
            }
        });
    },
    onRender: function(ct, position) {


        var id = Ext.id();
        if (!this.el) {
            this.defaultAutoCreate = {
                tag: "textarea",
                style: "width:100px;height:60px;",
                autocomplete: "off",
                "-amy-enabled":true,
                "id" :id
            };
        }

        Ext.form.TextArea.superclass.onRender.call(this, ct, position);

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

        this.config.id = id

        setTimeoutEx(loadAMYeditor, 100, this.config.id, this.amyconfig,this); //setTimeoutEx support arguments

    },
    setIsLoaded : function(v) {
        this.instanceLoaded = v;
    },
    getIsLoaded : function() {
        return this.instanceLoaded;
    },
    setValue : function(value) {
       // this.instanceValue = value;
        if (this.instanceLoaded) {
            this.AMYeditorSetValue(value);
        }
        Ext.form.TextArea.superclass.setValue.apply(this, [value]);
    },
    getValue : function() {
        if (this.instanceLoaded) {
            value = this.AMYeditorGetValue();
            Ext.form.TextArea.superclass.setValue.apply(this, [value]);
            return Ext.form.TextArea.superclass.getValue.call(this);
        } else {
            return this.instanceValue;
        }
    },
    getRawValue : function() {
        if (this.instanceLoaded) {
            value = this.AMYeditorGetValue();
            Ext.form.TextArea.superclass.setRawValue.apply(this, [value]);
            return Ext.form.TextArea.superclass.getRawValue.call(this);
        } else {
            return this.instanceValue;
        }
    },
    AMYeditorSetValue : function(value) {

        if(this.instanceLoaded == false){
            return;
        }
        var runner = new Ext.util.TaskRunner();
        var task = {
            run : function() {
                try {
                    var editor = this.editorInstance;
                    if (editor.EditorDocument.body) {
                        editor.SetData(value);
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
    AMYeditorGetValue : function() {
        var data = '';
        if(this.instanceLoaded == false){
            return data;
        }
        data = this.editorInstance.getText();
        return data;
    },
    isDirty:function(){
       // return this.editorInstance.IsDirty();
        return true;
    },
    resetIsDirty:function(){
      //  this.editorInstance.ResetIsDirty();
        return true;
    }
});

Ext.reg('amyeditor', Ext.ux.form.AMYeditor);

function loadAMYeditor(element, config, thiz) {
    //var oAMYeditor = new AMYeditor(element);

    thiz.editorInstance = transformAMY(document.getElementById(element));

    thiz.instanceLoaded =true

    oAMYeditor = thiz.editorInstance

    for (var key in config) { //amyeditor config from object argument
        if (typeof thiz.editorInstance[key] != 'undefined') {
            thiz.editorInstance[key] = config[key];
        }
    }


   /* //oAMYeditor.ReplaceTextarea();*/


}


