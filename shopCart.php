<?php

$i=0;

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


<script type="text/javascript" charset="utf-8">
	
</script>


</head>
<body onload="subtotal();">
	
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
					
				 <!-- text-wrap.// -->
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
	<main class="col-sm-9">


				<div class="card cart-main"><table id="carritoCompras" class="table table-hover shopping-cart-wrap">
				<thead class="text-muted">
					<tr class="encabezado"><th scope="col">Producto</th>
				  <th scope="col" width="120">Cantidad</th>
				  <th scope="col" width="120">Precio</th>
				  <th scope="col" class="text-right" width="200">Acción</th></tr></thead>
				<tbody>

<?php 

if(isset($_GET['idUsuario'])){
	require("phpfiles/conexion.php");
	$u = $_GET['idUsuario'];
	$p = "CALL spVerCarrito('$u');";
	
	$car = $conexion->query($p);
	$count = $car->num_rows;

	if($count != 0){
		while($row = $car->fetch_array()){

				if($row['descuento'] > 0){
					$dsto = $row['descuento'];
				}else{
					$dsto = "No aplica";
				}
					$i=$i+1;
				echo"<tr id=\"prod".$i."\"><td><figure class=\"media\">
							<div class=\"img-wrap\"><img src=\"data:".$row['tipo'].";base64,". base64_encode($row['imagen']) ."\" class=\"img-thumbnail img-sm\"></div>
							<figcaption class=\"media-body\">
								<h6 class=\"title text-truncate\">".$row['nombreArticulo']."</h6>
								<dl class=\"dlist-inline small\">
								  <dt>Descuento: </dt>
								  <dd id=\"dcto\">" .$dsto ."</dd></dl>
								  <input type=\"hidden\" name=\"desct\" id=\"discount".$i."\" value=\"".$row['descuento']."\">
								<dl class=\"dlist-inline small\">
								  </dl>
								<dl class=\"dlist-inline small\">
								  <dt>Envío: </dt>
								  <dd>Gratuito</dd>
								</dl></figcaption></figure></td>
						<td> <input type=\"hidden\" name=\"idArt\" id=\"idArt".$i."\" value=\"".$row['idArticulo']."\">
							<input  class=\"form-control\" name=\"cantidad\" id=\"prod-cant".$i."\" type=\"number\" min=\"1\" max=\"20\" name=\"cantidad\" onchange=\"updateProducto('idArt".$i."', 'prod-cant".$i."'); subtotal();\" value=\"".$row['cantidad']."\"></td>
							<td> <div class=\"price-wrap\"> 
									<var value=\"".$row['precio'] ."\" class=\"price\">$ ".$row['precio'] ."</var> <input type=\"hidden\" name=\"hprecio\"  id=\"precio".$i."\" value=\"".$row['precio'] ."\">
									<small class=\"text-muted\">(MXN)</small> 
								</div> 
							</td><td class=\"text-right\"> 
							<a data-original-title=\"Save to Wishlist\" title=\"\" href=\"\" class=\"btn btn-outline-success\" data-toggle=\"tooltip\"> 
							<i class=\"fa fa-heart\"></i></a> 
							<button type=\"button\" class=\"btn btn-outline-danger\" onclick=\"vaciarCarrito('idArt".$i."');\"> × Remover</button>
							</td></tr>";

							
		}
		$conexion->close();
	}
	else
	{
		echo "<tr><td colspan=\"4\"> <center> No hay productos para mostrar </center></td><tr>";
	}

	
}else{
	echo "<tr><td colspan=\"4\"> <center> No hay productos para mostrar </center></td><tr>";
}
			
?>
				</tbody></table></div> <!-- card.// -->





	</main> <!-- col.// -->
	<aside class="col-sm-3 cart-main">
<p class="alert alert-success">Todos los envíos nacionales son gratuitos. Para envíos internacionales contacta a Servicio a Cliente. </p>
<dl class="dlist-align">
  <dt>Subtotal: </dt>
  <dd id="subtotal" class="text-right">$ &nbsp;</dd>
</dl>
<dl class="dlist-align">
  <dt>Descuento:</dt>
  <dd id="descuento" class="text-right">$ &nbsp;</dd>
</dl>
<dl class="dlist-align">
  <dt>IVA:</dt>
  <dd id="IVA" class="text-right">$ &nbsp;</dd>
</dl>
<dl class="dlist-align h5">
  <dt>Total:</dt>
  <dd class="text-right"><strong>$ &nbsp;</strong><strong id="total-carrito"></strong></dd>
</dl>
<hr>

<div class="row">
	<figure class="mb-3 col">
			<div class="text-wrap small text-muted">
				Elija el método de pago:
			</div>
			<br>
			<select class="form-control" name="pay-method" id="metodoPago" style="width:100%;">
				<option value="0">Seleccione</option>
				<option value="1">Crédito</option>
				<option value="5">Débito</option>
				<option value="3">OXXO</option>
				<option value="4">Paypal</option>
				<option value="2">Transferencia</option>
				<option value="6">Deposito Bancario</option>
			</select>
	</figure>
	<br>
	<br>
</div>

<figure class="itemside mb-3">
	<aside class="aside"><img src="images/icons/pay-visa.png"></aside>
	 <div class="text-wrap small text-muted">
Paga a 12 MSI <br>
Solo bancos participantes 
	 </div>
</figure>
<figure class="itemside mb-3">
	<aside class="aside"> <img src="images/icons/pay-mastercard.png"> </aside>
	 <div class="text-wrap small text-muted">
Recibe 10% de bonificación pagando con MasterCard <br>
 
	 </div>
</figure>
<hr>

<div class="row">
	<figure class="itemside mb-3 col">
		<input type="hidden" name="user" id="usId" value="<?php echo $_GET['idUsuario'];?>">
		<button type="submit" class="btn btn-primary btn-block" value="confirmar" onclick="confirmarCompra();">Confirmar Pedido</button>
	</figure>
	<figure class="itemside mb-3 col">
		<button type="button" class="btn btn-danger btn-block" onclick="vaciarCarrito();">Vaciar Carrto</button>
	</figure>
</div>

	</aside> <!-- col.// -->
</div>		

<script type="text/javascript">
	function confirmarCompra(){
		
		var usuario =  document.getElementById('usId').value;
		var pago =  document.getElementById('metodoPago').value;
		
		if(pago > 0)
		{
		var parametros = {
			"idUser" : usuario,
			"pago" : pago,
			"pconfirma" : "confirmar",
		};

		var result = confirm('¿Desea realizar su compra?');
			if(result == true){
				$.ajax({
					data: parametros,
					url: "phpfiles/carrito.php",
					type: "POST",
					beforessend: function(){
						alert('Su compra será procesada. Esta acción no se puede deshacer.');
					},
					success: function(response){
						
							
							location.reload(); 
						
						
					}		
				});
			}
		}
		else
		{
			alert('Seleccione un método de pago.');
		}
	}


	function updateProducto(pro, cant){
		var prod = document.getElementById(pro).value;
		var cant = document.getElementById(cant).value;
		var usuario =  document.getElementById('usId').value;


		var parametros = {
			"idUser" : usuario,
			"cantidad" : cant,
			"idProducto" : prod,
			"pvariable" : "update",
		};

		$.ajax({
			data: parametros,
			url: "phpfiles/carrito.php",
			type: "POST",
			beforessend: function(){
				
			},
			success: function(response){
				location.reload();
			}		
		});
	}



	function vaciarCarrito(prod){
		var prod = document.getElementById(prod).value;
		var usuario =  document.getElementById('usId').value;

		var confr = confirm('¿Desea eliminar el articulo de su carrito de compra?');

		if(confr==true){
			var parametros = {
				"idUser" : usuario,
				"idProducto" : prod,
				"pvariable" : "eliminar",
			};

			$.ajax({
				data: parametros,
				url: "phpfiles/carrito.php",
				type: "POST",
				beforessend: function(){
					
				},
				success: function(response){
					location.reload();
				}		
			});
		}
	}


	function vaciarCarrito(){
		var usuario =  document.getElementById('usId').value;
		var confr = confirm('¿Desea vaciar TODO el contenido de su carrito de compra?');

		if(confr==true){
			var parametros = {
				"idUser" : usuario,
				"pvariable" : "vaciar",
			};

			$.ajax({
				data: parametros,
				url: "phpfiles/carrito.php",
				type: "POST",
				beforessend: function(){
					
				},
				success: function(response){
					location.reload();
				}		
			});
		}
	}


</script>


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

function subtotal(){	
	var campos = <?php echo $i; ?>;

	var Subtotal=0;
	var multiP=0;
	var multiC=0;
	var descuento=0;
	var sumDcto =0;
	var iva = 0;
	var total = 0;

	for(i=1; i <= campos; i++){
	
		multiP = parseFloat(document.getElementById("precio" + i).value);
		multiC = parseFloat(document.getElementById("prod-cant"+ i).value);
		descuento = parseFloat(document.getElementById("discount"+ i).value);
		Subtotal+=(multiP*multiC);
		sumDcto+=((descuento/100)*multiP)*multiC;

	}

	document.getElementById("subtotal").innerHTML ="$  " + Subtotal.toFixed(2);
	document.getElementById("descuento").innerHTML ="$  " + sumDcto.toFixed(2);
	iva = Subtotal * 0.16;	
	document.getElementById("IVA").innerHTML ="$  " + iva.toFixed(2);

	total =  (Subtotal-sumDcto)+ iva;

	document.getElementById("total-carrito").innerHTML = total.toFixed(2);
}



</script>


</body>
</html>