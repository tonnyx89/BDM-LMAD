<?php

$DBHost = "localhost";
$DBUser = "admin";
$DBPssw = "admin";
$Schema = "if_shop";

$conexion = new mysqli($DBHost, $DBUser, $DBPssw,$Schema);
if($conexion->connect_errno) {
	echo  "<script type=\"text/javascript\">alert(\"No se pudo establecer conexión con el servidor de chat. Error 4060 \");</script>";
}
 else{
 	return $conexion;
 
 }

?>