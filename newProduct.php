<?php
session_start();
$idU = NULL;
if(isset($_SESSION['logueado'])){
    
     $comprar = TRUE;
     $nickname = $_SESSION['nick'];
     $idU = $_SESSION['usuarioId'];
     $perfil = "profile.php?idUsuario=".$_SESSION['usuarioId'];
     require("phpfiles/conexion.php");
     $img = 'CALL spGetProfileImages(' .$_SESSION['usuarioId']. ');';
     $res = $conexion->query($img);
     if($res){
	while($row = $res->fetch_array()){
            
            $_SESSION['avatar'] = $row['avatar'];
	}
	$res->close();
    }
    $conexion->close();
     
}
else
{ 
    $comprar = FALSE;
   $nickname = "Login";
   $perfil = "#";
}

function logOut(){
	if(isset($_SESSION["logueado"])){		
		session_destroy();
		header("Refresh:0 url=index.php");
	}
}

 if (isset($_GET['salir'])) {
    logOut();
  }
  
  
function asDollars($value) {
  return '$   ' . number_format($value, 2);
}

$nombre =NULL;
$desc = NULL;
$proce = NULL;
$unid = NULL;
$descuento = NULL;

require('phpfiles/conexion.php');
	if(isset($_GET['idProducto'])){
		$id = $_GET['idProducto'];

		$detalles = "CALL spFormDetallesArticulo('$id');";

		$restd = $conexion->query($detalles);

		if($restd){
			while($data = $restd->fetch_array())
			{
					$nombre =  $data['nombreArticulo'];
					 $desc = $data['descripcion'];
					 $proce =  $data['precio'];
					 $unid =  $data['unidades'];
					 $descuento = $data['descuento'];
		}
		}
	}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>As If!</title>
<!-- jQuery -->
<script src="js/jquery-2.0.0.min.js" type="text/javascript"></script>

<!-- Bootstrap4 files-->
<script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
<link href="css/bootstrap-custom.css" rel="stylesheet" type="text/css"/>

<!-- Font awesome 5 -->
<link href="fonts/fontawesome/css/fontawesome-all.min.css" type="text/css" rel="stylesheet">

<!-- plugin: fancybox  -->
<script src="plugins/fancybox/fancybox.min.js" type="text/javascript"></script>
<link href="plugins/fancybox/fancybox.min.css" type="text/css" rel="stylesheet">

<!-- code highlighter -->
<link href="plugins/prism/prism.css" rel="stylesheet" >
<script src="plugins/prism/prism.js"></script>


<!-- bootstrap4 -->
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">

<!-- custom styles -->
<link href="css/uikit.css" rel="stylesheet" type="text/css">
<link href="css/responsive.css" rel="stylesheet" media="only screen and (max-width: 1200px)">
<link href="css/asifCustumStyle.css" rel="stylesheet" type="text/css">
<link href="css/NewProduct.css" rel="stylesheet" type="text/css">

<script src="js/jQuery3.3.1/jquery.min.js" type="text/javascript" charset="utf-8" async defer></script>
<script src="js/utilerias.js" type="text/javascript" charset="utf-8" async defer></script>
<script src="js/dynamicforms.js"></script>


<script type="text/javascript" charset="utf-8" async defer>




$(document).ready(function(){
	$('#dateRange').hide();




 });


</script>

</head>
<body>
	

<header class="col section-header">
		<nav class="navbar navbar-landing  navbar-expand navbar-dark menu-bar mb-2 row">

			<div id="logo" class="col-2">
				<img src="logo.png" alt="logo.jpg">
			</div>

			<div id="searchBar" class="col-md">	

				<script  type="text/javascript" charset="utf-8" >
					$(document).ready(function(){
   					 $('#send-frm').on('click',function(event){
     			   		var optionText = $("#filtros-select option:selected").val();
     			   		 var valueSearch = $("#searhbar").val();
     			   		 var desde = $('#desde').val();
     			   		 var hasta =  $('#hasta').val();
     			   		if((optionText>0 && optionText <4 ) && valueSearch!=""){

     			   			$("#busquedaMixta").submit();

     			   		}else if((optionText == 5 || optionText == 4) && (desde!="" && hasta!="")){
     			   				$('#send-frm').val() = true;
     			   				$("#searhbar").val() = '0';
     			   				$("#busquedaMixta").submit();
     			   		}else{
     			   			alert('Por favor revise que todos los criterios de busqueda sean válidos.');
     			   			event.preventDefault();
     			   		}
        	
   					 });
   					 	 });

					$(document).ready(function(){

   					 $('#filtros-select').on('change',function(e){
   					 	var val = this.value;
   					 	if(val == 4 || val == 5){
   					 		$('#dateRange').show();
   					 		$("#desde").prop('required',true);
   					 		 $("#hasta").prop('required',true);
   					 	}
   					 	else{
   					 		$('#dateRange').hide();
   					 	}
   					 });

					});
				</script>

				<form action="searchResult.php" method="GET" id="busquedaMixta" class="search-wrap">
					<div class="row input-group w-100">
				    <input type="text" id="searhbar" name="searchValue" class="form-control" style="width:65%;" placeholder="Buscar..." required>
				    <select id="filtros-select" class="custom-select"  name="filter" required>
				    		<option value="0">Seleccione</option>
				    		<option value="1">Vendedor</option>
							<option value="2">Nombre</option>
							<option value="3">Descripcion</option>							
							<option value="4">Fecha</option>
							<option value="5">Milticriterio</option>
					</select>
				    <div class="input-group-append">
				      <button class="btn intelink btn-asif" id="send-frm" name="buscar" type="submit" value="true"> 
				        <i class="fa fa-search"></i>
				      </button> 
				   	 </div>
			 	   </div>&nbsp;
			 	   <div class="row input-group-append" id="dateRange">
				 	   	<div class="col-md-1">
				 	   		<label for="desde" class="intelink labelBold"><i"> Desde: </label>
				 	   	</div>
				 	   	<div class="col-md-3">
			 	   		<input type="date"  class="form-control" id="desde" name="desde" value="" placeholder="">
				 	   	</div>
				 	   	<div class="col-md-1">
			 	   		</div>
				 	   	<div class="col-md-1">
			 	   			<label for="hasta"  class="intelink labelBold"> Hasta:  </label>
			 	   		</div>
			 	   		<div class="col-md-3">
			 	   			<input type="date"  class="form-control" id="hasta" name="hasta" value="" placeholder="">
			 	   		</div>
			 	   		

			 	   </div>
				</form> <!-- search-wrap .end// -->
			</div> <!-- col.// -->
			

			<div class="icontext col-2">		
 				<?php 
                                 
                    if($comprar == TRUE){
                        echo '<div class="icon-wrap intelink"><img src="data:image/png;base64,'.base64_encode(  $_SESSION['avatar'] ).'"  class="rounded-circle img-ico"/></div>';
                        echo '<div class="text-wrap dropdown intelink">';
                        echo '<small class=\"little-text\">Bienvenido!</small>';
                        echo "<a title=\"Ver perfil\" href=\"profile.php?idUsuario=".$_SESSION['usuarioId']."\" class=\"b intelink\" >";
                        echo $nickname;
                     }
                    else
                    {
                        echo '<div class="icon-wrap intelink"><i class="icon-sm round border intelink fa fa-user intelink"></i></div>';
                        echo '<div class="text-wrap dropdown intelink">';
                        echo '<small class=\"little-text\">Inicie Sesión!</small>';
                        echo "<a href=\"#\" class=\"b intelink\" data-toggle=\"dropdown\" data-offset=\"20,10\">";
                        echo $nickname." <i class=\"fa fa-caret-down\"></i>" ;
                    }
                                        
                                        
                ?>
					
						 
					</a>
					<div class="dropdown-menu dropdown-menu-right" style="min-width:250px">
                                            
                                            
                         <form action="phpfiles/UserLogin.php" method="POST" class="px-4 py-3">
							<div class="form-group">
							  <label>Usuario</label>
							  <input class="form-control" placeholder="email@example.com" type="text" name="usuario">
							</div>
							<div class="form-group">
					 		 	<label>Password</label>
								<input class="form-control" placeholder="Password" type="password" name="pwd">
							</div>
								<button type="submit" class="btn btn-primary" name="entrar">Sign in</button> &nbsp;&nbsp;&nbsp;&nbsp;
								<a href="register.php"><button type="button" class="btn btn-success">Crear cuenta</button></a>
						</form>	
					</div> <!--  dropdown-menu .// -->
				</div> <!-- text-wrap.// -->
			</div> <!-- icontext.// -->

			<div class="icontext col-md-2-24">
				<?php
					if($comprar == TRUE){

						echo "<div class=\"icon-wrap\"><a href=\"shopCart.php?idUsuario=".$_SESSION['usuarioId']."\"><i class=\"icon-sm round intelink  fa fa-shopping-cart\"></i></a></div>
						<div class=\"text-wrap dropdown\">
					<small class=\"little-text\">Ver</small><a href=\"shopCart.php?idUsuario=".$_SESSION['usuarioId']."\" class=\"b intelink\"  data-offset=\"20,10\"> Carrito  </a></div>";

					}else
					{
						echo "<div class=\"icon-wrap \"><a href=\"shopCart.php\"><i class=\"icon-sm round intelink  fa fa-shopping-cart\"></i></a></div>
							<div class=\"text-wrap dropdown\">
							<small class=\"little-text\">Ver</small><a href=\"#\"  class=\"b intelink\"  data-offset=\"20,10\"> Carrito  </a></div>";
					}
					?>
			</div> <!-- icontext.// -->
                        
                        
                        
                         <?php 
                           if($comprar == TRUE){
                               echo "<div class=\"icontext col-md-1\"><div class=\"icon-wrap \" style=\"text-align: right; \"><a class=\"b intelink\" href=\"index.php?salir=true\" onclick=\"<php? logOut(); ?>\"> 
                                   <i title=\"Cerrar Sesión\" class=\"fas fa-sign-out-alt intelink\"></i> Salir</a></div></div> <!-- icontext.// -->";
                            }
                         ?>                        
</nav>
</header>
		
<main class="container col-11">

	<div class="row">
		<br><br><br><br>
	</div>
<div id="content" class="row">
		<div id="categorias" class="col-2 cardBackground" >



				<div id="lista-categorias" class="card card-filter collapse show">
					<article class="card-group-item">
						<header class="card-header moda">
							<a class="link-cat" aria-expanded="false" href="#" data-toggle="collapse" data-target="#ca1">
								<i class="icon-action fas fa-bars"></i>

								<h6 class="title on"> Categor&iacute;as</h6>
							</a>
						</header>
						<div style="" class="filter-content collapse show" id="ca1">
							<div class="card-body cardBackground">
								<ul class="list-unstyled list-lg">


				<?php 
					require('phpfiles/conexion.php');
						$cate = "CALL spVerCategorias();";
						$resul = $conexion->query($cate);

							if($resul){
								while($cat = $resul->fetch_array())
								{
									echo "<li class=\"labelCategoria\"><a href=\"searchResult.php?buscar=true&filter=6&idCat=".$cat['idCategoria'] ."\">".$cat['nombreCategoria']." <span class=\"labelCategoria float-right badge badge-light round\">".$cat['cantidad']."</span> </a></li>";
								}
								$resul->close();
							}
						$conexion->close();

				?>
						</ul>  
					</div> <!-- card-body.// -->
				</div> <!-- collapse .// -->
			</article> <!-- card-group-item.// -->
		</div> <!-- card.// -->
		<div class="opcinesExtras">		
		</div>
	</div>			



<div id="result" class="col-8">



<div class="row" id="NewProduct">
	<div class=col>
		<form name="dynamicForm" action="phpfiles/CRUDProducto.php" id="dynamicForm" method="POST" runat="server" enctype="multipart/form-data">
		<div><br><h2 class="reg"><?php if(isset($_GET['idProducto'])){ echo 'Editar Producto'; }else{echo 'Nuevo arituclo';}?></h2><br></div>
		<?php if(isset($_GET['idProducto']))
		{
			echo "<input type=\"hidden\" name=\"idUp\" value=\"".$_GET['idProducto']."\">";

		}
		?>
		
		<label for="productName">Nombre</label><br>
		<input id="productName" class=form-control type="text" name="nombre" value="<?php if(isset($_GET['idProducto'])){ echo $nombre; }?>" placeholder=""> <br><br>


		<label for="description">Descripción</label><br>
		<textarea id = "description" class="form-control"  name="descripcion"> <?php if(isset($_GET['idProducto'])){ echo $desc; }?> </textarea><br><br>
	</div>
</div>
<div class="row">
	<div class=col>
		<table >
			<tr>
				<td ><label for="price"><small>Precio: $</small></label></td>
				<td width="10"></td>
				<td><input id="price" class="form-control" type="number" min="1.00" step=".01" name="precio" value="<?php if(isset($_GET['idProducto'])){ echo $proce; } else{echo "1.00";}?>" placeholder=""></td>
				<td width="40"></td>
				<td><label for="cant"><small>Cantidad: </small></label></td>
				<td width="10"></td>
				<td><input id="cant" class="form-control" type="number" min="1" name="unidades" value="<?php if(isset($_GET['idProducto'])){ echo $unid; }else{echo "1";}?>" placeholder=""></td>
				<td width="40"></td>
				<td><label for="descuento"><small>Descuento: %</small></label></td>
				<td width="10"></td>
				<td><input id="descuento" class="form-control" type="number" max=100 min=0 name="descuento" value="<?php if(isset($_GET['idProducto'])){ echo $descuento;}else{echo "0";}?>" placeholder=""></td>

			</tr>

		</table>
			
	
</div>
	
</div>

<br><br>



<div class="row">
	<input type="hidden" name="idUser" value="<?php echo $idU; ?>">

	</script>
  		<?php 
  			require("phpfiles/conexion.php");
  			$q = "CALL spCampoCategoria();";
  			$ctgn =  $conexion->query($q);

  			if($ctgn)
  			{
  				
  					
  		?>
	<div class="col">
		 <select id="categorias" name="category[]" multiple="multiple" class="form-control"  style="height:200px;">
 			<option value="0" disabled>Elija una o m&aacute;s categor&iacute;as</option>
  			
			<?php
				while($row = $ctgn->fetch_array()){ 
				echo '<option value="'.$row['idCategoria'].'">'.$row['nombreCategoria'].'</option>';
  				}
  				$ctgn->close();
  			}
  			$conexion->close();
  				?>
		</select>
		
	</div>


<?php
			require('phpfiles/conexion.php');
			$catId=array();
			 if(isset($_GET['idProducto'])){

			 			$id= $_GET['idProducto'];
			 			
			 			
						$cate = "CALL spCateogiasArticulo('$id');";
						$resul = $conexion->query($cate);

							if($resul){
								while($cat = $resul->fetch_array())
								{
									array_push($catId,$cat['idCategoria']);
									

									
								}
								$resul->close();
							}
						$conexion->close(); 
					}

					
		?>

	<script>
		$(document).ready(function(){
			function myFunction() {
				<?php 
				$long = count($catId);
			
				for($i=0; $i<$long; $i++)
			   {
			   	echo 'document.getElementById("categorias").selectedIndex = '.$catId[$i].';';
			   }
			    ?>
			}
			});
	</script>


</div>







	<br><br><br>





<?php
if(isset($_GET['idProducto'])){
 echo "<div class=\"row\"><br><br></div>";
}
else{
echo "<div class=\"row\">
		<div class=\"col-md-4\">
			<h4>Imagenes del Producto</h4>
		</div>
		<div class=\"col-md-2\">
			
		</div>
		
</div>
	<br>
<div class=\"row\">
		<div id=\"imagesP\" class=\"col\">
			<div class=\"row\"><div class=\"col-md-5\">
				<input type=\"file\"  class=\"form-control-file\" name=\"img[]\" multiple>
			</div>
			<div class=\"col-md-1\">
				
			</div>
			<div class=\"col-md\"></div><br><br>
			</div>
		</div>
		
</div>
		<br><br><br>
<div class=\"row\">
		<div class=\"col-md-4\">
			<h4>Videos</h4>
		</div>
			<div class=\"col-md-2\">
			
			</div>
		
</div>
	<br>
<div class=\"row\">
	<div id=\"videosP\" class=\"col\">
		<div class=\"row\"><div class=\"col-md-5\">
			<input type=\"file\" class=\"form-control-file\" accept=\"video/mp4\" name=\"vid[]\" multiple>
		</div>
		<div class=\"col-md-\">
			
		</div>
			<div class=\"col-md\"></div><br><br>
		</div>


	</div>
</div>

<div class=\"row\">
	<br><br>
</div>";
}

?>

</div>







<div class="col">
	<div class="row">
	<br>
	</div>

	<div class="row">
		<?php 
		if(isset($_GET['idProducto'])){
			echo "<input class=\"btn btn-info\"  type=\"submit\" name=\"update\" value=\"Guardar Cambios\">";
			echo "<input type=\"hidden\" name=\"id\" value=\"".$_GET['idProducto']."\">";

		}
		else{
				echo '<input class="btn btn-info"  type="submit" name="borrador" value="Guardar Borrador">';
		}
		?>
	</div>
	
	<br>
	<div class="row">
		<input class="btn btn-info"  type="reset" name="cancelar" value="Cancelar Cambios"><br>
	</div>
	</form>
	<br>
	<div class="row">
		<form method="POST" action="phpfiles/CRUDProducto.php">
		<input type="hidden" name="idUserPub" value="<?php echo $idU; ?>">
			<?php if(isset($_GET['idProducto'])){
		
			echo "<input type=\"hidden\" name=\"idPro\" value=\"".$_GET['idProducto']."\">";
		}
		?>
		<input class="btn btn-info"  type="submit" name="publicar" value="Publicar Producto">
	</form>
	</div>
	<br>
	<div class="row">
	<form method="POST" action="phpfiles/CRUDProducto.php">
		<input type="hidden" name="idUserDel" value="<?php echo $idU; ?>">
		<?php if(isset($_GET['idProducto'])){
		
			echo "<input type=\"hidden\" name=\"id\" value=\"".$_GET['idProducto']."\">";
		}
		?>
		<input type="hidden" name="idVendedor" value="<?php echo $_SESSION['idUser'];?>">
		<input class="btn btn-info"  type="submit" name="eliminar" value="Eliminar Producto">
	</form>
	</div>
	
	
</div>

</div> <!-- RESULT AREA -->	



</div> <!-- CONTENT AREA -->

		<footer id="piePrincipal" class="row">
			<div id="contact-data" class="col">
				
			</article>
			<div  id="copyright" class="col">
				<p id="firma" class="text-center"> As If! Store Copyright &copy; 2018 	|	Powered by Antonio Garc&iacute;a</p>
			</div>
		</footer>

	</main>

</body>
</html>