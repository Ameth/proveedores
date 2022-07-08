<?php 
if (!isset($_SESSION)) {
  session_start();
}
if (!isset($_SESSION['User'])||$_SESSION['User']=="") {
	if(file_exists('logout.php')){
		header('Location:logout.php');		
		}else{
			header('Location:../logout.php');
		}
	exit();
}
require_once("conect.php");
$onload_body="onLoad='Reloj();' onkeyup='ResetC();' onclick='ResetC();' onMouseOver='ResetC();' onMouseOut='ResetC();'";
if(file_exists("funciones.php")){
	include("funciones.php");
	include_once("define.php");
	include_once("LSiqmL.php");
}else{
	include("includes/funciones.php");
	include_once("includes/define.php");
	include_once("includes/LSiqmL.php");
}

?>