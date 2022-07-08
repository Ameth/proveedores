<?php 
if(!isset($_POST['MM_Mail'])||$_POST['MM_Mail']==""){exit();}else{
	$Mail=base64_decode($_POST['MM_Mail']);
	//incluimos la clase PHPMailer
	require_once('PHPMailer-master/PHPMailerAutoload.php');
	//instancio un objeto de la clase PHPMailer
	$mail = new PHPMailer(); // defaults to using php "mail()"
	$mail->CharSet = "UTF-8";
	$mail->Encoding = "quoted-printable"; 
	//indico a la clase que use SMTP
	$mail->isSMTP();
	//$mail->SMTPDebug = 3;
	//permite modo debug para ver mensajes de las cosas que van ocurriendo
	//$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
	//Debo de hacer autenticación SMTP
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "tls";
	//indico el servidor de Gmail para SMTP
	$mail->Host = "smtp-mail.outlook.com";
	//indico el puerto que usa Gmail
	$mail->Port = 587;
	//indico un usuario / clave de un usuario de gmail
	$mail->Username = "aconstruir.notificaciones@hotmail.com";
	$mail->Password = "aconstruir2018";
	$mail->SetFrom('aconstruir.notificaciones@hotmail.com', 'A Construir');
	$mail->AddReplyTo('aconstruir.notificaciones@hotmail.com', 'A Construir');

	if($Mail=="mail_1"){//Ayuda del portal
		$Mensaje="<!doctype html>
				<html>
				<head>
				<meta charset='utf-8'>
				</head>

				<body>
				<p><strong>Nombre: </strong> ".$_POST['Nombre']."</p>
				<p><strong>Email:</strong> ".$_POST['Email']."</p>
				<p><strong>Proveedor:</strong> ".$_POST['MM_Cod']."</p>
				<p><strong>Mensaje:</strong> ".$_POST['Mensaje']."</p>
				</body>
				</html>";
		
		$mail->Subject = "Mensaje de ayuda del Portal de Proveedores";
		$mail->MsgHTML($Mensaje);
		//indico destinatario
		$address = "aordonez@aconstruir.co";
		$mail->AddAddress($address, "Ameth Gabriel");
		if(!$mail->Send()) {
		echo "Error al enviar: " . $mail->ErrorInfo;
		} else {
			header("Location:ayuda.php?Msj=".base64_encode("MsjEnviado_mail_1"));
		} 
	}
	
	if($Mail=="mail_2"){//Recuperar contraseña
		if(isset($_POST['Nit'])&&($_POST['Nit']!="")){
			//Consultar primero el NIT
			require_once("includes/conect.php");
			$Num=0;
			$ResetOK="";
			$Consulta="Select * From uvw_tbl_Usuarios Where NIT LIKE '%".$_POST['Nit']."%'";
			$SQL=sqlsrv_query($conexion,$Consulta);
			$row=sqlsrv_fetch_array($SQL);
			$SQL=sqlsrv_query($conexion,$Consulta,array(),array( "Scrollable" => 'buffered' ));
			if ($SQL === false){
			  $Num=0;
			}else{
				$row=sqlsrv_fetch_array($SQL);
				$Num=sqlsrv_num_rows($SQL);		
			}
			if($Num==1){//Si se encontró el NIT
				$ConReset="UPDATE tbl_Usuarios SET Password='".md5(str_replace("-","",$row['NIT']))."', CambioClave=1, setCookie=NULL WHERE CodigoSAP='".$row['CodigoSAP']."'";
				if(sqlsrv_query($conexion,$ConReset)){
					$MsgProveedor="
					<!doctype html>
					<html>
					<head>
					<meta charset='utf-8'>
					<style>
						body{
							font-family: 'sans-serif', Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana;
							font-size: 14px;
						}
					</style>
					</head>

					<body>
					<p>¡Hola!</p>
					<p>Hemos recibido una solicitud de restablecer su contraseña en nuestro portal para proveedores.<br>
					  Le agradará saber que hemos realizado los cambios y le hemos asignado una contraseña temporal con la que podrá ingresar y establecer una nueva contraseña para su usuario.</p>
					<p>Estos son sus datos:</p>
					<p><strong>Proveedor: </strong>".$row['CardName']."<br>
					<strong>NIT: </strong>".$row['NIT']."</p>
					<p><strong>Usuario: </strong>".$row['User']."<br>
					<strong>Contraseña: </strong>".str_replace("-","",$row['NIT'])."</p>
					<p><em>Nota: Al ingresar, se pedirá cambio de contraseña. Deberá establecer una nueva.</em></p>
					<p>Adjuntamos el manual de uso del portal.</p>
					<p><strong>IMPORTANTE: Recuerde que el acceso al portal es un solo usuario por cada proveedor, por lo tanto si varias personas requieren acceso al portal, por favor tenga la bondad de compartir las credenciales de acceso con ellas.</strong></p>
					<p>Si tiene algún inconveniente en este proceso, no dude en comunicarse a nuestra linea de atención: (5) 3855098 Ext. 112.<br>
					</p>
					<p>Cordialmente,</p>
					<p><strong>A CONSTRUIR S.A.</strong></p>

					</body>
					</html>";
					$mail->Subject = "Solicitud de restablecer la contraseña - Portal de proveedores A Construir S.A.";
					$mail->MsgHTML($MsgProveedor);
					//indico destinatario
					$address = $_POST['Email'];
					$mail->AddAddress($address, $row['CardName']);
					if($mail->Send()){
						$ResetOK="El mensaje ha sido enviado al proveedor.";
					}else{
						$ResetOK="No fue posible enviar el mensaje al proveedor.";
					}
					$mail->ClearAllRecipients();
				}
				$Mensaje="<!doctype html>
						<html>
						<head>
						<meta charset='utf-8'>
						</head>

						<body>
						<p>Solicitud para restablecer la clave de un proveedor:</p>
						<p><strong>NIT: </strong> ".$_POST['Nit']."</p>
						<p><strong>Email:</strong> ".$_POST['Email']."</p>
						<p>".$ResetOK."</p>
						</body>
						</html>";
			}else{//No se encontró el NIT
				$Mensaje="<!doctype html>
						<html>
						<head>
						<meta charset='utf-8'>
						</head>

						<body>
						<p>Solicitud para restablecer la clave de un proveedor:</p>
						<p><strong>NIT: </strong> ".$_POST['Nit']."</p>
						<p><strong>Email:</strong> ".$_POST['Email']."</p>
						<p>El proveedor NO EXISTE.</p>
						</body>
						</html>";
			}
			$mail->Subject = "Solicitud de restablecer su clave - Portal de proveedores A Construir";
			$mail->MsgHTML($Mensaje);
			//indico destinatario
			$address = "aordonez@aconstruir.co";
			$mail->AddAddress($address, "Ameth Gabriel");
			if(!$mail->Send()) {
			echo "Error al enviar: " . $mail->ErrorInfo;
			} else {
				if($Num>=1){
					header("Location:recuperar_clave.php?Msj=".base64_encode("MsjEnviado_mail_2"));
				}else{
					header("Location:recuperar_clave.php?Msj=".base64_encode("Msj_No_Existe"));
				}
			}
		}else{
			header("Location:recuperar_clave.php");
		}
		 
	}
	
	
}




?>