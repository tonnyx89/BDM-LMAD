<?php 


$idU = NULL;
$idProd = NULL;
$cantidad = NULL;
$accion = NULL;


if(isset($_REQUEST['pvariable'])){
	$idU = $_REQUEST['idUser'];
	$idProd = $_REQUEST['idProducto'];
	$cantidad = $_REQUEST['cantidad'];
	$accion = $_REQUEST['pvariable'];

	if($accion == "agregar"){
		require("conexion.php");
		$q = "CALL spAddAlCarrito('$idProd','$cantidad','$idU');";
		$add = $conexion->query($q);
		
		if($add){
		echo "<script>alert('".$q."');</script>";
		$a = "Refresh: 5 url=../productDetail.php?product=" . $idProd;
		header($a);
		}
		$conexion->close();
	}
	else{
		if($accion == "update"){
			require("conexion.php");
			$q = "CALL spActualizarUnidadesCarrito('$idU','$idProd','$cantidad');";
			$add = $conexion->query($q);
			
			if($add){
			echo "<script>alert('".$q."');</script>";
			$a = "Refresh: 5 url=../productDetail.php?product=" . $idProd;
			header($a);
			}
			$conexion->close();
		}
		else
		{
			if($accion == "eliminar"){
				require("conexion.php");
				$eli = "CALL spElimiarArticuloCarrito('$idU','$idProd');";
				$delete = $conexion->query($eli);
				$conexion->close();
			}
			else
			{
				if($accion == "vaciar"){
					require("conexion.php");
					$vac = "CALL spVaciarCarrito('$idU');";
					$empty = $conexion->query($vac);
					$conexion->close();

				}
			}
		}
	}

}
else
{
	if(isset($_REQUEST['pconfirma'])){
		$idU = $_REQUEST['idUser'];
		$pago =$_REQUEST['pago'];
		$accion = $_REQUEST['pconfirma'];

		if($accion == "confirmar"){
			require("conexion.php");
			$confirm = "CALL spConfirmarCompra('$idU','$pago');";
			$conf = $conexion->query($confirm);
			$conexion->close();

		}
		
	}
}




?>