<?php include("includes/conexion.php"); ?>
<?php 
$Consulta="SELECT * FROM uvw_Sap_tbl_OrdenesDeCompra WHERE CardCode = '".$_SESSION['CodSAP']."'";
$SQL=sqlsrv_query($conexion,$Consulta);
InsertarLog("Ver ordenes de compra");
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
                    <h3 class="page-header">Ordenes de compra abiertas</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div><!-- InstanceEndEditable -->
            <!-- InstanceBeginEditable name="EditRegion6" -->
            
            <!-- InstanceEndEditable -->            
            <div class="row"><!-- InstanceBeginEditable name="EditRegion4" -->
              <div class="col-lg-12">
               <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Orden de compra</th>
                                        <th>Fecha de orden</th>
                                        <th>Proyecto</th>
                                        <th>Valor</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php while($row=sqlsrv_fetch_array($SQL)){?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $row['DocNum'];?></td>
                                        <td><?php echo $row['DocDate']->format('Y-m-d');?></td>
                                        <td><?php echo utf8_encode($row['PrjName']);?></td>
                                        <td align="right"><?php echo number_format($row['DocTotal'],2);?></td>
										<td><a href="detalle_orden_compra.php?id=<?php echo base64_encode($row['DocEntry']);?>">Ver detalles</a></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                
              </div>
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-1"><a href="exportar_excel.php?exp=3&Cons=<?php echo base64_encode($_SESSION['CodSAP']);?>"><img src="../dist/css/exp_excel.png" width="50" height="30" alt="Exportar a Excel" title="Exportar a Excel"/></a></div>
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
				"search":         "Buscar:",
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
