
<?php
$horario = date(" Y-m-d H:i:s");
 echo $horario;
 echo preg_replace('/\/(.*?)\/.*/','\\1',$_SERVER['REQUEST_URI']);
?>
  'http://<?php echo $_SERVER['SERVER_NAME'] . ':' . ($_SERVER['PORT'] == ''?'80':$_SERVER['PORT']) . '/'  ?>'

