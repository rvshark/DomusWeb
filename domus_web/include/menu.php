<?php 
switch($_SESSION['userNivel']){
	
	case "7":
		include("menu5.php");
	break;
	case "6":
		include("menu5.php");
	break;
	case "5":
		include("menu5.php");
	break;
	case "4":
		include("menu4.php");
	break;
	case "3":
		include("menu3.php");
	break;	
	case "2":
		include("menu2.php");
	break;
	case "1":
		include("menu1.php");
	break;
	case "0":
		include("menu5.php");
	break;
}
?>
