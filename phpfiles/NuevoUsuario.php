<?php 



$nombre = NULL;
$apell = NULL;
$correo= NULL;
$tel = NULL;
$portada = NULL;
$avatar = NULL;
$contra = NULL;
$nickname = NULL;
$op = NULL;
if(isset($_POST['registrar']))
{
  if(($_FILES['avatar']['error'] != 4) && ($_FILES['portada']['error'] != 4 )) {
      $nombre = $_POST['nombre'];
        $apell = $_POST['apellido'];
        $correo= $_POST['correo'];
        $tel = $_POST['telefono'];
        $contra = $_POST['passw'];
        $nickname = $_POST['nickname'];
  
        $avatar = file_get_contents($_FILES['avatar']['tmp_name']);
	$avatar = mysqli_real_escape_string($conexion,$avatar);

	$portada =file_get_contents($_FILES['portada']['tmp_name']);
	$portada = mysqli_real_escape_string($conexion,$portada);
require("conexion.php");
        $command = "CALL sp_NuevoUsuario('$nombre','$apell','$nickname','$correo','$contra','$tel','$avatar','$portada');";
   
        $resultado = $conexion->query($command);
        
        if($resultado) {
                 
            while($row = $resultado->fetch_array()) {
 
                $op = $row['registro'];
	}
		$resultado->close();
	}
	$conexion->close();
        
        if($op == 'ok'){
            echo '<script type="text/javascript"> alert(\'REGISTRO EXITOSO.\'); </script>';
             header("Refresh: 0; url=../index.php");
        }
        else{
              echo '<script type="text/javascript"> alert(\'EL CORREO O NICKNAME YA ESTÁ REGISTRADO PARA UN USUARIO.\'); </script>';
                header("Refresh: 0; url=../register.php");
        }
       
       
      
  }  
else{
  echo '<script type="text/javascript"> alert(\'NO SE PUDO REGITRAR, VERIFIQUE BIEN LOS DATOS INGRESADOS\'); </script>';
    header("Refresh: 0; url=../register.php");
}



 




 //echo  '<script>alert(\' ' .$result. '\');</script>';

}



 






?>


