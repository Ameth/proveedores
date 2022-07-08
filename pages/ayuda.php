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
                    <h3 class="page-header">Enviar mensaje</h3>
                </div>
                <div class="col-lg-12">
					<p>Puede enviar un mensaje solicitando soporte para este portal, as&iacute; como cualquier informaci&oacute;n adicional que necesite. Recibir&aacute; respuesta a su petici&oacute;n lo m&aacute;s r&aacute;pido posible.</p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- InstanceEndEditable -->
            <!-- InstanceBeginEditable name="EditRegion6" -->
            
            <!-- InstanceEndEditable -->            
            <div class="row"><!-- InstanceBeginEditable name="EditRegion4" -->
              <div class="col-lg-6">
                <form class="form-horizontal" name="frm_enviar" id="frm_enviar" method="post" action="mail.php">
					   <div class="form-group">
						<label for="Nombre" class="col-sm-2 control-label">Nombre</label>
						<div class="col-sm-10">
						  <input name="Nombre" type="text" autofocus required="required" class="form-control" id="Nombre" placeholder="Escriba su nombre" maxlength="30">
						</div>
					  </div>
					  <div class="form-group">
						<label for="Email" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
						  <input name="Email" type="email" required="required" class="form-control" id="Email" placeholder="Escriba el email donde se enviará la respuesta" maxlength="100">
						</div>
					  </div>
					  <div class="form-group">
						<label for="Mensaje" class="col-sm-2 control-label">Mensaje</label>
						<div class="col-sm-10">
						 <textarea name="Mensaje" rows="5" maxlength="1000" class="form-control" id="Mensaje" placeholder="Escriba aqui sus comentarios..."></textarea>
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						  <button type="submit" class="btn btn-success" name="Enviar" id="Enviar">Enviar mensaje <span class="glyphicon glyphicon-send" aria-hidden="true"></span></button>
						</div>
					  </div>
					  <input type="hidden" name="MM_Mail" id="MM_Mail" value="<?php echo base64_encode("mail_1");?>">
					  <input type="hidden" name="MM_Cod" id="MM_Cod" value="<?php echo $_SESSION['CodSAP'];?>">
				</form>
             	<?php if(isset($_GET["Msj"])&&($_GET["Msj"]==base64_encode("MsjEnviado_mail_1"))){?>
               	<div id="MsjEnviado" class="alert alert-success">
                	<span class="glyphicon glyphicon-ok"></span> Su mensaje ha sido enviado con &eacute;xito. Recibir&aacute; respuesta muy pronto.
                </div>
                <?php }?>
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
