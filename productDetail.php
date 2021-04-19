<?php

$idPdto=NULL;
$precio = NULL;
$nombreArt = NULL;
$desc = NULL;
$stock = NULL;
$UsuarioVendedor = NULL;
$valoracion = NULL;
$cuentaComent = NULL;
$cuentaVentas = NULL;
$textoDes = NULL;
$idVendedor = NULL;

$idComprador = NULL;





session_start();
if(isset($_SESSION['logueado'])){
    
     $comprar = TRUE;
     $nickname = $_SESSION['nick'];
     $perfil = "profile.php?idUsuario=".$_SESSION['usuarioId'];
     $idComprador = $_SESSION['usuarioId'];
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
    $idComprador = 0;
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
  


if(isset($_POST['AddComentario'])){
	require('phpfiles/conexion.php');
	$pd = $_POST['productoId'];
	$coment = $_POST['comentarioAdd'];
	$id = $_POST['usuario'];
	$insert = "CALL spComentarProducto('$id','$pd','$coment');";
     $resp = $conexion->query($insert);	

    if($resp){
    	header("refresh:0");
    	 }
}


 if (isset($_GET['product'])){
 	
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
	<div id="categorias" class="col-2 cardBackground">
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

<div class="row">
<div class="col-xl-10 col-md-9 col-sm-12">


<script>
	function changeImg(id){
		document.getElementById("view-img").src = document.getElementById(id).src;
		document.getElementById("link-img").href = document.getElementById(id).src;

	}

</script>



<main class="card">
<?php
if(isset($_GET['product'])){
		require("phpfiles/conexion.php");

$imagen = NULL;
$tipo = NULL;
		$idPdto = $_GET['product'];
		$det = "CALL spGetSimpleImage('$idPdto');";
		$res = $conexion->query($det);

		if($res){
			while($rw = $res->fetch_array()){
			

			

?>
	<div class="row no-gutters">
		<aside class="col-sm-6 border-right">
<article class="gallery-wrap"> 
<div class="img-big-wrap" style=" height: 400px;">

  <div id="preview" style="text-align: center;"> 
  	<?php echo "<img  src=\"data:".$rw['tipo'].";base64,". base64_encode($rw['imagen'])."\">" ;?>
  </div>
  <?php 
  }
			$res->close();
}
}
  ?>
</div> <!-- slider-product.// -->
<div class="img-small-wrap">
<?php 
if(isset($_GET['product'])){
		require("phpfiles/conexion.php");


		$idPdto = $_GET['product'];
		$det = "CALL spGetImagenesProducto('$idPdto');";
		$vids = "CALL spGetVideosProducto('$idPdto');";
    	$res = $conexion->query($det);

   		if($res){
   			while($row = $res->fetch_array()){
   					  	echo "<a href=\"#\" onclick=\"changeContent('img".$row['idImagen']. "','preview');\" ><div id=\"img".$row['idImagen']. "\" class=\"item-gallery\" ><img class=\"thumbnail\" src=\" data:image/".$row['tipo'].";base64,". base64_encode($row['imagen']) ."\"></div></a>";	 
   			
			}
			$res->close();
			require("phpfiles/conexion.php");
			$vds = $conexion->query($vids);
				if($vds){
					while($row = $vds->fetch_array()){
	   					  	echo "<a href=\"#\" onclick=\"changeContent('img".$row['idVideo']. "','preview');\" ><div id=\"img".$row['idVideo']. "\" class=\"item-gallery\" >	   					  	
	   					  	<video src=\" ".$row['ruta']."\" controls ></video></div></a>";	 
	   			
				}
			}
			
   		}
   		$conexion->close();




	}

?>	
 
<script>
	function changeContent(fuente, destino){
		var MyDiv1 = document.getElementById(fuente);
	    var MyDiv2 = document.getElementById(destino);
	   MyDiv2.innerHTML = MyDiv1.innerHTML;
	}
</script>				

</div> <!-- slider-nav.// -->
</article> <!-- gallery-wrap .end// -->
		</aside>




<aside class="col-sm-6">
<article class="card-body">


<?php 


	if(isset($_GET['product'])){
		require("phpfiles/conexion.php");
		require("phpfiles/funciones.php");

		$idPdto = $_GET['product'];
		$det = "CALL spVerDetallesArticulo('$idPdto');";
    	$res = $conexion->query($det);

   		if($res){
   			while($row = $res->fetch_array()){
   					  			 
   				$precio = asDollars($row['precio']);
				$desc = $row['descuento'];
				$textoDes = $row['descripcion'];
				$stock = $row['unidades'];
				$UsuarioVendedor = $row['nickname'];
				$valoracion =(100/5)*$row['valoraciones'];
				$cuentaComent = $row['coments'];
				$cuentaVentas = $row['vendidos'];
				$nombreArt = $row['nombreArticulo'];
				$idVendedor = $row['idVendedor'];
			}
			$res->close();
   		}
   		$conexion->close();




	}

?>

<!-- short-info-wrap -->
	<h3 class="title mb-3"><?php echo $nombreArt; ?></h3>

<div class="mb-3"> 
	<var class="price h3 text-warning"> 
		<span class="currency">MXN</span><span class="num"><?php echo $precio; ?></span>
	</var> 
	<span>/pza</span> 
</div> <!-- price-detail-wrap .// -->
<dl>
  <dt>Descrición</dt>
  <dd><p><?php echo $textoDes; ?> </p></dd>
</dl>
<dl class="row">



  <dt class="col-sm-3">Stock</dt>
  <dd class="col-sm-9"><?php echo $stock; ?> </dd>

  <dt class="col-sm-3">Vendedor</dt>
  <dd class="col-sm-9"><?php echo "<a href=\"profile.php?idUsuario=". $idVendedor ."\" class=\"table-link\">". $UsuarioVendedor . "</a>"; ?> </dd>
</dl>
<div class="rating-wrap">

	<ul class="rating-stars">
		<li style="width:<?php echo $valoracion; ?>%" class="stars-active"> 
			<i class="fa fa-star"></i> <i class="fa fa-star"></i> 
			<i class="fa fa-star"></i> <i class="fa fa-star"></i> 
			<i class="fa fa-star"></i> 
		</li>
		<li>
			<i class="fa fa-star"></i> <i class="fa fa-star"></i> 
			<i class="fa fa-star"></i> <i class="fa fa-star"></i> 
			<i class="fa fa-star"></i> 
		</li>
	</ul>
	<div class="label-rating"><?php echo $cuentaComent; ?> Comentarios</div>
	<div class="label-rating"><?php echo $cuentaVentas; ?> Vendidos </div>
</div> <!-- rating-wrap.// -->
<hr>
	<div class="row">
		<div class="col-sm-5">
			<dl class="dlist-inline">
			  <dt>Cantidad: </dt>
			  <dd> 
			  
					<input class="form-control" <?php if(($stock - 1)==0) {echo "disabled";}?> type="number" id="cantidadProducto" name="cantidad" value="1" name="cantidad" min=0 max="<?php echo $stock - 1;?>" >
					<input type="hidden" id="comprador" name="user" value="<?php echo $idComprador; ?>">
					<input type="hidden" id="articulo" name="prod" value="<?php echo $idPdto; ?>">
			  </dd>
			</dl>  <!-- item-property .// -->
		</div> <!-- col.// -->
		<div class="col-sm-7">
			 <?php if(($stock - 1)==0) echo "<p class=\"btn disabled btn-outline-danger\">Producto Agotado</p>";?>
		</div> <!-- col.// -->
	</div> <!-- row.// -->
	<hr>
	<br>
	<br>

<script type="text/javascript">
	function AddCarrito(){
		var cantidad = document.getElementById('cantidadProducto').value;
		var usuario =  document.getElementById('comprador').value;
		var producto =  document.getElementById('articulo').value;

		var parametros = {
			"idUser" : usuario,
			"idProducto" : producto,
			"cantidad" : cantidad,
			"pvariable" : "agregar",
		};


		

		$.ajax({
			data: parametros,
			url: "phpfiles/carrito.php",
			type: "POST",
			beforessend: function(){

			},
			success: function(response){
			
			}		
		});

		console.log(parametros);
	}
</script>

	<?php
		$btn =$stock - 1;

		if($comprar == TRUE &&  $btn>1){
			echo "<button type=\"submit\" class=\"btn  btn-success btn-block\" onclick=\"AddCarrito();\" style=\"float:right;\"> Agregar al carrito </button>";
		}
		else
		{
			echo "<a href=\"\" class=\"btn   btn-block btn-success disabled\" style=\"float:right; cursor: not-allowed;\"> Agregar al carrito </a>";
		}
	?>
	<hr>
	<div id=socialMedia>
		<!--Facebook-->
		<div class="sharethis-inline-share-buttons"></div><script async src="//platform-api.sharethis.com/js/sharethis.js#property=5b9ec43adf87bb0011f9f35d&product="inline-share-buttons"></script>

	</div>
<!-- short-info-wrap .// -->
</article> <!-- card-body.// -->
		</aside> <!-- col.// -->
	</div> <!-- row.// -->
</main> <!-- card.// -->




<div>
	<br>
	<br>
</div>
<!-- PRODUCT DETAIL -->
<div id="description-product">
	<nav>
		  <div class="nav nav-tabs" id="nav-tab" role="tablist">
			    <a class="nav-item nav-link active" id="nav-description-tab-tab" data-toggle="tab" href="#descripcion-producto" role="tab" aria-controls="descripcion-producto" aria-selected="true">Descripci&oacute;n</a>
			    <a class="nav-item nav-link" id="nav-comment-tab-tab" data-toggle="tab" href="#comentarios" role="tab" aria-controls="nav-profile" aria-selected="false">Comentarios</a>
		  </div>
	</nav>
<article class="card mt-3" style="border: none;">
	<div class="tab-content" id="nav-tabContent">
	  <div class="tab-pane fade show active" id="descripcion-producto" role="tabpanel" aria-labelledby="nav-description-tab">
		<div class="card-body" id="description-producto">
			<h4>Descripción del Producto</h4>
			<p>	<?php echo $textoDes; ?></p>
		</div> <!-- card-body.// -->

	  </div> <!-- DESCRIPCION -->


	  <div class="tab-pane fade" id="comentarios" role="tabpanel" aria-labelledby="nav-comment-tab">
			<div class="card-body" id="comentarios-producto">
			<h4>Comentarios</h4>


			<div class="row" id="divComentScroll">
				<div class="col">
			<?php 
		
			 if (isset($_GET['product']) && isset($_SESSION['usuarioId'])) {

    				 require("phpfiles/conexion.php");
    				  $comentar = NULL;
    				 $q = 'CALL spValidarSiComenta('.$_SESSION['usuarioId'].','.$_GET['product'].');';
    				 $res = $conexion->query($q);
    				

   					  if($res){
   					  		while($row = $res->fetch_array()){
   					  			 
   					  		$comentar = $row['com'];
						
						}
							$res->close();
   						 }
   						 
     

						if($comentar == 'OK'){
							echo "<form action=\"productDetail.php?product=".$_GET['product']."\" id=\"comentario\" method=\"POST\">
									<textarea name=\"comentarioAdd\" class=\"form-control\"></textarea><br>
									<input type=\"hidden\" name=\"productoId\" value=\"".$_GET['product']."\">
									<input type=\"hidden\" name=\"usuario\" value=\"".$_SESSION['usuarioId']."\">
									<button type=\"submit\" name=\"AddComentario\" class=\"form-control btn-success\" style=\"float: right; width:120px;\">Comentar</button>
								</form>";
						}
						else{
							echo '<h3> Solamente puede comentar cuando haya realizado una compra del producto </h3>';
						}


						
			 		
						$conexion->close();
			 }else{

				echo '<h3> Solamente puede comentar cuando haya realizado una compra del producto </h3>';

			}

			?>					
				</div>
			</div>
<script>
	function setValue(e){
		var valor = 0;
		var valor = e;
		var idUsuario =0;
		var idProducto =0;


		$.ajax({
			
		});


	}
</script>

			<br>
				

<?php 

 if (isset($_GET['product'])) {
    $idPdto = $_GET['product'];

     require("phpfiles/conexion.php");

     $details = "CALL spVerComentarios('$idPdto');";

     $res = $conexion->query($details);
     if($res){
	while($row = $res->fetch_array()){
            
				
		echo	'<div  class="comentarioP">
						<div class="row">
							<div class="col">';


		echo							'<h6 class="userComment">'. $row['nickname'].  '</h6>
							</div>
							<div class="col-2">';
		echo				'<small class="dateComment">'.$row['fecha'] .'</small>
							</div>
						</div>';

		echo			'<div class="row">
							<div class="col-1">
								<img class="rounded-circle img-ico" src="data:image/png;base64,'.base64_encode($row['avatar']).'" alt="">
							</div>
							<div class="col">
								<p class="textComment"> '. $row['comentario'] .' </p>
				
							</div>
						</div>
				</div><br>';
					



           
	}
	$res->close();
    }
    $conexion->close();
     
  }
  

?>	
			</div>
	  </div> <!-- COMENTARIOS -->
	



	
	
</article> <!-- card.// -->
</div>
<!-- PRODUCT DETAIL .// -->

</div> <!-- col // -->

</div> <!-- row.// -->

				

			

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