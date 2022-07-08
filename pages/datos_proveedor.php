<?php include("includes/conexion.php"); ?>
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
                    <h3 class="page-header">Datos del proveedor</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- InstanceEndEditable -->
            <!-- InstanceBeginEditable name="EditRegion6" -->
            
            <!-- InstanceEndEditable -->            
            <div class="row"><!-- InstanceBeginEditable name="EditRegion4" -->
              <div class="col-lg-6">
                <form class="form-horizontal" name="frm_enviar" id="frm_enviar" method="post">
					   <div class="form-group">
						   <div class="col-lg-2 control-label"><strong>Nombre</strong></div>
						<div class="col-lg-8">
						  Nombre
						</div>
					  </div>
					  <div class="form-group">
						<label for="Email" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
						  <input name="Email" type="email" required="required" class="form-control" id="Email" placeholder="Email" maxlength="100">
						</div>
					  </div>
					  <div class="form-group">
						<label for="Mensaje" class="col-sm-2 control-label">Mensaje</label>
						<div class="col-sm-10">
						 <textarea name="Mensaje" rows="3" maxlength="1000" class="form-control" id="Mensaje" placeholder="Escriba aqui sus comentarios..."></textarea>
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						  <button type="submit" class="btn btn-success">Enviar mensaje</button>
						</div>
					  </div>
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
   
   <!-- InstanceEndEditable -->    
</body>

<!-- InstanceEnd --></html>
