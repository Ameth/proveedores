<?php include("includes/conexion.php"); 
if(isset($_GET['MM_Ent'])&&$_GET['MM_Ent']=="form_Ent"){
	$FechaInicial=$_GET['FechaInicial'];
	$FechaFinal=$_GET['FechaFinal'];
	$Remision=$_GET['Remision'];
}else{
	/** Actual month first day **/
	function PrimerDiaMes(){
	  $month = date('m');
	  $year = date('Y');
	  return date('m/d/Y', mktime(0,0,0, $month, 1, $year));
	}
	$FechaInicial=PrimerDiaMes();
	$FechaFinal=date('m/d/Y');
	$Remision="";
}
if($Remision!=""){
	$Consulta="SELECT * FROM uvw_Sap_tbl_EntradasFromOrdenesCompras WHERE CardCode = '".$_SESSION['CodSAP']."' and NumAtCard LIKE '%".$Remision."%'";
}else{
	$Consulta="SELECT * FROM uvw_Sap_tbl_EntradasFromOrdenesCompras WHERE CardCode = '".$_SESSION['CodSAP']."' and DocDate Between '".$FechaInicial."' and '".$FechaFinal."'";	
}

$SQL=sqlsrv_query($conexion,$Consulta);
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
                    <h3 class="page-header">Entradas de mercanc&iacute;as</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
<!-- InstanceEndEditable -->
            <!-- InstanceBeginEditable name="EditRegion6" -->
            <div class="row">
            <form action="entradas_mercancias.php" method="get" name="form_Ent" class="form-horizontal" id="form_Ent">
				<div class="form-group">
					<div class="col-lg-1"><strong>Fecha inicio</strong></div>
					<div class="col-lg-2"><input name="FechaInicial" type="text" required class="form-control" id="FechaInicial" value="<?php echo $FechaInicial;?>" maxlength="10"></div>
					<div class="col-lg-1"><strong>Fecha final</strong></div>
					<div class="col-lg-2"><input name="FechaFinal" type="text" required class="form-control" id="FechaFinal" value="<?php echo $FechaFinal; ?>" maxlength="10"></div>
					<div class="col-lg-1"><strong>Remisi&oacute;n</strong></div>
					<div class="col-lg-2"><input name="Remision" type="text" class="form-control" id="Remision" value="<?php if(isset($_GET['Remision'])){echo $_GET['Remision'];}?>" maxlength="15" placeholder="(Opcional)"></div>
					<div class="col-lg-3"><button type="submit" class="btn btn-outline btn-info"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Buscar</button></div>
				</div>
				<input type="hidden" name="MM_Ent" id="MM_Ent" value="form_Ent">
			</form>
		  </div>
		  <div class="row">&nbsp;</div>
            <!-- InstanceEndEditable -->            
            <div class="row"><!-- InstanceBeginEditable name="EditRegion4" -->
              <div class="col-lg-12">
               <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Entrada</th>
                                        <th>Orden de compra</th>
                                        <th>Fecha de entrada</th>
                                        <th>InvenObras</th>
                                        <th>Estado</th>
                                        <th>Remisi&oacute;n</th>
                                        <th>Proyecto</th>
                                        <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php while($row=sqlsrv_fetch_array($SQL)){?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $row['DocNum'];?></td>
                                        <td><?php echo $row['NumOrdenCompra'];?></td>
                                        <td><?php echo $row['DocDate']->format('Y-m-d');?></td>
                                        <td><?php if($row['IdInvenObras']!=""){echo $row['IdInvenObras'];}else{ echo "--";}?></td>
                                        <td><?php echo $row['DocEstado'];?></td>
                                        <td><?php echo $row['NumAtCard'];?></td>
                                        <td><?php echo utf8_encode($row['PrjName']);?></td>
										<td><a href="detalle_entradas_mercancias.php?id=<?php echo base64_encode($row['DocEntry']);?>&back=<?php echo base64_encode($_SERVER['QUERY_STRING']);?>">Ver detalles</a> - <a <?php if($row['IdInvenObras']!=""){?> href="export_entrada.php?ID=<?php echo base64_encode($row['IdInvenObras']);?>&type=1" <?php }else{?>href="export_entrada.php?ID=<?php echo base64_encode($row['DocNum']);?>&type=2"<?php }?> target="_blank">Exportar <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                
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
