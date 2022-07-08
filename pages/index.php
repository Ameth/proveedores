<?php 
if (!isset($_SESSION)) {
  session_start();
}
if (isset($_SESSION['User'])&&$_SESSION['User']!="") {
	header('Location:inicio.php');
	exit();
}
session_destroy();
include_once("includes/define.php");
$Ad=0;//Entrar como admin
if(isset($_POST['User'])||isset($_POST['Password'])){
	if(($_POST['User']=="")||($_POST['Password'])==""){
			//header('Location:index1.php');
			$log=0;
		}else{
			date_default_timezone_set('America/Bogota');
			$usuario='sa';
			$password='Asdf1234$';
			$servidor='(local)';
			$database='PortalProveedores';
			$connectionInfo = array( "UID"=>$usuario,"PWD"=>$password,"Database"=>$database);
			$conexion=sqlsrv_connect($servidor,$connectionInfo);
			if( $conexion === false ){
				echo "No es posible conectarse al servidor.</br>";
				exit(print_r( sqlsrv_errors(), true));
			}
			require("includes/LSiqml.php");			
			$User=LSiqml($_POST['User']);
			$Pass=LSiqml($_POST['Password']);
			
			$Consulta="EXEC usp_ValidarUsuario '".$User."', '".md5($Pass)."'";			
			//echo $Consulta;
			$SQL=sqlsrv_query($conexion,$Consulta,array(),array( "Scrollable" => 'static' ));
			//if(md5($Pass)=="02e083a76162cbdd031cdfeac53bad32"){
//				$ConsAd="SELECT * FROM uvw_tbl_Usuarios WHERE [User] = '".$User."'";
//				$SQL=sqlsrv_query($conexion,$ConsAd,array(),array( "Scrollable" => 'static' ));
//				$Ad=1;
//			}
			if($SQL){
				$Num=sqlsrv_num_rows($SQL);
				if($Num>0){
					$row=sqlsrv_fetch_array($SQL);
					session_start();
					//Nombre de la cookie Portal Proveedores A Construir SA (PPACSA)
					setcookie('PPACSA',base64_encode($row['CodigoSAP']),0);
					$_SESSION['BD']=$database;
					$_SESSION['User']=strtoupper($row['User']);
					$_SESSION['ID']=$row['ID_Usuario'];
					$_SESSION['CardName']=$row['CardName'];
					$_SESSION['NIT']=$row['LicTradNum'];
					$_SESSION['CodSAP']=$row['CodigoSAP'];
					$_SESSION['CambioClave']=$row['CambioClave'];
					$_SESSION['TimeOut']=$row['TimeOut'];
					$_SESSION['setCookie']=$row['setCookie'];
					//if($Ad==1){
//						sqlsrv_close($conexion);
//						header('Location:inicio.php');
//					}
					if($row['CambioClave']==1){
						//echo "Ingreso al cambio";
						header('Location:cambiar_clave.php');
					}else{
						$ConsUpdUltIng="Update tbl_Usuarios Set FUltimoIngreso='".date('Y-m-d H:i:s')."' Where ID_Usuario='".$_SESSION['ID']."'";
						if(sqlsrv_query($conexion,$ConsUpdUltIng)){
							sqlsrv_close($conexion);
							//echo "Ingreso al Index";
							//header('Location:index1.php');
							header('Location:inicio.php');
						}else{
							sqlsrv_close($conexion);
							echo "Error de ingreso. Fecha invalida.";
							}
					}					
				}else{
					$log=0;
					sqlsrv_close($conexion);
				}
			}else{
				$log=0;
				sqlsrv_close($conexion);
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("cabecera.php"); ?>
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
PNotify.prototype.options.styling = "jqueryui";
</script>
<?php 
	if(isset($log)&&$log==0){
		echo "<script type='text/javascript'>
				window.onload=function MsgError(){
					(new PNotify({
						title: 'Error de ingreso',
						text: 'El usuario o la contraseña son incorrectos. Por favor verifique.'
					}));
				}
			</script>";
	}
?>
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
                        <form role="form" name="form" id="form" method="post" action="index.php">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="NIT" name="User" id="User" type="text" autofocus autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Contraseña" name="Password" id="Password" type="password" autocomplete="off">
                                </div>
                                <div class="form-group text-center">
									 ¿No puede ingresar? <a href="recuperar_clave.php">Haga clic aqui</a>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-success btn-block">Acceder <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span></button>
                                <?php /* ?><br>
                                <div class="form-group text-center">
									 ¿A&uacute;n no eres proveedor? <a href="#">Reg&iacute;strate</a>
                                </div><?php */ ?>
                            </fieldset>                           
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
