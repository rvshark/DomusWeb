   //setTimeout("enable();", 10);
      enable = function(){
		document.getElementById('editor').contentWindow.document.designMode="on";
        
	}

	function Italic() {

		document.getElementById('editor').contentWindow.document.execCommand('italic', false, null);
	}
    
	function Bold() {

		document.getElementById('editor').contentWindow.document.execCommand('bold', false, null);
	}

	function Underline() {

		document.getElementById('editor').contentWindow.document.execCommand('underline', false, null);
	}
  
	function StrikeThrough() {

		document.getElementById('editor').contentWindow.document.execCommand('StrikeThrough', false, null);
	}

	function SubScript() {

		document.getElementById('editor').contentWindow.document.execCommand('SubScript', false, null);
	}

	function SuperScript() {

		document.getElementById('editor').contentWindow.document.execCommand('SuperScript', false, null);
	}

	function JustifyLeft() {

		document.getElementById('editor').contentWindow.document.execCommand('JustifyLeft', false, null);
	}
	
	function JustifyCenter() {

		document.getElementById('editor').contentWindow.document.execCommand('JustifyCenter', false, null);
	}

	function JustifyRight() {

		document.getElementById('editor').contentWindow.document.execCommand('JustifyRight', false, null);
	}
	
	function JustifyFull() {

		document.getElementById('editor').contentWindow.document.execCommand('JustifyFull', false, null);
	}

       
	function InsertOrderedList() {

		document.getElementById('editor').contentWindow.document.execCommand('InsertOrderedList', false, null);
	}

	function InsertUnorderedList() {

		document.getElementById('editor').contentWindow.document.execCommand('InsertUnorderedList', false, null);
	}

	function Outdent() {

		document.getElementById('editor').contentWindow.document.execCommand('Outdent', false, null);
	}

	function Indent() {

		document.getElementById('editor').contentWindow.document.execCommand('Indent', false, null);
	}
     
	function ForeColor(val) {
                var cor = document.formcor.Cor.value;
                if(cor == "" || cor == "0"){
                    val = "#000000";                 
		}else {
			val = cor;
                   }
                //alert(val);
              	document.getElementById('editor').contentWindow.document.execCommand('ForeColor', false, val);
	       
	}
	
	function CreateLink(url) {
                var lLink = document.formllink.llink.value;
				 url = lLink;
			
            document.getElementById('editor').contentWindow.document.execCommand('CreateLink', false, url);
	       
	}
	
	function CreateLinkTextos(url) {
                var tLink = document.formtlink.tlink.value;
				 url = tLink;
			
            document.getElementById('editor').contentWindow.document.execCommand('CreateLink', false, url);
	       
	}
	
	function AddLink(url) {
              var xLink = prompt('URL:', 'http://');
				
				  url = "javascript:page('" + xLink + "');";
			
			document.getElementById('editor').contentWindow.document.execCommand('CreateLink', false, url);
	       
	}
	
	function unLink() {
            
			document.getElementById('editor').contentWindow.document.execCommand('UnLink', false, null);    				 
			
	}
	
	function AddImage(imagem) {
		var urlImg = urlImage;
		var imagePath = prompt('Imagem URL:', 'http://'+ urlImg);
						
		if ((imagePath != null) && (imagePath != "")) {
		    imagem = imagePath;	
			document.getElementById('editor').contentWindow.document.execCommand('InsertImage', false,  imagem);
		}
	}
	
	function ChangeFont(nameFont) {
		   var fontName = document.formfont.font.value;
			   nameFont = fontName;
			
			document.getElementById('editor').contentWindow.document.execCommand('FontName', false, nameFont);
	}

	function ChangeSize(sizeN) {
		var sizeN = document.formsize.size.value;
			
			document.getElementById('editor').contentWindow.document.execCommand('FontSize', false, sizeN);
	}
     function CutT() {
		
		document.getElementById('editor').contentWindow.document.execCommand('Cut', false, null);
	
	}

	function CopyT() {
		
		document.getElementById('editor').contentWindow.document.execCommand('Copy', false, null);
	
	}
	
	function PasteT() {
		
		document.getElementById('editor').contentWindow.document.execCommand('Paste', false, null);
	
	}

	function UndoT() {
		
		document.getElementById('editor').contentWindow.document.execCommand('Undo', false, null);
	
	}

	function RedoT() {
		
		document.getElementById('editor').contentWindow.document.execCommand('Redo', false, null);
	
	}
   
	function valor(){
	     document.getElementById('editor').contentWindow.document.body.innerHTML;
   	}

	function enviarhidden() {

		form = document.forms.form1;
                TXT = document.getElementById('editor').contentWindow.document.body.innerHTML;
               if (TXT == "" || TXT == "<br>" || TXT == "<p><br></p>" || TXT == "<p>&nbsp;</p>") {
                        alert('O campo Texto deve ser preenchido.');
                        return false;
                }
                else {
                     
                        form.txtTexte.value = TXT;           
                        //form.submit();
                }
        }
     
