<?php
$name = null;
$val = false;
if(isset($_COOKIE['usuario'])){
	$name = $_COOKIE['usuario'];
	$name = htmlspecialchars($name);
	$val = true;

	echo "<script>alert('".$name."');</script>";
}

session_start();
if(isset($_SESSION['logueado'])){
    
     $comprar = TRUE;
     $nickname = $_SESSION['nick'];
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



require('phpfiles/conexion.php');



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

<script src="js/jQuery3.3.1/jquery.min.js" type="text/javascript" charset="utf-8" async defer></script>
<script src="js/utilerias.js" type="text/javascript" charset="utf-8" async defer></script>
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
			
            <div class="icontext col-md-3-24 intelink">	
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
                                                echo " Login <i class=\"fa fa-caret-down\"></i>" ;
                                            }
                                        
                                        
                                        ?>
					
						 
					</a>
					<div class="dropdown-menu dropdown-menu-right" style="min-width:250px">
                                            
                                            
                         <form action="phpfiles/UserLogin.php" method="POST" class="px-4 py-3">
							<div class="form-group">
							  <label>Usuario</label>
							  <input class="form-control" placeholder="email@example.com" type="text" value="<?php echo $name; ?>" name="usuario">
							</div>
							<div class="form-group">
					 		 	<label>Password</label>
								<input class="form-control" placeholder="Password" type="password" name="pwd">
							</div>
							<div class="form-group">
								<input type="checkbox" id="recordar" name="recordar" value="<?php echo $val; ?>">
								<label for="recordar"><small>Recordar Contraseña</small></label>
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

<div id="result" class="col">
	<div>
		<br>	
			<div class="row">
				<div class="container col-9">
<!-- ================== 1-carousel bootstrap  ==================  -->
				<div id="carousel1_indicator" class="carousel slide" data-ride="carousel">
				  <ol class="carousel-indicators">
				    <li data-target="#carousel1_indicator" data-slide-to="0" class="active"></li>
				    <li data-target="#carousel1_indicator" data-slide-to="1"></li>
				    <li data-target="#carousel1_indicator" data-slide-to="2"></li>
				  </ol>
				  <div class="carousel-inner">


				    <div class="carousel-item active">
				      <img class="d-block w-100" src="img/carrousel1.jpg" alt="First slide"> 
				    </div>
				    <div class="carousel-item">
				      <img class="d-block w-100" src="img/carrousel2.jpg" alt="Second slide">
				    </div>
				    <div class="carousel-item">
				      <img class="d-block w-100" src="img/carrousel3.jpg" alt="Third slide">
				    </div>


				  </div>
				  <a class="carousel-control-prev" href="#carousel1_indicator" role="button" data-slide="prev">
				    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
				    <span class="sr-only">Previous</span>
				  </a>
				  <a class="carousel-control-next" href="#carousel1_indicator" role="button" data-slide="next">
				    <span class="carousel-control-next-icon" aria-hidden="true"></span>
				    <span class="sr-only">Next</span>
				  </a>
				</div>
				</div>
<!-- ==================  1-carousel bootstrap ==================  .// -->		
			</div> <!-- col.// -->

		<br>
	</div>
	<div class="row-sm">
		<header id="byCat" class="destacados  mb-2">
			<br>
			<h2>Destacados del Mes</h2>
		</header><!-- /header -->
	</div>
	<div class="row-sm">

<?php 
	require('phpfiles/conexion.php');
	$opc = 4;
	$destacados = "CALL spPaginaPrincipal('$opc');";

	$mv = $conexion->query($destacados);


     if($mv){
	while($row = $mv->fetch_array()){

		$precio = asDollars($row['precio']);
            
        echo "<div class=\"col-md-3 col-sm-6\">
        		<a href=\"productDetail.php?product=".$row['idArticulo']."\" class=\"title\">
					<figure class=\"card card-product\">
						<div class=\"img-wrap\"> <img src=\"data:image/".$row['tipo'].";base64," .base64_encode($row['imagen'])."\"></div>
						<figcaption class=\"info-wrap\">
							<a href=\"productDetail.php?producto=".$row['idArticulo']."\" class=\"title\">".$row['nombreArticulo']."</a>
							<div class=\"price-wrap\">
								<span class=\"price-new\">".$precio."</span>
							</div>
						</figcaption>
					</figure> <!-- card // -->
					</a>
				</div>";
	}
	$mv->close();
    }
    $conexion->close();
?>


</div> <!-- DESTACADOS DEL MES -->

	<div class="row-sm">
		<header id="byCat" class="destacados  mb-2">
			<br>
			<h2>Lo más vendido</h2>
		</header><!-- /header -->
	</div>
	<div class="row-sm">

<?php
		require('phpfiles/conexion.php');
    $opc = 5;
	$masvendidos = "CALL spPaginaPrincipal('$opc');";

	$mv = $conexion->query($masvendidos);
	if($mv){
	while($row = $mv->fetch_array()){

		$precio = asDollars($row['precio']);
            
        echo "<div class=\"col-md-3 col-sm-6\">
        		<a href=\"productDetail.php?product=".$row['idArticulo']."\" class=\"title\">
					<figure class=\"card card-product\">
						<div class=\"img-wrap\"> <img src=\"data:image/".$row['tipo'].";base64," .base64_encode($row['imagen'])."\"></div>
						<figcaption class=\"info-wrap\">
							<a href=\"productDetail.php?producto=".$row['idArticulo']."\" class=\"title\">".$row['nombreArticulo']."</a>
							<div class=\"price-wrap\">
								<span class=\"price-new\">".$precio."</span>
							</div>
						</figcaption>
					</figure> <!-- card // -->
					</a>
				</div>";
	}
	$mv->close();
    }
	 $conexion->close();
?>
	
</div> <!-- MAS VENDIDOS -->



<div class="row-sm">
		<header id="byCat" class="destacados  mb-2">
			<br>
			<h2>Lo más visto</h2>
		</header><!-- /header -->
	</div>
	<div class="row-sm">
<?php
		require('phpfiles/conexion.php');
    $opc = 3;
	$masvendidos = "CALL spPaginaPrincipal('$opc');";

	$mv = $conexion->query($masvendidos);
	if($mv){
	while($row = $mv->fetch_array()){

		$precio = asDollars($row['precio']);
            
        echo "<div class=\"col-md-3 col-sm-6\">
        		<a href=\"productDetail.php?product=".$row['idArticulo']."\" class=\"title\">
					<figure class=\"card card-product\">
						<div class=\"img-wrap\"> <img src=\"data:image/".$row['tipo'].";base64," .base64_encode($row['imagen'])."\"></div>
						<figcaption class=\"info-wrap\">
							<a href=\"productDetail.php?producto=".$row['idArticulo']."\" class=\"title\">".$row['nombreArticulo']."</a>
							<div class=\"price-wrap\">
								<span class=\"price-new\">".$precio."</span>
							</div>
						</figcaption>
					</figure> <!-- card // -->
					</a>
				</div>";
	}
	$mv->close();
    }
	 $conexion->close();
?>
	
		
</div> <!-- MAS VISTOS -->
				
<div class="row-sm">
	<header id="byCat" class="destacados  mb-2">
		<br>
		<h2>Arituclos Nuevos!</h2>
	</header><!-- /header -->
</div>
<div class="row-sm">
	<?php
		require('phpfiles/conexion.php');
    $opc = 1;
	$masvendidos = "CALL spPaginaPrincipal('$opc');";

	$mv = $conexion->query($masvendidos);
	if($mv){
	while($row = $mv->fetch_array()){

		$precio = asDollars($row['precio']);
            
        echo "<div class=\"col-md-3 col-sm-6\">
        		<a href=\"productDetail.php?product=".$row['idArticulo']."\" class=\"title\">
					<figure class=\"card card-product\">
						<div class=\"img-wrap\"> <img src=\"data:image/".$row['tipo'].";base64," .base64_encode($row['imagen'])."\"></div>
						<figcaption class=\"info-wrap\">
							<a href=\"productDetail.php?producto=".$row['idArticulo']."\" class=\"title\">".$row['nombreArticulo']."</a>
							<div class=\"price-wrap\">
								<span class=\"price-new\">".$precio."</span>
							</div>
						</figcaption>
					</figure> <!-- card // -->
					</a>
				</div>";
	}
	$mv->close();
    }
	 $conexion->close();
?>



</div> <!-- NOVEDADES -->







<div class="row-sm">

		<header id="byCat" class="destacados byCat mb-2">
			<br>
			<h2>OFERTAS!</h2>
		</header><!-- /header -->

	</div>
	<div class="row-sm">

		

<?php
		require('phpfiles/conexion.php');
    $opc = 2;
	$masvendidos = "CALL spPaginaPrincipal('$opc');";

	$mv = $conexion->query($masvendidos);
	$rowCount = mysqli_num_rows($mv);

	if($mv){
		if($rowCount > 0){
	while($row = $mv->fetch_array()){

		$precio = asDollars($row['precio']);
            
        echo "<div class=\"col-md-3 col-sm-6\">
        		<a href=\"productDetail.php?product=".$row['idArticulo']."\" class=\"title\">
					<figure class=\"card card-product\">
						<div class=\"img-wrap\"> <img src=\"data:image/".$row['tipo'].";base64," .base64_encode($row['imagen'])."\"></div>
						<figcaption class=\"info-wrap\">
							<a href=\"productDetail.php?producto=".$row['idArticulo']."\" class=\"title\">".$row['nombreArticulo']."</a>
							<div class=\"price-wrap\">
								<span class=\"price-new\">".$precio."</span>
							</div>
						</figcaption>
					</figure> <!-- card // -->
					</a>
				</div>";
	}
	$mv->close();
    }
    else
    {
    	echo "<div class=col><p><h5> No hay productos con descuento en este momento </h5></p></div>";
    }
   }
    	
   
	 $conexion->close();
    
?>


</div> <!-- HOT SALE -->		
		
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

