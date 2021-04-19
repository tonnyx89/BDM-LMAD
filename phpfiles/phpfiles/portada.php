<?php 
session_start();

require("phpfiles/conexion.php");
if(isset($_GET['port']))
	{
		
		$background = "SELECT portada FROM Usuario WHERE idUsuario =" . $_GET['poratada'];
		if($res=$mysqli->query($background))
		{
			while($row = $res->fetch_array())
			{
				$port =$row['poratada'];
	
			}
			$res->close();
		}
		$mysqli->close();
		header ('Content-type:image/jpeg;');
		echo $port;
	}
else{
	echo 'img/thumbail.jpg';
}


 ?>