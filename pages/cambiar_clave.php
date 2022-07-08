<?php require("includes/conexion.php");
$blq=0;//Indica si mostrar o no el menu, para controlar cuando sea cambio obligatorio. 0 Si mostrar. 1 No mostrar.
$msgerror=0;
if(isset($_SESSION['CambioClave'])&&($_SESSION['CambioClave']==1)){
	$blq=1;
	}
if(isset($_POST['Cambio'])&&($_POST['Cambio']==1)){
	if(isset($_POST['NuevaClave'])&&(md5($_POST['NuevaClave'])==md5($_POST['RepetirClave']))){
		$ConsultaCambia="Update tbl_Usuarios Set Password='".md5($_POST['NuevaClave'])."', CambioClave=0, FechaUltCambioClave='".date('Y-m-d')."' Where CodigoSAP='".$_SESSION['CodSAP']."'";
		if(sqlsrv_query($conexion,$ConsultaCambia)){
			echo "
			<script>
				alert('Clave cambiada exitosamente.');
				window.location.href='logout.php';
			</script>";
		}else{//Sino se actualiza la clave
			sqlsrv_close($conexion);
			echo "No se pudo actualizar la clave. ";
			echo $ConsultaCambia;
			exit();
		}
	}else{//Si la nueva clave y la confirmación no son iguales
		$msgerror=2;				
	}
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
<?php include("cabecera.php"); ?>
<title>Portal de Proveedores - <?php echo EMPRESA;?></title>
	<style>
		body{
			background-repeat: no-repeat;
			background-position: center center;
			background-attachment: fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
			
			-webkit-animation-name: fondo;
			-webkit-animation-duration: 20s;
			-webkit-animation-timing-function: ease-in-out;
			-webkit-animation-iteration-count: infinite;
			-webkit-animation-direction: alternate;
			-webkit-transition: all 2s;
			
			animation-name: fondo;
			animation-duration: 20s;
			animation-timing-function: ease-in-out;
			animation-iteration-count: infinite;
			animation-direction: alternate;
			transition: all 2s;
		}
		#todo{
			width: 100%;
			height: 100%;
			position: absolute;
			background-color: black;
			opacity: 0.4;    		
		}
		#foot{
		  position: fixed;
		  bottom: 0;
		  right: 0;
		  width: 100%;
		}
		@-webkit-keyframes fondo{
			0%{
				background-image: url(../dist/css/fondo.JPG);
			}
			30%{
				background-image: url(../dist/css/fondo2.JPG);
			}
			65%{
				background-image: url(../dist/css/fondo3.JPG);
			}
			100%{
				background-image: url(../dist/css/fondo4.JPG);
			}
		}
		
		@keyframes fondo{
			0%{
				background-image: url(../dist/css/fondo.JPG);
			}
			30%{
				background-image: url(../dist/css/fondo2.JPG);
			}
			65%{
				background-image: url(../dist/css/fondo3.JPG);
			}
			100%{
				background-image: url(../dist/css/fondo4.JPG);
			}
		}
	</style>
<script>
$( function() {
	$( document ).tooltip({
		position: { my: "left+15 center", at: "top center" }
	});
} );
</script>
</head>

<body>
	<div id="todo"></div>
    <div id="foot"></div>   
<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-danger">
                    <div class="panel-heading">
						<h3 class="panel-title text-center"><strong>Portal de Proveedores</strong><br><img src="../dist/css/logotipo_ac.png" alt="A Construir"/></h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" name="form" id="form" method="post" action="cambiar_clave.php">
                            <fieldset>
                                <div class="form-group">
                                    <label for="Email" class="col-lg-12 control-label">Cambiar contrase&ntilde;a</label>
                                </div>
                                <div class="form-group">
                                    <input name="NuevaClave" type="password" autofocus required="required" class="form-control" id="NuevaClave" placeholder="Nueva" autocomplete="off" title="Deben constar &uacute;nicamente de caracteres del alfabeto latino que se encuentren en un teclado en ingl&eacute;s (no deben tener acentos ni otros diacr&iacute;ticos).">
                                </div>
                                <div class="form-group">
                                    <input name="RepetirClave" type="password" required="required" class="form-control" id="RepetirClave" placeholder="Repetir" autocomplete="off">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-primary btn-block">Cambiar contrase&ntilde;a <span class="glyphicon glyphicon-lock" aria-hidden="true"></span></button>
								<br>
                                <div class="form-group text-center">
									 <a href="logout.php">Cancelar</a>
                                </div>
                                <?php  if($msgerror!=0){?>
								<div class="form-group">
									<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									<?php 
									if($msgerror==2){
										echo "La clave nueva y su confirmación no coinciden. Por favor verifique e intente nuevamente.";
										}
									?>
									</div>
								</div>
								<?php }?>
                            </fieldset>     
                            <input name="Cambio" type="hidden" id="Cambio" value="1">                      
                        </form>
                    </div>
                    <div class="panel-footer text-center">
						<h6><?php echo COPYRIGHT;?><br><small><?php echo VERSION;?></small></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
