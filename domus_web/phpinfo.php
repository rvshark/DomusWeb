
<?php
global $CFG;
    require_once 'lib/htmlpurifier/library/HTMLPurifier.auto.php';
      $config = HTMLPurifier_Config::createDefault();
	//$config->set('HTML', 'DefinitionID', 'enduser-customize1.html tutorial1');
	//$config->set('HTML', 'DefinitionRev', 2);
	//$config->set('Core', 'LexerImpl', 'DirectLex');
        
        
        
        
	$def2 = $config->getHTMLDefinition(true);
        
	
        $def2->addAttribute('a','id', 'CDATA');
        $def2->addAttribute('a','name', 'CDATA');
	$purifier = new HTMLPurifier($config);
        $teste = $purifier->purify( '<a name="12312" id="dsfasd2" >Luiz</a>' );
        echo  $teste;
?>

<?php

phpinfo() 
?>
