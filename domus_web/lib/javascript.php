<?php  /// $Id: javascript.php,v 1.36.2.4 2009/03/31 03:24:15 tjhunt Exp $
       /// Load up any required Javascript libraries

    if (!defined('MOODLE_INTERNAL')) {
        die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
    }

    if (!empty($CFG->aspellpath)) {      // Enable global access to spelling feature.
        echo '<script type="text/javascript" src="'.$CFG->httpswwwroot.'/lib/speller/spellChecker.js"></script>'."\n";
    }

    if (!empty($CFG->editorsrc) ) {
        foreach ( $CFG->editorsrc as $scriptsource ) {
            echo '<script type="text/javascript" src="'. $scriptsource .'"></script>'."\n";
        }
    }

?>
<!--<style type="text/css">/*<![CDATA[*/ body{behavior:url(<?php echo $CFG->httpswwwroot ?>/lib/csshover.htc);} /*]]>*/</style>-->

<script type="text/javascript" src="<?php echo $CFG->httpswwwroot ?>/lib/javascript-static.js"></script>
<script type="text/javascript" src="<?php echo $CFG->httpswwwroot ?>/lib/overlib/overlib.js"></script>
<script type="text/javascript" src="<?php echo $CFG->httpswwwroot ?>/lib/overlib/overlib_cssstyle.js"></script>
<script type="text/javascript" src="<?php echo $CFG->httpswwwroot ?>/lib/cookies.js"></script>
<script type="text/javascript" src="<?php echo $CFG->httpswwwroot ?>/lib/ufo.js"></script>
<!--<script type="text/javascript" src="<?php echo $CFG->httpswwwroot ?>/lib/dropdown.js"></script>  -->



<?php 

if($_GET["id"] == 35)
{
echo '<script type="text/javascript" src="'.$CFG->httpswwwroot.'/lib/javascript-mod.php"></script>';
}
else
{
?>

<?php //---------------------------Biblioteca utilizada para montar o menu principal------------------------- ?>
<script type="text/javascript" language="javascript">var urlBase="<?php echo $CFG->httpswwwroot ?>"</script>
<script type="text/javascript" src="<?php echo $CFG->httpswwwroot ?>/blocks/menu_curso/js/menu.js"></script>
<?php //----------------------------------------------------------------------------------------------------- ?>

<script type="text/javascript" src="<?php echo $CFG->wwwroot ?>/include/js/TreeMenu.js"></script>
<script type="text/javascript" src="<?php echo $CFG->httpswwwroot ?>/include/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo $CFG->httpswwwroot ?>/include/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $CFG->httpswwwroot ?>/include/js/jquery.lightbox-0.5.js"></script>
<script type="text/javascript" src="<?php echo $CFG->httpswwwroot ?>/include/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo $CFG->httpswwwroot ?>/include/js/jquery.maskedinput-1.2.2.js"></script>


<script type="text/javascript" src="<?php echo $CFG->httpswwwroot ?>/include/js/JQueryUI-Custom/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo $CFG->httpswwwroot ?>/include/js/JQueryUI-Custom/jquery.ui.dialog.js"></script>
<script type="text/javascript" src="<?php echo $CFG->httpswwwroot ?>/include/js/JQueryUI-Custom/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo $CFG->httpswwwroot ?>/include/js/JQueryUI-Custom/jquery.ui.button.js"></script>
<script type="text/javascript" src="<?php echo $CFG->httpswwwroot ?>/include/js/JQueryUI-Custom/jquery.ui.position.js"></script>




<script type="text/javascript">			
				
            $(document).ready(function(){
				$("#main,.coperacao,.nav").show();
				$('#main_carregando').hide();
            	$('#gallery a').lightBox();
            	$('#header-content').append("<div class='logo'></div>");
            	$('.logo').click(function(){window.location.href = "<?php echo $CFG->wwwroot ?>";})
			});

            function Atividades(cursoId)
            {
                
		          if (cursoId <= 0)
		              return;
	              
	              if (window.XMLHttpRequest)
	              {// code for IE7+, Firefox, Chrome, Opera, Safari
	              	xmlhttp=new XMLHttpRequest();
	              }
	              else
	              {// code for IE6, IE5
	              	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	              }
	              
	              xmlhttp.onreadystatechange=function()
	              {
		             if (xmlhttp.readyState==4 && xmlhttp.status==200)
		                {
		            	 	window.location.reload();
		                }
	              }

	              xmlhttp.open("GET","<?php echo $CFG->httpswwwroot ?>/blocks/menu_curso/Curso.php?id="+cursoId,true);
	              xmlhttp.send();
            }
			
</script>
<?php
}


/*
else if($id != ""){
echo '<script type="text/javascript" src="'.$CFG->httpswwwroot.'/include/js/jquery.js"></script>';
echo '<script type="text/javascript" src="'.$CFG->httpswwwroot.'/include/js/jquery.lightbox-0.5.js"></script>';
echo '<link rel="stylesheet" type="text/css" href="'.$CFG->httpswwwroot.'/include/css/jquery.lightbox-0.5.css" media="screen" />
		<script type="text/javascript">
	   		 $(function() {
	        	$(\'#gallery a\').lightBox();
	    	 });
			 </script>';
}
*/

?>


<script type="text/javascript" defer="defer">
//<![CDATA[
setTimeout('fix_column_widths()', 20);
//]]>
</script>
<script type="text/javascript">
//<![CDATA[
function openpopup(url, name, options, fullscreen) {

	//pega a resolu��o do visitante
	w = screen.width;
	h = screen.height;

	//divide a resolução por 2, obtendo o centro do monitor
	meio_w = w/2;
	meio_h = h/2;

	//diminui o valor da metade da resolu��o pelo tamanho da janela, fazendo com q ela fique centralizada
	altura2 = 500/2;
	largura2 = 750/2;
	
	meio1 = meio_h-altura2;
	meio2 = meio_w-largura2;
	
    var fullurl = "<?php echo $CFG->httpswwwroot ?>" + url;
    var windowobj = window.open(fullurl, name, options + 'top=' + meio1 +',left='+ meio2);
    if (!windowobj) {
        return true;
    }
    if (fullscreen) {
        windowobj.moveTo(0, 0);
        windowobj.resizeTo(screen.availWidth, screen.availHeight);
    }
    windowobj.focus();
    return false;
}

function uncheckall() {
    var inputs = document.getElementsByTagName('input');
    for(var i = 0; i < inputs.length; i++) {
        inputs[i].checked = false;
    }
}

function checkall() {
    var inputs = document.getElementsByTagName('input');
    for(var i = 0; i < inputs.length; i++) {
        inputs[i].checked = true;
    }
}

function inserttext(text) {
<?php
    if (!empty($SESSION->inserttextform)) {
        $insertfield = "opener.document.forms['$SESSION->inserttextform'].$SESSION->inserttextfield";
    } else {
        $insertfield = "opener.document.forms['theform'].message";
    }
    echo "  text = ' ' + text + ' ';\n";
    echo "  if ( $insertfield.createTextRange && $insertfield.caretPos) {\n";
    echo "    var caretPos = $insertfield.caretPos;\n";
    echo "    caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;\n";
    echo "  } else {\n";
    echo "    $insertfield.value  += text;\n";
    echo "  }\n";
    echo "  $insertfield.focus();\n";
?>
}
<?php if (!empty($focus)) {
    if(($pos = strpos($focus, '.')) !== false) {
        //old style focus using form name - no allowed inXHTML Strict
        $topelement = substr($focus, 0, $pos);
        echo "addonload(function() { if(document.$topelement) document.$focus.focus(); });\n";
    } else {
        //focus element with given id
        echo "addonload(function() { if(el = document.getElementById('$focus')) el.focus(); });\n";
    }
    $focus=false; // Prevent themes from adding it to body tag which breaks addonload(), MDL-10249
} ?>

function getElementsByClassName(oElm, strTagName, oClassNames){
	var arrElements = (strTagName == "*" && oElm.all)? oElm.all : oElm.getElementsByTagName(strTagName);
	var arrReturnElements = new Array();
	var arrRegExpClassNames = new Array();
	if(typeof oClassNames == "object"){
		for(var i=0; i<oClassNames.length; i++){
			arrRegExpClassNames.push(new RegExp("(^|\\s)" + oClassNames[i].replace(/\-/g, "\\-") + "(\\s|$)"));
		}
	}
	else{
		arrRegExpClassNames.push(new RegExp("(^|\\s)" + oClassNames.replace(/\-/g, "\\-") + "(\\s|$)"));
	}
	var oElement;
	var bMatchesAll;
	for(var j=0; j<arrElements.length; j++){
		oElement = arrElements[j];
		bMatchesAll = true;
		for(var k=0; k<arrRegExpClassNames.length; k++){
			if(!arrRegExpClassNames[k].test(oElement.className)){
				bMatchesAll = false;
				break;
			}
		}
		if(bMatchesAll){
			arrReturnElements.push(oElement);
		}
	}
	return (arrReturnElements)
}
//]]>
</script>
