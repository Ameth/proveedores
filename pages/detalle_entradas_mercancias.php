<?php 
if(isset($_GET['id'])&$_GET['id']!=""){
	include("includes/conexion.php");
	$ConsEnt="SELECT * FROM uvw_Sap_tbl_EntradasFromOrdenesCompras WHERE DocEntry='".base64_decode($_GET['id'])."'";
	$SQLEnt=sqlsrv_query($conexion,$ConsEnt);
	$rowEnt=sqlsrv_fetch_array($SQLEnt);
		
	$ConsOC="Select TOP 1 BaseDocNum From uvw_Sap_tbl_EntradasFromOrdenesComprasDetalles Where DocEntry='".base64_decode($_GET['id'])."'";
	$SQLOC=sqlsrv_query($conexion,$ConsOC);
	$rowOC=sqlsrv_fetch_array($SQLOC);
	
	$Consulta="Select * From uvw_Sap_tbl_EntradasFromOrdenesComprasDetalles Where DocEntry='".base64_decode($_GET['id'])."'";
	$SQL=sqlsrv_query($conexion,$Consulta);
	
	$SubTotal=0;
	
?>
<!DOCTYPE html>
<html lang="es"><!-- InstanceBegin template="/Templates/PlantillaProveedores.dwt.php" codeOutsideHTMLIsLocked="false" -->

<head>
<?php include("cabecera.php"); ?>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Portal de Proveedores - <?php echo EMPRESA;?></title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
</head>

<body <?php echo $onload_body;?>>

    <div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
 			<?php include("barra_superior.php"); ?>
            <!-- /.navbar-top-links -->

            <?php include("menu.php"); ?>
            <!-- /.navbar-static-side -->
        </nav>

      <div id="page-wrapper">
          <!-- InstanceBeginEditable name="EditRegion3" -->
          <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Entrada de mercanc&iacute;a: <?php echo $rowEnt['DocNum'];?><br>
			  <small>Orden de compra: <?php echo $rowOC['BaseDocNum'];?></small></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>          
           <!-- InstanceEndEditable -->
            <!-- InstanceBeginEditable name="EditRegion6" -->
             <div class="row">
            <div class="col-lg-2">
				<button class="btn btn-outline btn-primary" onClick="javascript:location.href='entradas_mercancias.php?<?php echo base64_decode($_GET['back']);?>'"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Regresar</button>
			</div>
		  </div>
		  <div class="row">&nbsp;</div>
            <!-- InstanceEndEditable -->            
            <div class="row"><!-- InstanceBeginEditable name="EditRegion4" -->
              <div class="col-lg-12">
                <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>C&oacute;digo</th>
                                            <th>Descripci&oacute;n</th>
                                            <th>Comentarios</th>
                                            <th>Cantidad</th>
                                            <th>Unidad</th>
                                            <th>Precio Unit.</th>
											<th>% Descuento</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php while($row=sqlsrv_fetch_array($SQL)){?>
										<tr>
											<td><?php echo $row['ItemCode'];?></td>
											<td><?php echo utf8_encode($row['ItemName']);?></td>
											<td><?php echo utf8_encode($row['FreeTxt']);?></td>
											<td align="right"><?php echo number_format($row['CantidadOrdenada'],2);?></td>
											<td><?php echo utf8_encode($row['NombreUnidadMedida']);?></td>											
											<td align="right"><?php echo number_format($row['Price'],2);?></td>
											<td align="right"><?php echo number_format($row['DiscPrcnt'],2);?></td>
											<td align="right"><?php echo number_format($row['LineTotal'],2);?></td>
										</tr>
                                    <?php $SubTotal=$SubTotal+$row['LineTotal'];}?>
                                    	<tr>
											<td colspan="7" align="right">SUBTOTAL</td>
											<td align="right"><?php echo number_format($SubTotal,2);?></td>
										</tr>
                                  		<tr>
											<td colspan="7" align="right">IVA</td>
											<td align="right"><?php echo number_format($rowEnt['VatSum'],2);?></td>
										</tr>
                                   		<tr>
											<td colspan="7" align="right"><strong>TOTAL</strong></td>
											<td align="right"><strong><?php echo number_format($rowEnt['DocTotal'],2);?></strong></td>
										</tr>
                                  		<tr>
											<td colspan="8"><strong>Comentarios</strong></td>
										</tr>
                                   		<tr>
											<td colspan="8"><?php echo utf8_encode($rowEnt['Comments']);?></td>
										</tr>
                                    </tbody>
                                </table>
                            </div>
              </div>
          <!-- InstanceEndEditable --></div>
          <!-- /.row -->
          <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <?php include("includes/pie.php"); ?>
<!-- InstanceBeginEditable name="EditRegion5" -->
   
   <!-- InstanceEndEditable -->    
</body>

<!-- InstanceEnd --></html>
<?php sqlsrv_close($conexion);}?>
