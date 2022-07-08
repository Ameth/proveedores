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

$Consulta="Select NIT, CodigoSAP From tbl_Usuarios Where Password IS NULL";
$SQL=sqlsrv_query($conexion,$Consulta);
$sw=0;
$vOk="";
$cnt=1;
while($row=sqlsrv_fetch_array($SQL)){
	$Update="Update tbl_Usuarios set Password='".md5(str_replace("-","",$row['NIT']))."' Where CodigoSAP='".$row['CodigoSAP']."' and Password IS NULL";
	if(!sqlsrv_query($conexion,$Update)){
		$sw=1;
	}else{
		$vOk=$vOk.$cnt.". ".$row['CodigoSAP']." [OK]"."<br>";
		$cnt++;
	}
}
if($sw==0){
	echo $vOk;
	echo "<br>";
	echo "Procesos ejecutados correctamente!!";	
}else{
	echo "Ocurrio un error al ejecutar los procesos.";
}
sqlsrv_close($conexion);

?>