<?php
require("conexion.php");


$nombre = NULL;
$apell = NULL;
$correo= NULL;
$tel = NULL;
$portada = NULL;
$avatar = NULL;
$contra = NULL;
$nickname = NULL;


session_start();

if(isset($_POST['guardarPerfil'])){
	$nombre = $_POST['nomU'];
	$apell =  $_POST['apellU'];
	$correo =  $_POST['mailU'];
	$tel =  $_POST['telU'];
	$nickname =  $_POST['nickU'];
	$id =  $_POST['idUser']; 

	$up = "CALL spActualizarDatos('$id','$nombre','$apell','$nickname','$tel','$correo');";
	$response = $conexion->query($up);



	if($response){
		$_SESSION['nick'] = $nickname;
		$parent = "Refresh: 0; url=../profile.php?idUsuario=" . $id;
		echo "<script> alert('Se han actualizado sus datos de perfil.'); </script>";
		header($parent);
	}


}
else if(isset($_POST['guardarPass'])){
	$pass = $_POST['passW'];
	$confirm = $_POST['passW-confirm'];
	$id =  $_POST['idUser']; 

	if($pass == $confirm)
	{
		$up = "CALL spCambiarPassword('$id','$pass');";
		$response = $conexion->query($up);



		if($response){
			
			$parent = "Refresh: 0; url=../profile.php?idUsuario=" . $id;
			echo "<script> alert('Se han actualizado la contraseña.'); </script>";
			header($parent);
		}
	}
	else
	{
		echo "<script> alert('Las contraseñas no coinciden'); </script>";
		$parent = "Refresh: 5; url=../profile.php?idUsuario=" . $id;
		header($parent);

	}

}
else if(isset($_POST['guardarImg'])){
	$id =  $_POST['idUser']; 

if(($_FILES['avatar_update']['error'] != 4) && ($_FILES['portada_update']['error'] != 4 )) {

		

		$avatar = file_get_contents($_FILES['avatar_update']['tmp_name']);
		$avatar = mysqli_real_escape_string($conexion,$avatar);

		$portada =file_get_contents($_FILES['portada_update']['tmp_name']);
		$portada = mysqli_real_escape_string($conexion,$portada);

		$updImg = "CALL spNuevasImagenes('$avatar','$portada','$id');";

		$response = $conexion->query($updImg);



	if($response){
		
		$parent = "Refresh: 0; url=../profile.php?idUsuario=" . $id;
		header($parent);
	}

	
	}
	else
	{
			echo "<script> alert('No se pudo actualizar. Es necesario que cargue ambas imagenes, de lo contrario no se actualizarán.'); </script>";
	$parent = "Refresh: 0; url=../profile.php?idUsuario=" . $id;
	header($parent);
	}



}


?>