<?php

if(isset($_POST["entrar"])) {
 
		require("conexion.php");
 			
			$loginNombre = $_POST["usuario"];
			$loginPassword = $_POST["pwd"];
			$idUsuario = NULL;
			$nicknameU = NULL;
                        $telUsuario = NULL;
                        $correoUsuario=NULL;
 
			$consulta = "CALL spLoginUser( '$loginNombre' ,'$loginPassword');";
                           $resultado = $conexion->query($consulta);
                           
			if($resultado) {
				while($row = $resultado->fetch_array()) {
 
					$correoUsuario = $row["email"];
					$passok = $row["passsword"];
					$idUsuario = $row['idUsuario'];
					$nicknameU = $row['nickname'];
                                        $telUsuario = $row['telefono'];
				}
				$resultado->close();
			}
			$conexion->close();
 
 
			if(isset($loginNombre) && isset($loginPassword)) 
               {
                   $uPassword = md5($loginPassword);
				if(($loginNombre == $correoUsuario && $uPassword == $passok) || ($loginNombre == $nicknameU  && $uPassword == $passok) || ($loginNombre == $telUsuario  && $uPassword == $passok)) {
					if(isset($_POST['recordar'])){
						$recordar = $_POST['recordar'];
						if($recordar == TRUE){
							setcookie($_COOKIE['usuario'], $loginNombre, date() + (3600*72));
						}

					}
					session_start();
					$_SESSION["logueado"] = TRUE;
					$_SESSION['nick'] = $nicknameU;
					$_SESSION['usuarioId'] = $idUsuario;
					$_SESSION['correo'] = $correoUsuario;
					Header("Location: ../index.php?us=ok");
 
				}
				else {
					echo "<script> alert('El usuario y/o contraseña son incorrectos. Por favor ingrese con credenciales válidas o cree una cuenta para iniciar sesión.'); </script>";
					Header("Location: ../index.php?login=error");
				}
 
			}
 
		} else {

			header("Location: ../index.php");

		}
 


?>
