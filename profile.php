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
<script src="js/bootstrap.min.js"></script>

<!-- custom styles -->
<link href="css/uikit.css" rel="stylesheet" type="text/css">
<link href="css/responsive.css" rel="stylesheet" media="only screen and (max-width: 1200px)">
<link href="css/asifCustumStyle.css" rel="stylesheet" type="text/css">

<script src="js/jQuery3.3.1/jquery.min.js" type="text/javascript" charset="utf-8" async defer></script>
<script src="js/utilerias.js"></script>
<script src="js/dynamicforms.js"></script>

<script src="js/popper.min.js"></script>

<script type="text/javascript" charset="utf-8" async defer>
	window.onload = function(){/*hace que se cargue la función lo que predetermina que div estará oculto hasta llamar a la función nuevamente*/
 muestra_oculta('EditarPerfil');
 muestra_oculta('CambiarContra');
 muestra_oculta('CambiarImagenes');/*  "contenido_a_mostrar" es el nombre que le dimos al DIV */

}

</script>

<script type="text/javascript" charset="utf-8" async defer>


$(document).ready(function(){
	$('#dateRange').hide();
 });


</script>


</head>

<?php 
    session_start();
    $comprar =  NULL;
    $nombre = NULL;
    $correoV = NULL;
    $tel = NULL;
    $port = NULL;
    $avat = NULL; 
    $nickV = NULL;
    $current_user = NULL;
   




    require('phpfiles/conexion.php');
    if(isset($_SESSION["logueado"])){
        if(($_SESSION["logueado"] == TRUE) && ($_SESSION['usuarioId'] == $_GET['idUsuario'])){

        	$current_user = $_SESSION['usuarioId'];

            $comprar = TRUE;
            $nickname = $_SESSION['nick'];
           $img = 'CALL spDatosVendedor(' .$_SESSION['usuarioId']. ');';
           $res = $conexion->query($img);
		if($res)
		{
			while($row = $res->fetch_array())
			{
				$nombre = $row['nombre'];
   				$correoV = $row['email'];
  				$tel = $row['tel'];;
				$port =$row['portada'];
                $avat = $row['avatar'];
                             
	
			}
			$res->close();
		}
		$conexion->close();
		
        } 
        else{


            $comprar = TRUE;
           $img = 'CALL spDatosVendedor(' .$_GET['idUsuario']. ');';
           $res = $conexion->query($img);
		if($res)
		{
			while($row = $res->fetch_array())
			{
				$nombre = $row['nombre'];
   				$correoV = $row['email'];
  				$tel = $row['tel'];;
				$port =$row['portada'];
                $avat = $row['avatar'];
                   $nickV = $row['nickname'];             
	
			}
			$res->close();
		}
		$conexion->close();
		
        }   	
    }
    else
    {
    	    $nickname = 'Login';
    	     $comprar = FALSE;
           $img = 'CALL spDatosVendedor(' .$_GET['idUsuario']. ');';
           $res = $conexion->query($img);
		if($res)
		{
			while($row = $res->fetch_array())
			{
				$nombre = $row['nombre'];
   				$correoV = $row['email'];
  				$tel = $row['tel'];;
				$port =$row['portada'];
                $avat = $row['avatar'];
                   $nickV = $row['nickname'];             
	
			}
			$res->close();
		}
		$conexion->close();
		
           	
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


?>

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
			
<div class="icontext col-md-3-24 intelink">		
                            <?php 
                                 
                                            if($comprar == TRUE){
                                                echo '<div class="icon-wrap intelink"><img src="data:image/png;base64,'.base64_encode(  $_SESSION['avatar'] ).'"  class="rounded-circle img-ico"/></div>';
                                                echo '<div class="text-wrap dropdown intelink">';
                                                echo '<small class=\"little-text\">Bienvenido!</small>';
                                                echo "<a title=\"Ver perfil\" href=\"profile.php?idUsuario=".$_SESSION['usuarioId']."\" class=\"b intelink\" >";
                                                echo $_SESSION['nick'];
                                             }
                                            else
                                            {
                                                echo '<div class="icon-wrap intelink"><i class="icon-sm round border intelink fa fa-user intelink"></i></div>';
                                                echo '<div class="text-wrap dropdown intelink">';
                                                echo '<small class=\"little-text\">Inicie Sesión!</small>';
                                                echo "<a href=\"#\" class=\"b intelink\" data-toggle=\"dropdown\" data-offset=\"20,10\">";
                                                echo " Login <i class=\"fa fa-caret-down\"></i>" ;
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
					echo "<li class=\"labelCategoria\"><a href=\"searchResult.php?idCat=".$cat['idCategoria'] ."\">".$cat['nombreCategoria']." <span class=\"labelCategoria float-right badge badge-light round\">".$cat['cantidad']."</span> </a></li>";
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

<div id="result" class="col">
	<br>
	<div class="row">
		<br>
		<div class="col3">
	
                        <?php 
                        	
                            echo '<img src="data:image/png;base64,'.base64_encode( $avat ).'"  class="img-thumbnail avatarprofile"/>';
                     
                        ?>
		</div>
		<div class="col">

			
                         <?php 
                         	
                            echo '<img src="data:image/png;base64,'.base64_encode( $port ).'"alt="" class="back-profile"/>';
                        	
                        		
                        ?>
			<h2 id=profileName class="bottom-right"><?php if(isset($_SESSION['nick'])) { if(($_SESSION["logueado"] == TRUE) && ($_SESSION['usuarioId'] == $_GET['idUsuario']))echo $_SESSION['nick']; else echo  $nickV; } else {echo  $nickV;} ?></h2>
		</div>

	
		
	

	</div> <!-- IMAGENES DE PERFIL Y PORTADA -->
	<br>
	<br>
	






			<div class="row card-info" id="userData"> <!-- DATOS DE USUARIO -->
				<div class="col-md">
					
					<?php 
						if($comprar == TRUE){
							echo "<h3> Datos Personales </h3>";
							echo "<label>Nombre:    </label> \t\t" . $nombre;
							echo "<br>";
							echo  "<label>Correo:    </label>\t\t" . $correoV;
							echo "<br>";
							echo  "<label>Tel&eacute;fono:    </label>\t\t" .  $tel;
							echo "<br>";
							
						}
						else{

							echo "<h3> Datos Personales </h3>";
							echo "<label>Nombre: </label> \t\t" . $nombre;
							echo "<br>";
							echo  "<label>Correo: </label>\t\t" . $correoV;
							echo "<br>";
							echo  "<label>Tel&eacute;fono: </label>\t\t" .  $tel;
							echo "<br>";

						}

					?>
				</div> &nbsp;
				<div class="col-md">
				<?php  // BOTON PARA EDITAR PERFIL
						if(isset($_SESSION['logueado']))
						{ 
							if(($_SESSION["logueado"] == TRUE) && ($_SESSION['usuarioId'] == $_GET['idUsuario'])){
							echo "<button type=button onclick=\"muestra_oculta('CambiarContra');\" class=\"btn btn-primary\" style=\"float:right;\"> <i class=\"fas fa-key\"></i> &nbsp; Contraseña </button> \t";
							echo "<button type=button onclick=\"muestra_oculta('CambiarImagenes');\" class=\"btn btn-primary\" style=\"float:right;\"><i class=\"far fa-images\"></i>  &nbsp; Imagenes  </button>";
							echo "<button type=button onclick=\"muestra_oculta('EditarPerfil');\" class=\"btn btn-primary\" style=\"float:right;\"><i class=\"fas fa-user\"></i> &nbsp;  Editar Perfil   </button> \t";
							
							}
						}

				?>
				</div>
		</div> <!-- DATOS DE USUARIO -->
			
		
<br><br>




<!------------------------ DATOS PERSONALES ----------------------------------------------------->
			<div class=row id="EditarPerfil">
				<div class="col-8"><br><br>
					<form action="phpfiles/UpdateUsuario.php" method="POST" >
						<fieldset>
 							<legend>Editar Datos de Usuario</legend>

						<label>Nombre</label><br>
							<input class="form-control" type="text" name="nomU" value="" placeholder="<?php echo $nombre; ?>"><br>
						<label>Apellido</label><br>
							<input class="form-control" type="text" name="apellU" value="" placeholder=""><br>
						<label>Nickname</label><br>
							<input class="form-control" type="text" name="nickU" value="" placeholder="<?php echo $_SESSION['nick'] ?>"><br>
						<label>Tel&eacute;fono</label><br>
							<input class="form-control" type="text" name="telU" value="" placeholder="<?php echo $tel; ?>"><br>
						<label>Correo</label><br>
							<input class="form-control" type="email" name="mailU" value="" placeholder="<?php echo  $correoV; ?>"><br><br>
						<?php if(isset($_SESSION['usuarioId'])){ echo "<input  type=\"hidden\" name=\"idUser\" value=\"".$_SESSION['usuarioId']."\" >"; } ?>
						<input class="btn" type="submit" name="guardarPerfil" value="Guardar">  &nbsp; &nbsp; &nbsp;
						<button type="button" class="btn" onclick="muestra_oculta('EditarPerfil');"> Cancelar</button>

					</fieldset>
					</form>	
					</div>
					<br>
					<br>
			</div>

<!------------------------ CONTRASEÑA ----------------------------------------------------->
			<div class="row" id="CambiarContra">
				<div class="col-8">

					<form action="phpfiles/UpdateUsuario.php" method="POST" >
						<fieldset>
 							<legend>Cambiar Contraseña</legend>


						<label>Nueva Contraseña</label><br>
							<input class="form-control" type="password" name="passW" value="" placeholder=""><br>
						<label>Confirmar Contraseña</label><br>
							<input class="form-control" type="password" name="passW-confirm" value="" placeholder=""><br>
							<?php if(isset($_SESSION['usuarioId'])){ echo "<input  type=\"hidden\" name=\"idUser\" value=\"".$_SESSION['usuarioId']."\" >"; } ?>
						<input class="btn" type="submit" name="guardarPass" value="Guardar">  &nbsp; &nbsp; &nbsp;
						<input class="btn" type="reset" name="cancelar" value="Cancelar" onclick="muestra_oculta('CambiarContra');">


					</fieldset>
					</form>
				</div>
				<br>
				<br>
			</div>

<!------------------------ IMAGENES ----------------------------------------------------->
			<div class="row" id="CambiarImagenes">
				<div class="col-8">
					<form action="phpfiles/UpdateUsuario.php" method="POST" runat="server" enctype="multipart/form-data"><br>
						<fieldset>
 							<legend>Cambiar imagenes</legend>

						<label for="avatar_update" >Avatar</label><br>
						<input class="form-control" type="file" name="avatar_update"  placeholder=""><br>
						<label for="portada_update">Portada</label><br>
						<input  class="form-control" type="file" name="portada_update"  placeholder=""><br>
						<?php if(isset($_SESSION['usuarioId'])){ echo "<input  type=\"hidden\" name=\"idUser\" value=\"".$_SESSION['usuarioId']."\" >"; } ?>
						<input class="btn" type="submit" name="guardarImg" value="Guardar"> &nbsp; &nbsp; &nbsp;
						<input class="btn" type="reset" name="cancelar" value="Cancelar" onclick="muestra_oculta('CambiarImagenes');">

					</fieldset>
					</form>
				</div>
				<br><br>
			</div>
					

	<div class="row">

		
			
<?php 
		require('phpfiles/conexion.php');
			$count = 1;
			if(isset($_GET['idUsuario'])){
						
						



		$pdtos =  "CALL spArticulosEnVenta('".$_GET['idUsuario']."');";

		$p = $conexion->query($pdtos);
        $rowCount = mysqli_num_rows($p);
     	$precio = NULL;

      
		if($p)
		{
?>


<header id="header" class=" productos-header">
	
			<table width="100%">
				
					<tr>
						<td><h5>Productos en Venta  </h5></td>
						<td></td>
						<td></td>
						<td></td>
						<td> Total: <?php echo  $rowCount; ?></td>
					</tr>
				
			</table>

			

		</header><!-- /header -->
		
<div id=ventas>
			<table class="table table-hover table-fixed" >
				  <thead>
				    <tr>
				      <th class="col-xs ventastable" scope="col">ID</th>
				      <th class="col-xs ventastable" scope="col">Nombre </th>
				      <th class="col-xs  ventastable" scope="col">Precio</th>
				      <th class="col-xs  ventastable" scope="col">Miniatura</th>
				       <th class="col-xs ventastable" scope="col">Detalle</th>
				      
				    </tr>
				  </thead>
				  <tbody>



<?php
		
			
			
			while($row = $p->fetch_array())
			{
		
				$precio = asDollars($row['precio']);
				echo "<tr>
				      <td  scope=\"row\">".$row['idArticulo']."</td>
				      <td >".$row['nombreArticulo']."</td>
				      <td>".$precio."</td>
				       <td ><img class=\"img-min\" src=\"data:image/".$row['tipo'].";base64,".base64_encode( $row['imagen'] )."\" alt=\"\"></td>
				      <td ><a class=\"table-link\" href=\"productDetail.php?product=".$row['idArticulo']."\"> Ver <i class=\"fas fa-search\"></i></a>
				      <a class=\"table-link\" href=\"newProduct.php?idProducto=".$row['idArticulo']."\">Editar &nbsp;<i class=\"fas fa-edit\"></i></a></td>
				    </tr>";




                                
	
			}
			$p->close();
			
		}
		$conexion->close();

}
?>
			

				    
				   
				  </tbody>
			</table>
		</div>
	</div>


<div class="row">  <!-- PRODUCTOS EN VENTA --> <!-- HISTORIAL DE COMPRAS -->
	<div class="col">
		<div id="nav-pagination" >
		<nav aria-label="Page navigation example">
  				<ul class="pagination justify-content-center">
   					 <li class="page-item disabled">
     					 <a class="page-link" href="#" tabindex="-1">Anterior</a>
   					 </li>

						<?php 
						
						//	while($count<=$total_paginas ){
						//		echo '<li class="page-item"><a class="page-link" href="profile.php?idUsuario='.$current_user.'&plast='.$last.'">'.$count.'</a></li>';	
						//		$count++;
						//		$aux = $current;
						//		$current= $last;
						//		$last = $last + $current;


							//}

						?>

					

   					 <li class="page-item">
    					  <a class="page-link" href="#">Siguiente</a>
    					</li>
 				 </ul>
			</nav>
	</div>
	</div>	

</div> <!-- PRODUCTOS EN VENTA -->


<br>
<br>

<div class="row">


<?php 
	require('phpfiles/conexion.php');
			$count = 1;
			$user = NULL;
			$borradores = NULL;
			if(isset($_SESSION['usuarioId'])){

				if($_SESSION['usuarioId'] == $_GET['idUsuario'] ){

		echo '<header id="header" class="productos-header">
			<h5>Productos No Publicados</h5>
		</header><!-- /header -->
		
		<div id=ventas>
			<table class="table table-hover table-fixed">
				  <thead>
				    <tr>
				      <th class="col-xs ventastable" scope="col">ID</th>
				      <th class="col-xs ventastable" scope="col">Nombre </th>
				      <th class="col-xs ventastable" scope="col">Precio</th>
				      <th class="col-xs ventastable" scope="col">Miniatura</th>
				       <th class="col-xs ventastable" scope="col">Accion</th>
				      
				    </tr>
				  </thead>
				  <tbody>';
			

	
		
					

			
		

		$pdtos =  "CALL spArticulosBorrador('".$_SESSION['usuarioId']."');";

		$p = $conexion->query($pdtos);

     	$precio = NULL;

     	$i = 0;

		if($p)
		{
			
			
			while($row = $p->fetch_array())
			{
				 $i=$i+1;
				$precio = asDollars($row['precio']);
				echo "<tr>
				      <th scope=\"row\">".$row['idArticulo']."</th>
				      <td>".$row['nombreArticulo']."</td>
				      <td>".$precio."</td>
				      <input type=\"hidden\" name=\"prod\" id=\"prod".$i."\" value=\"".$row['idArticulo']."\"/>
				      <td><img class=\"img-min\" src=\"data:".$row['tipo'].";base64,".base64_encode( $row['imagen'] )."\" alt=\"\"></td>
				      <td><a class=\"table-link\" href=\"newProduct.php?idProducto=".$row['idArticulo']."\">Editar &nbsp;<i class=\"fas fa-edit\"></i></a></td>
				    </tr>";




                                
	
			}
			$p->close();
			
		}
		$conexion->close();

				   
				echo   '</tbody>
			</table>
		</div>


		<div class="row">  <!-- PRODUCTOS EN VENTA --> <!-- HISTORIAL DE COMPRAS -->
	<div class="col-3">
		<a href="newProduct.php"><button id="new" class="btn btn-primary" type="button" ><i class="fas fa-cart-plus"></i> &nbsp; Nuevo Producto</button></a>
	</div>
	
</div>'; 
	}
}
?>
			

				    

	</div>










	<br>
	<br>

	

	<?php 
		require('phpfiles/conexion.php');
			$count = 1;
		if(isset($_SESSION['usuarioId'])){

				if($_SESSION['usuarioId'] == $_GET['idUsuario'] ){

		echo '<div class="row"> <!-- HISTORIAL DE COMPRAS -->


		<header id="header" class="compras-header">
			<h5>Historial de Compras</h5>
		</header><!-- /header -->
		<div id=history >
			<table class="table table-hover">
				  <thead>
				    <tr>
				      <th class="headtable" scope="col">ID</th>
				      <th class="headtable" scope="col">Fecha </th>
				      <th class="headtable" scope="col">Costo</th>
				       <th class="headtable" scope="col">Detalle</th>
				      
				    </tr>
				  </thead>
				  <tbody>';


						

			
		$currentU = $_SESSION['usuarioId'];

		$pdtos =  "CALL spHistorialCompras('$currentU');";

		$p = $conexion->query($pdtos);

     	$precio = NULL;

      

		if($p)
		{
			
			
			while($row = $p->fetch_array())
			{
		
				$precio = asDollars($row['costo']);
				echo '<tr>
				      <th scope="row">'.$row['idCompra'].'</th>
				      <td>'.$row['fechaC'].'</td>
				      <td>'.$precio.'</td>
				      <td><a onclick="verCompra('.$row['idCompra'].');" class="table-link" data-toggle="modal" data-target="#myModal" href="#">Ver &nbsp;<i class="fas fa-search"></i></a></td>
				    </tr>';




                                
	
			}
			$p->close();
			
		}
		$conexion->close();



		echo		  '</tbody>
			</table>
		</div>
	</div>
	<div class="row" id="nav-pagination" >
		
	</div>';


}
}
?>
			
				    
				   


	<div class="row">
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
	</div>





<!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">DETALLE DE SU COMPRA</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <table class="table table-hover table-fixed">
          	
          	<thead>
          		<tr>
          			<th>Cantidad</th>
          			<th>Producto</th>
          			<th>Subtotal</th>
          		</tr>
          	</thead>
          	<tbody id="detallesTabla">
          	
          	</tbody>
          </table>
		

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
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





<script>
	function verCompra(id){

		var compra = parseInt(id);
		var parametros= {
			"idCompra" : compra,
			"detalles" : "details",
		};

		

		$.ajax({
					data: parametros,
					url: "phpfiles/DetalleCompra.php",
					type: "POST",
					beforessend: function(){
						alert('ok');
						document.getElementById("detallesTabla").innerHTML = "";

					},
					success: function(response){
						
							
						document.getElementById("detallesTabla").innerHTML = response;	
						
						
					}		
				});


	}
</script>


</body>
</html>