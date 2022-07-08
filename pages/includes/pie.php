<script>
var Cont = 0;//Conteo general de segundos
function Reloj(){
	Cont++;
	if(Cont==900){
		<?php if(file_exists('logout.php')){?>
			top.location.href="logout.php";		
		<?php }else{?>
			top.location.href="../logout.php";
		<?php }?>		
		}
	setTimeout("Reloj()",1000);
}
function ResetC(){
	Cont = 0;
}
</script>