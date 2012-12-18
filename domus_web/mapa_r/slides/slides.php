<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title>Domus</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />		
		<link rel="stylesheet" href="engine_slides/css/videolightbox.css" type="text/css" />
		<style type="text/css">#videogallery a#videolb{display:none}</style>
		
			<link rel="stylesheet" type="text/css" href="engine/css/overlay-minimal.css"/>
			<script src="engine_slides/js/jquery.tools.min.js" type="text/javascript"></script>
			<script src="engine_slides/js/swfobject.js" type="text/javascript"></script>
			<script src="engine_slides/js/videolightbox.js" type="text/javascript"></script>

	</head>
		<body>
<script type="text/javascript">

function onYouTubePlayerReady(playerId) { 
ytplayer = document.getElementById("video_overlay"); 
ytplayer.setVolume(100); 
} 

</script>
<div id="topo"></div>
<div id="main">

	<div id="titles">
		
	</div> 
	<div id="videogallery">
	<?php 
	
		$toUrl = $_GET["slide"];
		$name = $_GET["iN"];
	
	?>	
	
	
	
		<?php
			include '../videos/Util.php';
			pegaSlides("../../mapa_r/slides/arquivos_slide/".$toUrl."/", ".ppt;.pps;ppsx")
		?>
				
</div>
</div>
<div id="footer"></div>


	</body>
</html>
