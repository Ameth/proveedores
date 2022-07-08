<?php require("includes/conexion.php");
$msgerror=0;
$varexito=0;
if(isset($_POST['Cambio'])&&($_POST['Cambio']==1)){
	if(isset($_POST['ClaveActual'])&&($_POST['ClaveActual']!="")){
		$ConsultaClave="Select * From tbl_Usuarios Where CodigoSAP='".$_SESSION['CodSAP']."'";
		$SQLClave=sqlsrv_query($conexion,$ConsultaClave);
		$rowClave=sqlsrv_fetch_array($SQLClave);
		if(md5($_POST['ClaveActual'])==$rowClave['Password']){
			if(md5($_POST['NuevaClave'])==md5($_POST['RepetirClave'])){
				$ConsultaCambia="Update tbl_Usuarios Set Password='".md5($_POST['NuevaClave'])."', CambioClave=0, FechaUltCambioClave='".date('Y-m-d')."' Where CodigoSAP='".$_SESSION['CodSAP']."'";
				if(sqlsrv_query($conexion,$ConsultaCambia)){
					$varexito=1;
				}else{//Sino se actualiza la clave
					sqlsrv_close($conexion);
					echo "No se pudo actualizar la clave. ";
					echo $ConsultaCambia;
					exit();
				}
			}else{//Si la nueva clave y la confirmación no son iguales
				$msgerror=2;				
			}
		}else{//Si la clave actual no es correcta
				$msgerror=1;				
		}
	}
}
?>
<!DOCTYPE html>
<html lang="es"><!-- InstanceBegin template="/Templates/PlantillaProveedores.dwt.php" codeOutsideHTMLIsLocked="false" -->

<head>
<?php include("cabecera.php"); ?>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Portal de Proveedores - <?php echo EMPRESA;?></title>
<?php if($varexito==1){?>
<script>
	$(document).ready(function() {
		swal('¡Listo!', 'Clave cambiada exitosamente.', 'success');
		//window.location.href='inicio.php';
	});	
	//
</script>
<?php }?>
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
                    <h3 class="page-header">Cambiar contrase&ntilde;a</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- InstanceEndEditable -->
            <!-- InstanceBeginEditable name="EditRegion6" -->
            
            <!-- InstanceEndEditable -->            
            <div class="row"><!-- InstanceBeginEditable name="EditRegion4" -->
              <div class="col-lg-6">
                <form class="form-horizontal" name="frm_cambiar" id="frm_cambiar" method="post" action="cambiar_clave_portal.php">
					   <div class="form-group">
						<label for="ClaveActual" class="col-lg-3 control-label">Contrase&ntilde;a actual</label>
						<div class="col-lg-4">
						  <input name="ClaveActual" type="password" autofocus required="required" class="form-control" id="ClaveActual" placeholder="Contraseña actual" maxlength="50">
						</div>
					  </div>
					  <div class="form-group">
						<label for="NuevaClave" class="col-lg-3 control-label">Nueva contrase&ntilde;a</label>
						<div class="col-lg-4">
						  <input name="NuevaClave" type="password" required="required" class="form-control" id="NuevaClave" placeholder="Nueva contraseña" maxlength="50">
						</div>
					  </div>
					  <div class="form-group">
						<label for="RepetirClave" class="col-lg-3 control-label">Repetir contrase&ntilde;a</label>
						<div class="col-lg-4">
						 <input name="RepetirClave" type="password" required="required" class="form-control" id="RepetirClave" placeholder="Repetir contraseña" maxlength="50">
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-lg-3">
						  <button type="submit" class="btn btn-success" name="Cambiar" id="Cambiar">Cambiar contrase&ntilde;a <span class="glyphicon glyphicon-lock" aria-hidden="true"></span></button>
						</div>
					  </div>
					   <input name="Cambio" type="hidden" id="Cambio" value="1">
				</form>
			   <?php  if($msgerror!=0){?>
					<div class="form-group">
						<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						<?php 
						if($msgerror==1){
							echo "Su clave actual no es correcta. Por favor verifique e intente nuevamente.";
							}
						if($msgerror==2){
							echo "La clave nueva y su confirmación no coinciden. Por favor verifique e intente nuevamente.";
							}
						?>
						</div>
					</div>
        		<?php }?>
				  <div class="form-group">
					  <div class="col-lg-12">
					  	<h4>Las contrase&ntilde;as deben cumplir con los siguientes requisitos:</h4>
                           <ul>
							   <li>Deben tener por lo menos 8 caracteres.</li>
							   <li>Deben constar &uacute;nicamente de caracteres del alfabeto latino que se encuentren en un teclado en ingl&eacute;s (no deben tener acentos ni otros diacr&iacute;ticos).</li>
							   <li>Solo pueden contener los siguientes tipos de car&aacute;cteres: may&uacute;sculas, min&uacute;sculas, n&uacute;meros y signos de puntuaci&oacute;n.</li>
							   <li>No deben basarse en una palabra que pueda encontrarse en un diccionario.</li>
							   <li>No pueden estar basadas en su nombre ni en su nombre de usuario.</li>
							   <li>No deben contener caracteres repetidos o secuencias de caracteres tales como 1234, 2222, ABCD o letras adyacentes del teclado.</li>
                           </ul>
					  </div>
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
