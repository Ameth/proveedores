<?php include("includes/conexion.php");
$FilEstado=0;
if(isset($_GET['MM_Fact'])&&$_GET['MM_Fact']=="form_Fact"){
	$FechaInicial=$_GET['FechaInicial'];
	$FechaFinal=$_GET['FechaFinal'];
}else{
	/** Actual month first day **/
	function PrimerDiaMes(){
	  $month = date('m');
	  $year = date('Y');
	  return date('m/d/Y', mktime(0,0,0, $month, 1, $year));
	}
	$FechaInicial=PrimerDiaMes();
	$FechaFinal=date('m/d/Y');
}
if(isset($_GET['Estado'])){
	$FilEstado=$_GET['Estado'];
}else{
	$FilEstado=0;
}
$Consulta="SELECT * FROM uvw_Sap_tbl_FacturasProveedores WHERE CardCode = '".$_SESSION['CodSAP']."' and DocDate Between '".$FechaInicial."' and '".$FechaFinal."'";
$SQL=sqlsrv_query($conexion,$Consulta);
//InsertarLog("Consulta de factura de proveedor");
?>
<!DOCTYPE html>
<html lang="es"><!-- InstanceBegin template="/Templates/PlantillaProveedores.dwt.php" codeOutsideHTMLIsLocked="false" -->

<head>
<?php include("cabecera.php"); ?>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Portal de Proveedores - <?php echo EMPRESA;?></title>
<script>
  $( function() {
    var dateFormat = "mm/dd/yy",
      from = $( "#FechaInicial" )
        .datepicker({
          //defaultDate: "+1w",
          changeMonth: true,
          changeYear: true
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
		  //$( "#FechaInicial" ).datepicker( "option", "dateFormat", "dd/mm/yy" );
        }),
      to = $( "#FechaFinal" ).datepicker({
		  changeMonth: true,
          changeYear: true
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
		//$( "#FechaFinal" ).datepicker( "option", "dateFormat", "dd/mm/yy" );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
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
                    <h3 class="page-header">Facturas de proveedores</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
<!-- InstanceEndEditable -->
            <!-- InstanceBeginEditable name="EditRegion6" -->
		  
            <div class="row">
            <form action="facturas_proveedores.php" method="get" name="form_Fact" class="form-horizontal" id="form_Fact">
				<div class="form-group">
					<div class="col-lg-1"><strong>Fecha inicio</strong></div>
					<div class="col-lg-2"><input name="FechaInicial" type="text" required class="form-control" id="FechaInicial" value="<?php echo $FechaInicial;?>" maxlength="10"></div>
					<div class="col-lg-1"><strong>Fecha final</strong></div>
					<div class="col-lg-2"><input name="FechaFinal" type="text" required class="form-control" id="FechaFinal" value="<?php echo $FechaFinal;?>" maxlength="10"></div>
					<div class="col-lg-1"><strong>Estado</strong></div>
					<div class="col-lg-2">
						<select name="Estado" id="Estado" class="form-control">
							<option value="0" <?php if($FilEstado==0){echo "selected=\"selected\"";}?>>(Todos)</option>
							<option value="1" <?php if($FilEstado==1){echo "selected=\"selected\"";}?>>Pagada</option>
							<option value="2" <?php if($FilEstado==2){echo "selected=\"selected\"";}?>>Abonada</option>
							<option value="3" <?php if($FilEstado==3){echo "selected=\"selected\"";}?>>Pendiente de pago</option>
						</select>
					</div>
					<div class="col-lg-3"><button type="submit" class="btn btn-outline btn-info"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Buscar</button></div>
				</div>
				<input type="hidden" name="MM_Fact" id="MM_Fact" value="form_Fact">
			</form>
		  </div>
		  <div class="row">&nbsp;</div>
            <!-- InstanceEndEditable -->            
            <div class="row"><!-- InstanceBeginEditable name="EditRegion4" -->
              <div class="col-lg-12">
               <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>N&uacute;m. Interno</th>
                                        <th>Proyecto</th>
                                        <th>Fecha de factura</th>
                                        <th>Fecha de registro</th>
                                        <th>N&uacute;m. Factura Proveedor</th>
                                        <th>Valor factura</th>
                                        <th>Estado</th>
                                        <th>Fecha pago</th>
                                        <th>Valor pagado</th>
                                        <th>Saldo pendiente</th>                                                                            
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php 
									if($FilEstado==1){//Filtro de estado - Pagada
										while($row=sqlsrv_fetch_array($SQL)){
											$dPago=ConsultarPago($row['DocEntry'], $row['CardCode']);
											if($dPago['DocNum']!=""){
									?>
											<tr class="odd gradeX">
												<td><?php echo $row['DocNum'];?></td>
												<td><?php echo utf8_encode($row['PrjName']);?></td>
												<td><?php echo $row['DocDate']->format('Y-m-d');?></td>
												<td><?php echo $row['CreateDate']->format('Y-m-d');?></td>
												<td><?php echo $row['NumAtCard'];?></td>
												<td align="right"><?php echo number_format($row['DocTotal'],2);?></td>
												<td><?php if($dPago['DocNum']!=""){ echo "Pagada"; }else{ echo "Pendiente de pago";}?></td>
												<td><?php if($dPago['DocNum']!=""){ echo $dPago['FechaPago']->format('Y-m-d'); }else{ echo "--";}?></td>				
												<td align="right"><?php if($dPago['DocNum']!=""){ echo number_format($row['ValorPago'],2);}else{ echo "--";}?></td>	
												<td align="right"><?php echo number_format($row['SaldoPendiente'],2);?></td>
												<td><a href="detalle_facturas_proveedores.php?id=<?php echo base64_encode($row['DocEntry']);?>&back=<?php echo base64_encode($_SERVER['QUERY_STRING']);?>&doc=1">Ver detalles</a></td>
											</tr>
                                   <?php 	}
										}
									}elseif($FilEstado==2){//Filtro de estado - Abonada
										while($row=sqlsrv_fetch_array($SQL)){
											$dPago=ConsultarPago($row['DocEntry'], $row['CardCode']);
											if(($dPago['DocNum']!="")&&($row['SaldoPendiente']>0)){
									?>
											<tr class="odd gradeX">
												<td><?php echo $row['DocNum'];?></td>
												<td><?php echo utf8_encode($row['PrjName']);?></td>
												<td><?php echo $row['DocDate']->format('Y-m-d');?></td>
												<td><?php echo $row['CreateDate']->format('Y-m-d');?></td>
												<td><?php echo $row['NumAtCard'];?></td>
												<td align="right"><?php echo number_format($row['DocTotal'],2);?></td>
												<td><?php if(($dPago['DocNum']!="")&&($row['SaldoPendiente']>0)){ echo "Abonada"; }else{ echo "Pendiente de pago";}?></td>
												<td><?php if($dPago['DocNum']!=""){ echo $dPago['FechaPago']->format('Y-m-d'); }else{ echo "--";}?></td>				
												<td align="right"><?php if($dPago['DocNum']!=""){ echo number_format($row['ValorPago'],2);}else{ echo "--";}?></td>	
												<td align="right"><?php echo number_format($row['SaldoPendiente'],2);?></td>
												<td><a href="detalle_facturas_proveedores.php?id=<?php echo base64_encode($row['DocEntry']);?>&back=<?php echo base64_encode($_SERVER['QUERY_STRING']);?>&doc=1">Ver detalles</a></td>
											</tr>
                                   <?php 	}
										}
									}elseif($FilEstado==3){// Pendiente de pago
										while($row=sqlsrv_fetch_array($SQL)){
											$dPago=ConsultarPago($row['DocEntry'], $row['CardCode']);
											if($dPago['DocNum']==""){
									?>
											<tr class="odd gradeX">
												<td><?php echo $row['DocNum'];?></td>
												<td><?php echo utf8_encode($row['PrjName']);?></td>
												<td><?php echo $row['DocDate']->format('Y-m-d');?></td>
												<td><?php echo $row['CreateDate']->format('Y-m-d');?></td>
												<td><?php echo $row['NumAtCard'];?></td>
												<td align="right"><?php echo number_format($row['DocTotal'],2);?></td>
												<td><?php if($dPago['DocNum']!=""){ echo "Pagada"; }else{ echo "Pendiente de pago";}?></td>
												<td><?php if($dPago['DocNum']!=""){ echo $dPago['FechaPago']->format('Y-m-d'); }else{ echo "--";}?></td>				
												<td align="right"><?php if($dPago['DocNum']!=""){ echo number_format($row['ValorPago'],2);}else{ echo "--";}?></td>	
												<td align="right"><?php echo number_format($row['SaldoPendiente'],2);?></td>
												<td><a href="detalle_facturas_proveedores.php?id=<?php echo base64_encode($row['DocEntry']);?>&back=<?php echo base64_encode($_SERVER['QUERY_STRING']);?>&doc=1">Ver detalles</a></td>
											</tr>
                                   <?php 	}
										}
									}else{//Todos
										while($row=sqlsrv_fetch_array($SQL)){
											$dPago=ConsultarPago($row['DocEntry'], $row['CardCode']);
									?>
											<tr class="odd gradeX">
												<td><?php echo $row['DocNum'];?></td>
												<td><?php echo utf8_encode($row['PrjName']);?></td>
												<td><?php echo $row['DocDate']->format('Y-m-d');?></td>
												<td><?php echo $row['CreateDate']->format('Y-m-d');?></td>
												<td><?php echo $row['NumAtCard'];?></td>
												<td align="right"><?php echo number_format($row['DocTotal'],2);?></td>
												<td><?php if(($dPago['DocNum']!="")&&($row['SaldoPendiente']>0)){ echo "Abonada"; }elseif(($dPago['DocNum']!="")&&($row['SaldoPendiente']<=0)){echo "Pagada";}else{ echo "Pendiente de pago";}?></td>
												<td><?php if($dPago['DocNum']!=""){ echo $dPago['FechaPago']->format('Y-m-d'); }else{ echo "--";}?></td>				
												<td align="right"><?php if($dPago['DocNum']!=""){ echo number_format($row['ValorPago'],2);}else{ echo "--";}?></td>	
												<td align="right"><?php echo number_format($row['SaldoPendiente'],2);?></td>
												<td><a href="detalle_facturas_proveedores.php?id=<?php echo base64_encode($row['DocEntry']);?>&back=<?php echo base64_encode($_SERVER['QUERY_STRING']);?>&doc=1">Ver detalles</a></td>
											</tr>
                                   <?php										
										}
									}
									?>
                                </tbody>
                            </table>
                
              </div>
              <div class="row">
		  	 <div class="col-lg-12">
                   <div class="col-lg-1"><a href="exportar_excel.php?exp=1&Cons=<?php echo base64_encode($Consulta);?>"><img src="../dist/css/exp_excel.png" width="50" height="30" alt="Exportar a Excel" title="Exportar a Excel"/></a></div>
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
