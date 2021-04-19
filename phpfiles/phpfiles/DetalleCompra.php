<?php
require("conexion.php");
if(isset($_REQUEST['detalles'])){
	$id = $_REQUEST['idCompra'];
	$de= $_REQUEST['detalles'];

	if($de == "details"){
		$q ="CALL spVerDetallesCompra('$id');";

		$result = $conexion->query($q);
		if($result){
			while($row = $result->fetch_array()){
				echo "<tr>
						<td>".$row['cantidad']."</td>
						<td>".$row['nombreArticulo']."</td>
						<td>".$row['costo']."</td>
					</tr>";
			}
			$result->close();
		}

	}



}

?>