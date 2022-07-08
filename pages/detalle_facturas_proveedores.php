<?php 
if(isset($_GET['id'])&$_GET['id']!=""){
	include("includes/conexion.php");
	$ConsFact="SELECT * FROM uvw_Sap_tbl_FacturasProveedores WHERE DocEntry='".base64_decode($_GET['id'])."'";
	$SQLFact=sqlsrv_query($conexion,$ConsFact);
	$rowFact=sqlsrv_fetch_array($SQLFact);
		
	$ConsEnt="Select TOP 1 BaseDocNum From uvw_Sap_tbl_FacturasProveedoresDetalles Where DocEntry='".base64_decode($_GET['id'])."'";
	$SQLEnt=sqlsrv_query($conexion,$ConsEnt);
	$rowEnt=sqlsrv_fetch_array($SQLEnt);
	
	//Retenciones
	$ConsRet="Select * From uvw_Sap_tbl_FacturasProveedoresRetenciones Where DocEntry='".base64_decode($_GET['id'])."'";
	$SQLRet=sqlsrv_query($conexion,$ConsRet);
	$SumRet=0;
	while($rowRet=sqlsrv_fetch_array($SQLRet)){
		$SumRet=$SumRet+$rowRet['WTAmnt'];
	}
	
	$Consulta="Select * From uvw_Sap_tbl_FacturasProveedoresDetalles Where DocEntry='".base64_decode($_GET['id'])."'";
	$SQL=sqlsrv_query($conexion,$Consulta);
	
	$SubTotal=0;
	
?>
<!DOCTYPE html>
<html lang="es"><!-- InstanceBegin template="/Templates/PlantillaProveedores.dwt.php" codeOutsideHTMLIsLocked="false" -->

<head>
<?php include("cabecera.php"); ?>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Portal de Proveedores - <?php echo EMPRESA;?></title>
<script>
function MostrarRet(){
	var posicion_x; 
	var posicion_y;  
	posicion_x=(screen.width/2)-(1200/2);  
	posicion_y=(screen.height/2)-(500/2); 
	remote=open('ajx_retenciones_factura.php?id=<?php echo base64_encode($rowFact['DocEntry']);?>','remote',"width=1200,height=300,location=no,scrollbars=yes,menubars=no,toolbars=no,resizable=no,fullscreen=no,directories=no,status=yes,left="+posicion_x+",top="+posicion_y+"");
	remote.focus();					
}
</script>
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
                    <h3 class="page-header">N&uacute;mero interno: <?php echo $rowFact['DocNum'];?><br>
			  <small>Entrada: <?php echo $rowEnt['BaseDocNum'];?></small><br>
			  <small>N&uacute;m. Factura proveedor: <?php echo $rowFact['NumAtCard'];?></small></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
         <!-- InstanceEndEditable -->
            <!-- InstanceBeginEditable name="EditRegion6" -->
             <div class="row">
            <div class="col-lg-2">
				<?php 
					if($_GET['doc']==1){//Facturas de proveedores
						$Back="facturas_proveedores.php?".base64_decode($_GET['back']);
					}else{// 2. Pagos efectudados
						$Back="pagos_efectuados.php?".base64_decode($_GET['back']);
					}?>
				<button class="btn btn-outline btn-primary" onClick="javascript:location.href='<?php echo $Back;?>'"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Regresar</button>
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
                                            <th>Precio</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php while($row=sqlsrv_fetch_array($SQL)){?>
										<tr>
											<td><?php echo $row['ItemCode'];?></td>
											<td><?php echo utf8_encode($row['ItemName']);?></td>
											<td><?php echo utf8_encode($row['FreeTxt']);?></td>
											<td align="right"><?php echo number_format($row['Quantity'],2);?></td>
											<td><?php echo utf8_encode($row['unitMsr']);?></td>											
											<td align="right"><?php echo number_format($row['Price'],2);?></td>
											<td align="right"><?php echo number_format($row['LineTotal'],2);?></td>
										</tr>
                                    <?php $SubTotal=$SubTotal+$row['LineTotal'];}?>
                                    	<tr>
											<td colspan="6" align="right">SUBTOTAL</td>
											<td align="right"><?php echo number_format($SubTotal,2);?></td>
										</tr>
                                  		<tr>
											<td colspan="6" align="right">IVA</td>
											<td align="right"><?php echo number_format($rowFact['VatSum'],2);?></td>
										</tr>
                                  		<tr>
											<td colspan="6" align="right"><?php if($SumRet>0){?><a href="#" onClick="MostrarRet();">RETENCIONES</a><?php }else{?>RETENCIONES<?php }?></td>
											<td align="right"><?php echo number_format($SumRet,2);?></td>
										</tr>
                                   		<tr>
											<td colspan="6" align="right"><strong>TOTAL</strong></td>
											<td align="right"><strong><?php echo number_format($rowFact['DocTotal'],2);?></strong></td>
										</tr>
                                  		<tr>
											<td colspan="7"><strong>Comentarios</strong></td>
										</tr>
                                   		<tr>
											<td colspan="7"><?php echo utf8_encode($rowFact['Comments']);?></td>
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
