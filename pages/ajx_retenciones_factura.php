<?php 
if(isset($_GET['id'])&$_GET['id']!=""){
	include("includes/conexion.php");
	
	//Retenciones
	$ConsRet="Select * From uvw_Sap_tbl_FacturasProveedoresRetenciones Where DocEntry='".base64_decode($_GET['id'])."'";
	$SQLRet=sqlsrv_query($conexion,$ConsRet);
	
?>
<!doctype html>
<html>
<head>
<?php include("cabecera.php"); ?>
<title>Portal de Proveedores - Retenciones de factura</title>
</head>

<body>
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Código</th>
				<th>Nombre</th>
				<th>Tarifa</th>
				<th>Retención</th>
				<th>Base retención</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$i=1;
			while($rowRet=sqlsrv_fetch_array($SQLRet)){?>
			<tr>
				<td><?php echo $i;?></td>
				<td><?php echo $rowRet['WTCode'];?></td>
				<td><?php echo utf8_encode($rowRet['WTName']);?></td>
				<td><?php echo number_format($rowRet['Rate'],2);?></td>
				<td><?php echo number_format($rowRet['WTAmnt'],2);?></td>
				<td><?php echo number_format($rowRet['U_HBT_BaseRet'],2);?></td>
			</tr>
		<?php $i++;}?>
		</tbody>
	</table>
</div>
</body>
</html>
<?php sqlsrv_close($conexion);}?>