<?php 
function LSiqml($cad){
	$search=array("'",";","..","=","*","?","¿","&","_","\\","\<","\>","<script>","</script>","<",">","\"\"","\"");
	$replace="";
	$cad_clear=str_ireplace($search,$replace,$cad);
	return(trim(utf8_decode($cad_clear)));
}
function LSiqmlName($cad){
	$search=array("'",";","..","=","*","?","¿","&","\<","\>","<script>","</script>","<",">","\"\"","\"");
	$replace="";
	$cad_clear=str_ireplace($search,$replace,$cad);
	return(trim(utf8_decode($cad_clear)));
}
function LSiqmlObs($cad){
	$search=array("'","\<","\>","<script>","</script>","<",">");
	$replace="";
	$cad_clear=str_ireplace($search,$replace,$cad);
	return(trim(utf8_decode($cad_clear)));
}
function LSiqmlValor($cad){
	$search=array("$",",",".");
	$replace="";
	$cad_clear=str_ireplace($search,$replace,$cad);
	return(trim($cad_clear));
}
?>