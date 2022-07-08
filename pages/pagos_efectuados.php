<?php include("includes/conexion.php"); 
if(isset($_GET['MM_Pagos'])&&$_GET['MM_Pagos']=="form_Pagos"){
	$FechaInicial=$_GET['FechaInicial'];
	$FechaFinal=$_GET['FechaFinal'];
	$FiltroFecha=$_GET['FiltroFecha'];
}else{
	/** Actual month first day **/
	function PrimerDiaMes(){
	  $month = date('m');
	  $year = date('Y');
	  return date('m/d/Y', mktime(0,0,0, $month, 1, $year));
	}
	$FechaInicial=PrimerDiaMes();
	$FechaFinal=date('m/d/Y');
	$FiltroFecha="FechaPago";
}
$Consulta="SELECT * FROM uvw_Sap_tbl_Pagos_Efectuados WHERE CardCode = '".$_SESSION['CodSAP']."' and ".$FiltroFecha." Between '".$FechaInicial."' and '".$FechaFinal."'";
$SQL=sqlsrv_query($conexion,$Consulta);
//InsertarLog("Consulta de pagos efectuados");
?>
<!DOCTYPE html>
<html lang="es"><!-- InstanceBegin template="/Templates/PlantillaProveedores.dwt.php" codeOutsideHTMLIsLocked="false" -->

<head>
<?php include("cabecera.php"); ?>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Portal de Proveedores - <?php echo EMPRESA;?></title>
  <script>
	 $( function() {
		$( "#FechaInicial" ).datepicker({
      		changeMonth: true,
      		changeYear: true
    	});
		$( "#FechaInicial" ).datepicker($.datepicker.regional['es']);
		$( "#FechaInicial" ).on( "change", function() {
			$( "#FechaInicial" ).datepicker( "option", "dateFormat", "mm/dd/yy" );
		});
		$( "#FechaFinal" ).datepicker({
      		changeMonth: true,
      		changeYear: true
    	});
		$( "#FechaFinal" ).datepicker($.datepicker.regional['es']);
		$( "#FechaFinal" ).on( "change", function() {
			$( "#FechaFinal" ).datepicker( "option", "dateFormat", "mm/dd/yy" );
		});
	  } );
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
                    <h3 class="page-header">Pagos efectuados</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
<!-- InstanceEndEditable -->
            <!-- InstanceBeginEditable name="EditRegion6" -->
            <div class="row">
            <form action="pagos_efectuados.php" method="get" name="form_Pagos" class="form-horizontal" id="form_Pagos">
				<div class="form-group">
					<div class="col-lg-1"><strong>Filtro fecha</strong></div>
					<div class="col-lg-2">
						<select name="FiltroFecha" id="FiltroFecha" class="form-control">
							<option value="FechaContFactura" <?php if($FiltroFecha=="FechaContFactura"){echo "selected=\"selected\"";}?>>Fecha factura</option>
							<option value="FechaVencFactura" <?php if($FiltroFecha=="FechaVencFactura"){echo "selected=\"selected\"";}?>>Fecha vencimiento</option>
							<option value="FechaPago" <?php if($FiltroFecha=="FechaPago"){echo "selected=\"selected\"";}?>>Fecha pago</option>
						</select>
					</div>
					<div class="col-lg-1"><strong>Fecha inicio</strong></div>
					<div class="col-lg-2"><input name="FechaInicial" type="text" class="form-control" id="FechaInicial" value="<?php echo $FechaInicial; ?>" maxlength="10"></div>
					<div class="col-lg-1"><strong>Fecha final</strong></div>
					<div class="col-lg-2"><input name="FechaFinal" type="text" class="form-control" id="FechaFinal" value="<?php echo $FechaFinal; ?>" maxlength="10"></div>
					<div class="col-lg-3"><button type="submit" class="btn btn-outline btn-info"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Buscar</button></div>
				</div>
				<input type="hidden" name="MM_Pagos" id="MM_Pagos" value="form_Pagos">
			</form>
		  </div>
		  <div class="row">&nbsp;</div>
            <!-- InstanceEndEditable -->            
            <div class="row"><!-- InstanceBeginEditable name="EditRegion4" -->
              <div class="col-lg-12">
               <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Factura</th>
                                        <th>Fecha factura</th>
                                        <th>Fecha vencimiento</th>
                                        <th>N&uacute;m. Interno</th>
                                        <th>Valor factura</th>
                                        <th>Valor pagado</th>
                                        <th>Fecha pago</th>                                       
                                        <th>Efectivo</th>
                                        <th>Transferencia</th>
                                        <th>Cheque</th>
                                        <th>N&uacute;m. Cheque</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php while($row=sqlsrv_fetch_array($SQL)){ ?>
                                    <tr class="odd gradeX">
                                        <td><?php if($row['FacturaProveedor']!=""){?><a href="detalle_facturas_proveedores.php?id=<?php echo base64_encode($row['NumIntFactura']);?>&back=<?php echo base64_encode($_SERVER['QUERY_STRING']);?>&doc=2"><?php echo $row['FacturaProveedor'];?></a><?php }else{echo "--";}?></td>
                                        <td><?php if($row['FechaContFactura']!=""){echo $row['FechaContFactura']->format('Y-m-d');}else{echo "--";}?></td>
                                        <td><?php if($row['FechaVencFactura']!=""){echo $row['FechaVencFactura']->format('Y-m-d');}else{echo "--";}?></td>
                                        <td><?php echo $row['NumPagoEfectuado'];?></td>
                                        <td align="right"><?php echo number_format($row['DocTotal'],2);?></td>
                                        <td align="right"><?php echo number_format($row['ValorPago'],2);?></td>
                                        <td><?php if($row['FechaPago']!=""){echo $row['FechaPago']->format('Y-m-d');}else{echo "--";}?></td>          
                                        <td align="right"><?php echo number_format($row['CashSum'],2);?></td>
                                        <td align="right"><?php echo number_format($row['TrsfrSum'],2);?></td>
                                        <td align="right"><?php echo number_format($row['CheckSum'],2);?></td>
                                        <td align="right"><?php echo $row['CheckNum'];?></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
              </div>
               <div class="row">
		  	 <div class="col-lg-12">
                   <div class="col-lg-1"><a href="exportar_excel.php?exp=2&Cons=<?php echo base64_encode($Consulta);?>"><img src="../dist/css/exp_excel.png" width="50" height="30" alt="Exportar a Excel" title="Exportar a Excel"/></a></div>
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
   <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
			language: {
				"decimal":        "",
				"emptyTable":     "No se encontraron resultados.",
				"info":           "Mostrando _START_ - _END_ de _TOTAL_ registros",
				"infoEmpty":      "Mostrando 0 - 0 de 0 registros",
				"infoFiltered":   "(filtrando de _MAX_ registros)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Mostrar _MENU_ registros",
				"loadingRecords": "Cargando...",
				"processing":     "Procesando...",
				"search":         "Filtrar:",
				"zeroRecords":    "Ningún registro encontrado",
				"paginate": {
					"first":      "Primero",
					"last":       "Último",
					"next":       "Siguiente",
					"previous":   "Anterior"
				},
				"aria": {
					"sortAscending":  ": Activar para ordenar la columna ascendente",
					"sortDescending": ": Activar para ordenar la columna descendente"
				}
			}
        });
    });
    </script>
   <!-- InstanceEndEditable -->    
</body>

<!-- InstanceEnd --></html>
