<?php
require_once ("../config.php");

public function getCidade($id_estado) {
    $conexao = new Conexao();
    $query = "SELECT id_cidade, nome , capital FROM cidades WHERE id_estado=$id_estado ORDER BY nome";
    $conexao->setConsulta($query);
    $sql = $conexao->getConsulta();
    $mostra = $conexao->fetchAll();
    return $mostra;
}

public function getUf() {
    $conexao = new Conexao();
    $query = "SELECT id_estado,uf FROM estados ORDER BY uf";
    $conexao->setConsulta($query);
    $mostra = $conexao->fetchAll();
    return $mostra;
}

$query="SELECT * FROM mdl_cidade";
$sql = execute_sql ();

/*$id_estado = intval( $_REQUEST['id_estado'] );
$ufcidades = new UFcidade();
$cidade = $ufcidades->getCidade($id_estado);

echo( json_encode( $cidade ) );*/

print_r($sql);



$array.="[['City','Downloads'],";
$array.="['Paraná',229],";
$array.="['Pará',2],";
$array.="['Bahia',21],";
$array.="]";
$html.="<html>
  <head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>";

     $html.="google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawMarkersMap);

      function drawMarkersMap() {
      var data = google.visualization.arrayToDataTable($array);

      var options = {
        region: 'BR',
        displayMode: 'markers',
        width: 960,
        height : 580,
		keepAspectRatio : false,
        datalessRegionColor	: '#CAE1FF',
      
        colorAxis: {colors: ['green', 'blue']}
      };

      var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    };";

   $html.=" </script>";
$html.="<script type='text/javascript'>
      google.load('visualization', '1', {packages:['corechart']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Ano', 'Downloads'],
          ['2012',       300],
          ['2013',     100],
         
        ]);

        var options = {
          title: 'Downloads Domus',

          vAxis: {title: 'Ano',  titleTextStyle: {color: 'red'}},
          chartArea : {width : '330' , left: '20', height : '80'},
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
    </script>";  

$html.="</head>
  <body>

<div id='chart_div' style='position:absolute; width: 960px; height: 400px; z-index:0; margin-left:0px;top:10px'></div>
<div id='chart_div2' style='position:absolute; width: 450px; height: 120px; padding:0px; z-index:1; margin-left:540px; margin-top:420px;'></div>

  </body>
</html>";

print $html;
//print_r($array);
?>