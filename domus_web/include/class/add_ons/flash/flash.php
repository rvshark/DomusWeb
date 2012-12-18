<?php
	require_once('getid3.php');

	function embed($swf, $width, $height, $flashvars=''){
		$swf = explode('.', $swf);
		array_pop($swf);
		$swf = implode('.', $swf);
		echo "<script language='javascript'>\n";
		echo " if(AC_FL_RunContent==0){alert('This page requires AC_RunActiveContent.js.');\n";
		echo "} else {\n";
		echo "AC_FL_RunContent(\n";
		echo "	'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',\n";
		echo "	'width', '$width',\n";
		echo "	'height', '$height',\n";
		echo "	'src', 'x',\n";
		echo "	'quality', 'high',\n";
		echo "	'pluginspage', 'http://www.macromedia.com/go/getflashplayer',\n";
		echo "	'align', 'middle',\n";
		echo "	'play', 'true',\n";
		echo "	'loop', 'true',\n";
		echo "	'scale', 'showall',\n";
		echo "	'FlashVars', '$flashvars',\n";
		echo "	'allowFullScreen', 'true',\n";
		echo "	'movie', '$swf'\n";
		echo "	);\n";
		echo "	}\n";
		echo "</script>\n";
		echo "<noscript>\n";
		echo "	<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0' width='$width' height='$height' align='middle'>\n";
		echo "	<param name='allowFullScreen' value='true'>\n";
		echo "	<param name='movie' value='$swf.swf??$flashvars' /><param name='quality' value='high' /><embed src='$swf.swf?$flashvars' width='$width' height='$height' align='middle' allowFullScreen='true' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer'>\n";
		echo "	</object>\n";
		echo "</noscript>\n";
	}

	function getflvsize($movie){
		$getID3 = new getID3;
		$fileinfo = $getID3->analyze($movie);
		$width = $fileinfo['meta']['onMetaData']['width'];
		$height = $fileinfo['meta']['onMetaData']['height'];
		return array($width, $height);
	}

	function flv($movie, $width=-1, $height=-1, $autoplay=false){
		if(!file_exists($movie))
			echo "Movie not found.";
		if($width == -1 || $height == -1)
			list($width, $height) = getflvsize($movie);

		$height += 40;

		embed('player.swf', $width, $height, "movie=$movie".($autoplay?'&autoplay=on':''));
	}
?>