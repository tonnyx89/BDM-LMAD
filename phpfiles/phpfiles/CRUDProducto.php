<?php
require('conexion.php');

$nombre = NULL;
$descripcion = NULL;
$precio = NULL;
$descuento = NULL;
$unidades = NULL;
$idVendedor = NULL;
$categoria =NULL;

$imgPdto = NULL;
$vidPdto = NULL;
$type = NULL;

$idProd = NULL;
$stepOne = NULL;
$stepTwo = NULL;
$stepThree = NULL;
$stepFour = NULL;
$qTwo = NULL;
$qThree = NULL;
$qvid=NULL;



if(isset($_POST['borrador'])){
	$nombre = $_POST['nombre'];
	$descripcion = $_POST['descripcion'];
	$precio = $_POST['precio'];
	$descuento = $_POST['descuento'];
	$unidades = $_POST['unidades'];
	$idVendedor = $_POST['idUser'];

	$qOne= "CALL spNuevoArticulo('$nombre','$descripcion','$precio','$unidades','$idVendedor','$descuento');";

	$stepOne = $conexion->query($qOne);
	
	if($stepOne){
		$id =  $stepOne->fetch_assoc();
		$idProd = $id['idp'];
		$stepOne->close();

		if(isset($_POST['category'])){
			require('conexion.php');
			$categoria = $_POST['category'];	
			foreach($categoria as $cat) {
				$qTwo= "CALL spCategoriasNuevoArticulo('$cat','$idProd');";
				
				$stepTwo = $conexion->query($qTwo);
			}
			
			if($stepTwo){

				if(isset($_FILES['img'])){
					require('conexion.php');
				
					
					
					foreach ($_FILES['img']['tmp_name'] as $ImgN => $tmp_name) {
					
							$imgPdto = file_get_contents($_FILES['img']['tmp_name'][$ImgN]);
							$imgPdto = mysqli_real_escape_string($conexion,$imgPdto);
						
							$type = end(explode('.',$_FILES['img']['type'][$ImgN])); 
							
							$qThree = "CALL spImagenesNuevoArticulo('$idProd','$imgPdto','$type');";
							$stepThree = $conexion->query($qThree);

						}

					if($stepThree){
						if(isset($_FILES['vid'])){
						require('conexion.php');
								$loc = $_SERVER['DOCUMENT_ROOT']."/ProyectoBDM2018/";
							foreach ($_FILES['vid']['tmp_name'] as $key => $tmp_name) {
								
								$temp = $_FILES['vid']['tmp_name'][$key];
								$ext = strtolower(end(explode('.',$_FILES['vid']['name'][$key])));
								$name = date("Ymdhis")  . $idVendedor . $idProd . "." . $ext;
								$path = "video/" . $name;
								move_uploaded_file($temp,$loc.$path);
								$qFour = "CALL spVideosNuevoArticulo('$path','$ext','$idProd');";
								$stepFour = $conexion->query($qFour);								
							}
							if($stepFour){
								$p = "Refresh:0 url=../profile.php?idUsuario=" . $idVendedor;
								header($p);
							}
						}
						$conexion->close();
					}
					
				}
				
			}
		}
		
	}

}
else if(isset($_POST['eliminar'])){
require('conexion.php');
		$idArt = $_POST['id'];
		$idVendedor = $_POST['idUserDel'];
		$q="CALL spEliminarArticulo('$idArt');";
		$result = $conexion->query($q);
		if($result){
			echo "<script> alert('Producto eliminado.'); </script>";

			$p = "Refresh:0 url=../profile.php?idUsuario=" . $idVendedor;
			session_start();
			header($p);
		}
}
elseif(isset($_POST['update'])){
require('conexion.php');
	
	$nombre = $_POST['nombre'];
	$descripcion = $_POST['descripcion'];
	$precio = $_POST['precio'];
	$descuento = $_POST['descuento'];
	$unidades = $_POST['unidades'];
	$idVendedor = $_POST['idUser'];
	$idProd = $_POST['idUp'];
	$qOne= "CALL spActualizaArticulo('$nombre','$descripcion','$precio','$unidades','$descuento','$idProd');";

	$stepOne = $conexion->query($qOne);
	
	if($stepOne){
		

				$p = "Refresh:0 url=../profile.php?idUsuario=" . $idVendedor;
			session_start();
			header($p);
			}
			
		
		
	
}
elseif(isset($_POST['publicar'])){
require('conexion.php');
		$idProd = $_POST['idPro'];
		$pub = "CALL spPublicarProducto('$idProd');";
		$result = $conexion->query($pub);
		if($result){
			
			$p = "Refresh:0 url=../productDetail.php?product=" . $idProd;
			
			header($p);
		}
		else{
			echo "<script> alert('Error.'); </script>";
		}

}
?>