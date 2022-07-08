<?php 

function PermitirAcceso($Permiso){//Para evitar acceder a la pagina
	global $conexion;
	$PaginaError="acceso_denegado.php";
	$Consulta="Select 1 From uvw_tbl_NombresPerfilesUsuarios Where ID_Permiso='".$Permiso."' and ID_PerfilUsuario='".$_SESSION['Perfil']."'";
	$SQL=sqlsrv_query($conexion,$Consulta,array(),array( "Scrollable" => 'static' ));
	$Num=sqlsrv_num_rows($SQL);
	if($Num==1){
		return true;
	}else{
		header("Location:".$PaginaError);
	}
}

function PermitirFuncion($Permiso){//Para evitar acceder a una opcion en particular
	global $conexion;
	$PaginaError="acceso_denegado.php";
	$Consulta="Select 1 From uvw_tbl_NombresPerfilesUsuarios Where ID_Permiso='".$Permiso."' and ID_PerfilUsuario='".$_SESSION['Perfil']."'";
	$SQL=sqlsrv_query($conexion,$Consulta,array(),array( "Scrollable" => 'static' ));
	$Num=sqlsrv_num_rows($SQL);
	if($Num==1){
		return true;
	}else{
		return false;
	}
}

function ConsultarPago($DocEntry, $CardCode){
	global $conexion;
	$Con="EXEC usp_ConsultarPagoFactura '".$DocEntry."', '".$CardCode."'";
	$SQL=sqlsrv_query($conexion,$Con);
	$row=sqlsrv_fetch_array($SQL);
	return $row;
}

function InsertarLog($Accion){
		global $conexion;
		$InsertLog="Insert Into tbl_Log Values ('".date('Y-m-d H:i:s')."','".$_SESSION['CodSAP']."','".$Accion."');";
		//echo $InsertLog;
		//exit();
		if(!sqlsrv_query($conexion,$InsertLog)){
			echo "Error al insertar Log";
			echo "<br>";
			echo $InsertLog;
			exit();
			}
		}
?>