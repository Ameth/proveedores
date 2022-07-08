<?php include("includes/conexion.php"); 

/** Actual month first day **/
function PrimerDiaMes(){
  $month = date('m');
  $year = date('Y');
  return date('m/d/Y', mktime(0,0,0, $month, 1, $year));
}
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
    
  <script>
	 /*
	 $( function() {
		$( "#FechaInicial" ).datepicker({
      		changeMonth: true,
      		changeYear: true
    	});
		$( "#FechaInicial" ).datepicker($.datepicker.regional['es']);
		$( "#FechaInicial" ).on( "change", function() {
			$( "#FechaInicial" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
		});
		$( "#FechaFinal" ).datepicker({
      		changeMonth: true,
      		changeYear: true
    	});
		$( "#FechaFinal" ).datepicker($.datepicker.regional['es']);
		$( "#FechaFinal" ).on( "change", function() {
			$( "#FechaFinal" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
		});
	  } ); 
	  */
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
                    <h3 class="page-header">Certificado de retenciones</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- InstanceEndEditable -->
            <!-- InstanceBeginEditable name="EditRegion6" -->
            
            <!-- InstanceEndEditable -->            
            <div class="row"><!-- InstanceBeginEditable name="EditRegion4" -->
               <div class="col-lg-6">
                 <form class="form-horizontal" method="post" name="form" id="frmCertificado" action="export_certificado.php" target="_blank">
				  <div class="form-group">
					  <div class="col-lg-3"><strong>Fecha inicial</strong></div>
					  <div class="col-lg-3"><input type="text" class="form-control" readonly id="FechaInicial" name="FechaInicial" required value="<?php echo PrimerDiaMes();?>"></div>
				  </div>
				  <div class="form-group">
					  <div class="col-lg-3"><strong>Fecha final</strong></div>
					  <div class="col-lg-3"><input name="FechaFinal" type="text" readonly required class="form-control" id="FechaFinal" value="<?php echo date('m/d/Y');?>"></div>
				  </div>
				   <div class="form-group">
					  <div class="col-lg-3"><strong>Año gravable</strong></div>
					  <div class="col-lg-3">
					  	<select name="AGravable" required class="form-control" id="AGravable">
							<option value="2016" <?php if(date('Y')=="2016"){echo "selected";}?>>2016</option>
							<option value="2017" <?php if(date('Y')=="2017"){echo "selected";}?>>2017</option>
							<option value="2018" <?php if(date('Y')=="2018"){echo "selected";}?>>2018</option>
							<option value="2019" <?php if(date('Y')=="2019"){echo "selected";}?>>2019</option>
							<option value="2020" <?php if(date('Y')=="2020"){echo "selected";}?>>2020</option>
							<option value="2021" <?php if(date('Y')=="2021"){echo "selected";}?>>2021</option>
					  	</select>
					  </div>
				  </div>
				  <div class="form-group">
					  <div class="col-lg-3"><strong>Comentarios</strong></div>
					  <div class="col-lg-5"><textarea name="Comentarios" rows="3" maxlength="150" class="form-control" id="Comentarios" placeholder="(Opcional)"></textarea></div>
				  </div>
				  <button type="submit" class="btn btn-success" name="Generar" id="Generar">Generar certificado <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></button>
				  <input type="hidden" name="MM_Cert" id="MM_Cert" value="CertRet">
				</form>
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
	 $(document).ready(function(){
		 $("#frmCertificado").validate();
	});
</script>
   <!-- InstanceEndEditable -->    
</body>

<!-- InstanceEnd --></html>
