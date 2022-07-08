<?php 
session_destroy();
$parametros_cookies = session_get_cookie_params(); 
setcookie(session_name(),0,1,$parametros_cookies["path"]);
setcookie('PPACSA',"",time()-(60*60*24*2));
header('Location:index.php');
?>