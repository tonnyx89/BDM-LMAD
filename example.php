<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
if(isset($_POST["entrar"])) {
 
		require("phpfiles/conexion.php");
 
			$loginNombre = $_POST["usuario"];
			$loginPassword = $_POST["pwd"];
			$idUsuario = NULL;
			$nicknameU = NULL;
                        $telUsuario = NULL;
                        $correoUsuario=NULL;
 
			$consulta = "CALL spLoginUser('$loginNombre','$loginPassword' );";
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
					session_start();
					$_SESSION["logueado"] = TRUE;
					$_SESSION['nick'] = $nicknameU;
					$_SESSION['usuarioId'] = $idUsuario;
					$_SESSION['correo'] = $correoUsuario;
                                         
					// Header("Location: example.php?us=ok");
                                         echo  "<script type=\"text/javascript\">alert(\" $nicknameU \" );</script>";
                               
 
				}
                                else {
                                   echo  "<script type=\"text/javascript\">alert(\"No se pudo establecer conexión con el servidor de chat. Error 4060  );</script>";
                                    Header("Location: example.php?us=error");
                                }
        
                        }


        if(isset($_SESSION['logueado']))
        {
             echo $_SESSION['nick'];
                echo $_SESSION['usuarioId'];
				echo $_SESSION['correo'];
        }
           
}
        
        ?>
        <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
             <input type="text" name="usuario" value="" size="30" />
             <input type="password" name="pwd" value="" size="30" />
             <input type="submit" value="Entrar" name="entrar" />
        </form>
        <?php 
                  
        
        ?>
     
    </body>
</html>
