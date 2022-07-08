<?php 
date_default_timezone_set('America/Bogota');
$usuario='sa';
$password='Asdf1234$';
$servidor='(local)';
$database='PortalProveedores';
$connectionInfo = array( "UID"=>$usuario,"PWD"=>$password,"Database"=>$database);
$conexion=sqlsrv_connect($servidor,$connectionInfo);
if( $conexion === false ){
	echo "No es posible conectarse al servidor.</br>";
	exit(print_r( sqlsrv_errors(), true));
}
?>