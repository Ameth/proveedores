<?php include("includes/conexion.php"); 

//Ordenes de Compra
$ConsultaOC="SELECT Count(DocEntry) as Count FROM uvw_Sap_tbl_OrdenesDeCompra WHERE CardCode = '".$_SESSION['CodSAP']."'";
$SQLOC=sqlsrv_query($conexion,$ConsultaOC);
$rowOC=sqlsrv_fetch_array($SQLOC);

//Restar 7 dias a la fecha actual
$fecha = date('Y-m-d');
$nuevafecha = strtotime ( '-7 day' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

//Entradas de mercancías
$ConsultaEnt="SELECT Count(DocEntry) as Count FROM uvw_Sap_tbl_EntradasFromOrdenesCompras WHERE CardCode = '".$_SESSION['CodSAP']."' And DocDate Between '".$nuevafecha."' and '".date('Y-m-d')."'";
$SQLEnt=sqlsrv_query($conexion,$ConsultaEnt);
$rowEnt=sqlsrv_fetch_array($SQLEnt);

//Factura de proveedores
$ConsultaFact="SELECT Count(DocEntry) as Count FROM uvw_Sap_tbl_FacturasProveedores WHERE CardCode = '".$_SESSION['CodSAP']."' And DocDate Between '".$nuevafecha."' and '".date('Y-m-d')."'";
$SQLFact=sqlsrv_query($conexion,$ConsultaFact);
$rowFact=sqlsrv_fetch_array($SQLFact);

//Pagos efectuados
$ConsultaPagos="SELECT Count(CardCode) as Count FROM uvw_Sap_tbl_Pagos_Efectuados WHERE CardCode = '".$_SESSION['CodSAP']."' And FechaPago Between '".$nuevafecha."' and '".date('Y-m-d')."'";
$SQLPagos=sqlsrv_query($conexion,$ConsultaPagos);
$rowPagos=sqlsrv_fetch_array($SQLPagos);

?>
<!DOCTYPE html>
<html lang="es"><!-- InstanceBegin template="/Templates/PlantillaProveedores.dwt.php" codeOutsideHTMLIsLocked="false" -->

<head>
<?php include("cabecera.php"); ?>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Portal de Proveedores - <?php echo EMPRESA;?></title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->

<?php if((!isset($_SESSION['setCookie']))||($_SESSION['setCookie']=="")){ ?>
<script>
	$(document).ready(function() {
		$('#myModal').modal('show');
	});
</script>
<?php
$ConsUpdCookie="Update tbl_Usuarios set setCookie='".base64_encode($_SESSION['CodSAP'])."' Where ID_Usuario='".$_SESSION['ID']."'";
if(sqlsrv_query($conexion,$ConsUpdCookie)){
	$_SESSION['setCookie']=base64_encode($_SESSION['CodSAP']);
}
}?>
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
                    <h2 class="page-header">Bienvenido</h2>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- InstanceEndEditable -->
            <!-- InstanceBeginEditable name="EditRegion6" -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Condiciones de uso de este sitio</h4>
					</div>
					<div class="modal-body">
						El portal de proveedores de A CONSTRUIR S.A. puede usar cookies para recordar tus datos de inicio de sesi&oacute;n y recopilar estad&iacute;sticas para optimizar la funcionalidad del sitio. En ning&uacute;n momento compartiremos la informaci&oacute;n con terceros. Si contin&uacute;a navegando consideramos que acepta estas condiciones.
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Acepto</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>      
            <!-- InstanceEndEditable -->            
            <div class="row"><!-- InstanceBeginEditable name="EditRegion4" -->
              <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-xs-3"> <i class="fa fa-shopping-cart fa-5x"></i> </div>
                      <div class="col-xs-9 text-right">
                        <div class="huge" id="run1">0</div>
                        <div>Ordenes de compra abiertas</div>
                      </div>
                    </div>
                  </div>
                  <a href="ordenes_compra.php">
                    <div class="panel-footer"> <span class="pull-left">Ver detalles</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                      <div class="clearfix"></div>
                    </div>
                  </a> </div>
              </div>
              <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-xs-3"> <i class="fa fa-truck fa-5x"></i> </div>
                      <div class="col-xs-9 text-right">
                        <div class="huge" id="run2">0</div>
                        <div>Entradas realizadas esta semana</div>
                      </div>
                    </div>
                  </div>
                  <a href="entradas_mercancias.php?FechaInicial=<?php echo $nuevafecha;?>&FechaFinal=<?php echo date('Y-m-d');?>&Remision=&MM_Ent=form_Ent">
                    <div class="panel-footer"> <span class="pull-left">Ver detalles</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                      <div class="clearfix"></div>
                    </div>
                  </a> </div>
              </div>
              <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-xs-3"> <i class="fa fa-briefcase fa-5x"></i> </div>
                      <div class="col-xs-9 text-right">
                        <div class="huge" id="run3">0</div>
                        <div>Nuevas facturas recibidas</div>
                      </div>
                    </div>
                  </div>
                  <a href="facturas_proveedores.php?FechaInicial=<?php echo $nuevafecha;?>&FechaFinal=<?php echo date('Y-m-d');?>&MM_Fact=form_Fact">
                    <div class="panel-footer"> <span class="pull-left">Ver detalles</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                      <div class="clearfix"></div>
                    </div>
                  </a> </div>
              </div>
               <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-xs-3"> <i class="fa fa-money fa-5x"></i> </div>
                      <div class="col-xs-9 text-right">
                        <div class="huge" id="run4">0</div>
                        <div>Nuevos pagos realizados</div>
                      </div>
                    </div>
                  </div>
                  <a href="pagos_efectuados.php?FiltroFecha=FechaPago&FechaInicial=<?php echo $nuevafecha;?>&FechaFinal=<?php echo date('Y-m-d');?>&MM_Pagos=form_Pagos">
                    <div class="panel-footer"> <span class="pull-left">Ver detalles</span> <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                      <div class="clearfix"></div>
                    </div>
                  </a> </div>
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
   var amount=<?php echo $rowOC['Count']; ?>;
   $({c:0}).animate({c:amount}, { 
        step: function(now) {
            $("#run1").html(Math.round(now))
        },
        duration: 2000,
        easing: "linear"        
    });
	   var amount=<?php echo $rowEnt['Count']; ?>;
   $({c:0}).animate({c:amount}, { 
        step: function(now) {
            $("#run2").html(Math.round(now))
        },
        duration: 2000,
        easing: "linear"        
    });
	   var amount=<?php echo $rowFact['Count']; ?>;
   $({c:0}).animate({c:amount}, { 
        step: function(now) {
            $("#run3").html(Math.round(now))
        },
        duration: 2000,
        easing: "linear"        
    });
	   var amount=<?php echo $rowPagos['Count']; ?>;
   $({c:0}).animate({c:amount}, { 
        step: function(now) {
            $("#run4").html(Math.round(now))
        },
        duration: 2000,
        easing: "linear"        
    });
    </script>
   <!-- InstanceEndEditable -->    
</body>

<!-- InstanceEnd --></html>
