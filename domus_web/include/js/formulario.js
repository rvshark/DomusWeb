
function max(txarea){
  
	total = 300;
  
	tam = txarea.value.length;
  
	str="";
  
	str=str+tam;
  
	Digitado.innerHTML = str;
  
	Restante.innerHTML = total - str;
  
  
	if (tam > total){
  
		aux = txarea.value;
	  
		txarea.value = aux.substring(0,total);
	  
		Digitado.innerHTML = total
  
		Restante.innerHTML = 0
	}
}


function Vdate(){

 var data1 = document.nform.DateAller.value;
 var data2 = document.nform.DateRetour.value;

 if ( parseInt( data2.split( "/" )[2].toString() + data2.split( "/" )[1].toString() + data2.split( "/" )[0].toString() ) >= parseInt( data1.split( "/" )[2].toString() + data1.split( "/" )[1].toString() + data1.split( "/" )[0].toString() ) )
 {
  return true;
 }
 else{
      alert( "Date Aller > Date Retour." );
      return false;
     }
}

function Vlink(nform){

		 if(nform.txtTitulo.value == "") {
			alert("O campo Titulo deve ser preenchido.");
			nform.txtTitulo.focus();
			nform.txtTitulo.select();
                  nform.txtTitulo.style.background = "FF0000";
			return false;
		}else {nform.titulo.style.background = "FFFFFF";}
		
		if(nform.txtHyperLink.value == "") {
			alert("O campo HyperLink deve ser preenchido.");
			nform.txtHyperLink.focus();
			nform.txtHyperLink.select();
			return false;
		}
          return true;
}

function Vcadastro(nform) {
		 if(nform.txtNome.value == "") {
			alert("O campo Nome deve ser preenchido.");
			nform.txtNome.focus();
			nform.txtNome.select();
                  nform.txtNome.style.background = "FF0000";
			return false;
		}else {nform.txtNome.style.background = "FFFFFF";}
		
		if(nform.txtSobreNome.value == "") {
			alert("O campo Sobrenome deve ser preenchido.");
			nform.txtSobreNome.focus();
			nform.txtSobreNome.select();
			return false;
		}
		if (nform.txtMail.value == "") {
		alert("O campo E-mail deve ser preenchido.");
		nform.txtMail.focus();
		nform.txtMail.select();
		return false;
	} else {
		prim = nform.txtMail.value.indexOf("@")
		prim1 = nform.txtMail.value.indexOf(".")
		if(prim < 2) {
			alert("O E-mail informado é incorreto.");
			nform.txtMail.focus();
			nform.txtMail.select();
			return false;
		}
		if(nform.txtMail.value.indexOf("@",prim + 1) != -1) {
			alert("O E-mail informado é incorreto.");
			nform.txtMail.focus();
			nform.txtMail.select();
			return false;
		}
		if(nform.txtMail.value.indexOf(".") < 1) {
			alert("O E-mail informado é incorreto.");
			nform.txtMail.focus();
			nform.txtMail.select();
			return false;
		}
		if(nform.txtMail.value.indexOf(".",prim1 + 1) != -1) {
			alert("O E-mail informado é incorreto.");
			nform.txtMail.focus();
			nform.txtMail.select();
			return false;
		}
		if(nform.txtMail.value.indexOf(" ") != -1) {
			alert("O E-mail informado é incorreto.");
			nform.txtMail.focus();
			nform.txtMail.select();
			return false;
		}
		if(nform.txtMail.value.indexOf("zipmeil.com") > 0) {
			alert("O E-mail informado é incorreto.");
			nform.txtMail.focus();
			nform.txtMail.select();
			return false;
		}
		if(nform.txtMail.value.indexOf("hotmeil.com") > 0) {
			alert("O E-mail informado é incorreto.");
			nform.txtMail.focus();
			nform.txtMail.select();
			return false;
		}
		if(nform.txtMail.value.indexOf(".@") > 0) {
			alert("O E-mail informado é incorreto.");
			nform.txtMail.focus();
			nform.txtMail.select();
			return false;
		}
		if(nform.txtMail.value.indexOf("@.") > 0) {
			alert("O E-mail informado é incorreto.");
			nform.txtMail.focus();
			nform.txtMail.select();
			return false;
		}
		if(nform.txtMail.value.indexOf("..com") > 0) {
			alert("O E-mail informado é incorreto.");
			nform.txtMail.focus();
			nform.txtMail.select();
			return false;
		}
		if(nform.txtMail.value.indexOf(".com.fr.") > 0) {
			alert("O E-mail informado é incorreto.");
			nform.txtMail.focus();
			nform.txtMail.select();
			return false;
		}
		if(nform.txtMail.value.indexOf("/") > 0) {
			alert("O E-mail informado é incorreto.");
			nform.txtMail.focus();
			nform.txtMail.select();
			return false;
		}
		if(nform.txtMail.value.indexOf("[") > 0) {
			alert("O E-mail informado é incorreto.");
			nform.txtMail.focus();
			nform.txtMail.select();
			return false;
		}
		if(nform.txtMail.value.indexOf("]") > 0) {
			alert("O E-mail informado é incorreto.");
			nform.txtMail.focus();
			nform.txtMail.select();
			return false;
		}
		if(nform.txtMail.value.indexOf("(") > 0) {
			alert("O E-mail informado é incorreto.");
			nform.txtMail.focus();
			nform.txtMail.select();
			return false;
		}
		if(nform.txtMail.value.indexOf(")") > 0) {
			alert("O E-mail informado é incorreto.");
			nform.txtMail.focus();
			nform.txtMail.select();
			return false;
		}
		if(nform.txtMail.value.indexOf("..") > 0) {
			alert("O E-mail informado é incorreto.");
			nform.txtMail.focus();
			nform.txtMail.select();
			return false;
		}
		if(nform.txtMail.value.indexOf(".") < 1) {
			alert("O E-mail informado é incorreto.");
			nform.txtMail.focus();
			nform.txtMail.select();
			return false;
		}
	}
		if(nform.txtLogin.value == "") {
			alert("O campo Login deve ser preenchido.");
			nform.txtLogin.focus();
			nform.txtLogin.select();
			return false;
		}
		if(nform.txtSenha.value == "") {
			alert("O campo Senha deve ser preenchido.");
			nform.txtSenha.focus();
			nform.txtSenha.select();
			return false;
		}
		if(nform.txtConfirmarsenha.value == "") {
			alert("O campo Confirmar Senha deve ser preenchido.");
			nform.txtConfirmarsenha.focus();
			nform.txtConfirmarsenha.select();
			return false;
		}
		if(nform.txtEndereco.value == "") {
			alert("O campo Endereço deve ser preenchido.");
			nform.txtEndereco.focus();
			nform.txtEndereco.select();
			return false;
		}
		
		if(nform.txtCidade.value == "") {
			alert("O campo Cidade deve ser preenchido.");
			nform.txtCidade.focus();
			nform.txtCidade.select();
			return false;
		}
		if(nform.txtEstado.value == "") {
			alert("O campo Estado deve ser preenchido.");
			nform.txtEstado.focus();
			nform.txtEstado.select();
			return false;
		}
		if(nform.txtCep.value == "") {
			alert("O campo CEP deve ser preenchido.");
			nform.txtCep.focus();
			nform.txtCep.select();
			return false;
		}
		if(nform.txtDdd.value == "") {
			alert("O campo DDD deve ser preenchido.");
			nform.txtDdd.focus();
			nform.txtDdd.select();
			return false;
		}
		
		if(nform.txtTelefone.value == "") {
			alert("O campo Telefone deve ser preenchido.");
			nform.txtTelefone.focus();
			nform.txtTelefone.select();
			return false;
		}
		
	
	 return true;
}

function Vpdf(nform){
		
		if(nform.txtTitulo.value == "") {
			alert("O campo Titulo deve ser preenchido.");
			nform.txtTitulo.focus();
			return false;
		}
		if(nform.txtSec.value == "") {
			alert("O campo Seção deve ser preenchido.");
			nform.txtSec.focus();
			return false;
		}
		 if(nform.txtTipo.value == "") {
			alert("O campo Nivel deve ser preenchido.");
			nform.txtTipo.focus();
			return false;
		  }
		  if(nform.arquivo.value == "") {
			alert("O campo Arquivo deve ser preenchido.");
			nform.arquivo.focus();
			return false;
		  }
         return nform.action='transPdf.php?acao=inserir';
         
}

function Vppt(nform){
		
		if(nform.txtTitulo.value == "") {
			alert("O campo Titulo deve ser preenchido.");
			nform.txtTitulo.focus();
			return false;
		}
		if(nform.txtSec.value == "") {
			alert("O campo Seção deve ser preenchido.");
			nform.txtSec.focus();
			return false;
		}
		 if(nform.txtTipo.value == "") {
			alert("O campo Nivel deve ser preenchido.");
			nform.txtTipo.focus();
			return false;
		  }
		  if(nform.arquivo.value == "") {
			alert("O campo Arquivo deve ser preenchido.");
			nform.arquivo.focus();
			return false;
		  }
         return nform.action='transPpt.php?acao=inserir';
         
}

function Vimagem(nform){
		
		if(nform.txtTitulo.value == "") {
			alert("O campo Nome deve ser preenchido.");
			nform.txtTitulo.focus();
			return false;
		}
	   if(nform.arquivo.value == "") {
			alert("O campo Arquivo deve ser preenchido.");
			nform.arquivo.focus();
			return false;
		  }
         return nform.action='?acao=inserirImagem';
         
}

function Vflv(nform){
		
		if(nform.txtTitulo.value == "") {
			alert("O campo Titulo deve ser preenchido.");
			nform.txtTitulo.focus();
			return false;
		}
		if(nform.txtSec.value == "") {
			alert("O campo Seção deve ser preenchido.");
			nform.txtSec.focus();
			return false;
		}
		
		if(nform.textos.value == "" || nform.textos.value == 0) {
			alert("O campo Texto deve ser preenchido.");
			nform.textos.focus();
			return false;
		}
		
		 if(nform.txtTipo.value == "") {
			alert("O campo Nivel deve ser preenchido.");
			nform.txtTipo.focus();
			return false;
		  }
		  if(nform.arquivo.value == "") {
			alert("O campo Arquivo deve ser preenchido.");
			nform.arquivo.focus();
			return false;
		  }
         return nform.action='transFlv.php?acao=inserir';
         
}

function Vtexto(form1){
		
		if(form1.txtTitulo.value == "") {
			alert("O campo Titulo deve ser preenchido.");
			form1.txtTitulo.focus();
			return false;
		}
		if(form1.txtSec.value == "") {
			alert("O campo Seção deve ser preenchido.");
			form1.txtSec.focus();
			return false;
		}
		
		if(form1.txtTipo.value == "") {
			alert("O campo Nivel deve ser preenchido.");
			form1.txtTipo.focus();
			return false;
		  }
		 
       	 
		 return form1.submit();
		 
         
}

function Vconceito(form1){
		
		if(form1.txtTitulo.value == "") {
			alert("O campo Titulo deve ser preenchido.");
			form1.txtTitulo.focus();
			return false;
		}
		return form1.submit();
         
}

function Vcategoria(nform){
		
		if(nform.txtTitulo.value == "") {
			alert("O campo Categoria deve ser preenchido.");
			nform.txtTitulo.focus();
			return false;
		}
		return true;
         
}
function Vpergunta(form1){
		
		if(form1.txtTitulo.value == "") {
			alert("O campo Titulo deve ser preenchido.");
			form1.txtTitulo.focus();
			return false;
		}
		if(form1.txtCategoria.value == "") {
			alert("O campo Categoria deve ser preenchido.");
			form1.txtCategoria.focus();
			return false;
		}
		
		if(form1.txtTipo.value == "") {
			alert("O campo Nivel deve ser preenchido.");
			form1.txtTipo.focus();
			return false;
		  }
		 return true;
         
}