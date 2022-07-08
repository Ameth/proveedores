<!DOCTYPE html>
<html lang="es">

<head>
<?php 
	include("cabecera.php"); 
	include_once("includes/define.php");
?>
<title>Portal de Proveedores - A Construir S.A</title>
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
		function btnDsbld(){
			var btn=document.getElementById('btnEnviar');
			btn.disabled=true;
			btn.innerHTML="Enviando... <span class='glyphicon glyphicon-send' aria-hidden='true'></span>";
		}
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
                        <form role="form" name="form" id="form" method="post" action="mail.php" onSubmit="btnDsbld();">
                            <fieldset>
                              <div class="form-group">
								  <h4 class="text-center">Restablecer contrase&ntilde;a</h4>
                                </div>
                               <div class="form-group">
                                    <input name="Nit" type="text" autofocus required="required" class="form-control" id="Nit" placeholder="NIT sin dígito de verificación" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input name="Email" type="email" required="required" class="form-control" id="Email" placeholder="Email" autocomplete="off">
                                </div>
                                <div class="form-group">
                                   A este correo le llegar&aacute; la informaci&oacute;n una vez se restablezca su contrase&ntilde;a.
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" id="btnEnviar" class="btn btn-lg btn-primary btn-block">Solicitar nueva contrase&ntilde;a <span class="glyphicon glyphicon-send" aria-hidden="true"></span></button>
                                <br>
                                <div class="form-group text-center">
									 <a href="index.php">Regresar</a>
                                </div>
                            </fieldset>  
                            <input type="hidden" name="MM_Mail" id="MM_Mail" value="<?php echo base64_encode("mail_2");?>">                         
                        </form>
                        <?php  
						if(isset($_GET['Msj'])&&($_GET['Msj']==base64_encode("MsjEnviado_mail_2"))){?>
							<div class="form-group">
								<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
								Su solicitud ha sido enviada. Muy pronto recibirá información para restablecer su contrase&ntilde;a.
								</div>
							</div>
						<?php }elseif(isset($_GET['Msj'])&&($_GET['Msj']==base64_encode("Msj_No_Existe"))){?>
							<div class="form-group">
								<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
								El NIT que ha ingresado no fue encontrado en nuestros registros. Por favor verifique.
								</div>
							</div>
						<?php }?>
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
