use if_shop;

delimiter //
CREATE PROCEDURE spLoginUser
(
	usuario varchar(60),
    contra varchar(100)
)
BEGIN
	
	
    SELECT idUsuario, nickname, email, passsword, telefono
    FROM usuario
    WHERE passsword = md5(contra) AND (nickname = usuario OR email = usuario OR telefono = usuario);
    
    
END;

delimiter //
CREATE PROCEDURE sp_NuevoUsuario
(
    nombreU varchar(30),
    apellidoU varchar(30),
    nicknameU varchar(30),
    emailU varchar(50),
    passswordU varchar(100),
    telefonoU long, 
    avatarU longblob,
    portadaU longblob
)
BEGIN
	DECLARE uExists bool;
    DECLARE pass varchar(100);
    SELECT fn_ValidaUsuario(nicknameU,emailU ) INTO uExists;
    
    IF uExists = 0 THEN

		INSERT INTO usuario (nombreUsuario, apellidoUsuario, nickname, email, passsword, telefono, avatar, portada) VALUES (nombreU, apellidoU, nicknameU, emailU, md5(passswordU), telefonoU, avatarU, portadaU);
        SELECT 'ok' registro;
	ELSE
  	SELECT 'no' registro;
    END IF;
	
END;
//


delimiter %%
CREATE PROCEDURE spGetProfileImages	
(
	usuario int
)
BEGIN
	SELECT avatar, portada FROM usuario WHERE idUsuario = usuario;
END;
%%

delimiter ;




-- CALL USER DATA


delimiter %%
CREATE PROCEDURE spDatosVendedor
(
	id int
)
BEGIN
	SELECT CONCAT(nombreUsuario, ' ' , apellidoUsuario) nombre, nickname, email, IFNULL(telefono,'No disponible') tel, avatar, portada
    FROM usuario
    WHERE idUsuario = id;
END;
%%





-- ---- PRODUCTOS EN VENTA 
DELIMITER //
CREATE PROCEDURE spArticulosEnVenta
(
	id int

)
BEGIN
	SELECT idArticulo, nombreArticulo, precio, idVendedor, imagen, tipo, idImagen
    FROM vProductosPorVendedor
    WHERE idVendedor = id AND estatus = 1;

END;
//

-- ---------- PRODUCTOS EN BORRADOR
DELIMITER //
CREATE PROCEDURE spArticulosBorrador
(
	id int

)
BEGIN
	SELECT idArticulo, nombreArticulo, precio, idVendedor, imagen, tipo, idImagen
    FROM vProductosPorVendedor
    WHERE idVendedor = id AND estatus = 0;

END;
//



DELIMITER //
CREATE PROCEDURE spVerDetallesCompra
(
	id int
)
BEGIN
	SELECT dc.cantidad, a.nombreArticulo, ((a.precio-(a.precio*(a.descuento/100)))* dc.cantidad) costo, c.fecha
    FROM detallecompra dc
    JOIN compra c ON dc.idCompra = c.idCompra
    JOIN articulo a ON dc.idArticulo = a.idArticulo
    WHERE c.idCompra = id;
END;
//

call spVerDetallesCompra(2);
-- ----------------- CARRITO




DELIMITER %%
CREATE PROCEDURE spVerCarrito
(
	usuario int
)
BEGIN
	SELECT DISTINCT a.idArticulo, a.nombreArticulo, a.descuento, a.precio, dc.cantidad, im.imagen, im.tipo
    FROM articulo a
    JOIN detallecompra dc ON a.idArticulo = dc.idArticulo
    JOIN compra c ON dc.idCompra = c.idCompra
    JOIN imagen im ON a.idArticulo = im.idArticulo
    WHERE c.confirmacion = 0 AND c.idUsuario = usuario
    GROUP BY a.idArticulo;
END;
%%









DELIMITER //
CREATE PROCEDURE spPaginaPrincipal
(
	opc tinyint
)
BEGIN
	CASE opc
		WHEN 1 THEN
			SELECT DISTINCT idArticulo, nombreArticulo, precio, imagen, tipo FROM vArticulosMasNuevos;
        WHEN 2 THEN
			SELECT DISTINCT idArticulo, nombreArticulo, precio, descuento, imagen, tipo FROM vArticulosConDescuento;
        WHEN 3 THEN
			SELECT DISTINCT idArticulo, nombreArticulo, precio, descuento, imagen, tipo FROM vArticulosMasVisitados;
        WHEN 4 THEN
			SELECT DISTINCT idArticulo, nombreArticulo, precio, descuento, imagen, tipo FROM vArticulosDestacados;
        ELSE
			SELECT DISTINCT idArticulo, nombreArticulo, precio, descuento, imagen, tipo, vendidos FROM vArticulosMasVendidos;
	END CASE;
END;
//
 


DELIMITER //
CREATE PROCEDURE spBusquedaMixta
(
	vendedor varchar(30),
    nombre varchar(50),
    descripcion varchar(100),
    catId int,
    fechaInicio date,
    fechaFin date,
    tipoB int
)
BEGIN
	CASE tipoB
		WHEN 1 THEN
				SELECT a.idArticulo, a.nombreArticulo, a.precio, im.imagen, im.tipo
				FROM articulo a
                JOIN usuario us ON a.idVendedor = us.idUsuario
				JOIN imagen im ON a.idArticulo = im.idArticulo
				WHERE a.activo = 1 AND a.estatus = 1 AND im.activo = 1
                AND us.nickname LIKE CONCAT('%', vendedor ,'%')
                GROUP BY a.idArticulo
				ORDER BY a.idVendedor ASC;
                
        WHEN 2 THEN
				SELECT a.idArticulo, a.nombreArticulo, a.precio, im.imagen, im.tipo
				FROM articulo a
				JOIN imagen im ON a.idArticulo = im.idArticulo
				WHERE a.activo = 1 AND a.estatus = 1 AND im.activo = 1
                AND a.nombreArticulo LIKE CONCAT('%', nombre ,'%')
                GROUP BY a.idArticulo
				ORDER BY a.idVendedor ASC;
                
        WHEN 3 THEN
				SELECT a.idArticulo, a.nombreArticulo, a.precio, im.imagen, im.tipo
				FROM articulo a
				JOIN imagen im ON a.idArticulo = im.idArticulo
				WHERE a.activo = 1 AND a.estatus = 1 
                AND im.activo = 1
                AND a.descripcion LIKE CONCAT('%', descripcion ,'%')
                GROUP BY a.idArticulo
				ORDER BY a.idVendedor ASC;
                
        WHEN 4 THEN
				SELECT a.idArticulo, a.nombreArticulo, a.precio, im.imagen, im.tipo
				FROM articulo a
				JOIN imagen im ON a.idArticulo = im.idArticulo 
				WHERE a.activo = 1 AND a.estatus = 1 
                AND im.activo = 1
                AND a.lastUpdate BETWEEN CONCAT(fechaInicio,' ','00:00:00') AND CONCAT(fechaFin,' ','23:59:59') 
                GROUP BY a.idArticulo
				ORDER BY a.lastUpdate DESC;
                
        WHEN 5 THEN
				SELECT a.idArticulo, a.nombreArticulo, a.precio, im.imagen, im.tipo
				FROM articulo a
                JOIN usuario us ON a.idVendedor = us.idUsuario
				JOIN imagen im ON a.idArticulo = im.idArticulo
				WHERE a.activo = 1 
                AND a.estatus = 1 
                AND im.activo = 1
                AND (us.nickname LIKE CONCAT('%', vendedor ,'%') OR a.nombreArticulo LIKE CONCAT('%', nombre ,'%') OR a.descripcion LIKE CONCAT('%', descripcion ,'%') )
                AND a.lastUpdate BETWEEN CONCAT(fechaInicio,' ','00:00:01') AND CONCAT(fechaFin,' ','23:59:59')
                GROUP BY a.idArticulo
				ORDER BY a.lastUpdate DESC;
		ELSE
                SELECT DISTINCT a.idArticulo, a.nombreArticulo, a.precio, im.imagen, im.tipo
				FROM articulo a
                JOIN articulocategoria ac ON a.idArticulo = ac.idArticulo
				JOIN categoria cat ON ac.idCategoria = cat.idCategoria
                JOIN imagen im ON a.idArticulo = im.idArticulo
				WHERE a.activo = 1 AND a.estatus = 1  AND im.activo = 1 AND ac.idCategoria = catId
                GROUP BY a.idArticulo
                ORDER BY a.lastUpdate DESC;
				
        
	END CASE;
END;
//


                





-- ------------- HISTORIAL DE COMPRAS ----------------------
DELIMITER %%
CREATE PROCEDURE spHistorialCompras
(
	idU int
)
BEGIN
	SELECT co.idCompra, DATE(co.fecha) fechaC ,SUM(((art.precio - (art.precio*(art.descuento/100))) * dc.cantidad)*1.16) costo
    FROM compra co
    JOIN detallecompra dc ON co.idCompra = dc.idCompra
    JOIN articulo art ON dc.idArticulo = art.idArticulo
    WHERE co.confirmacion=1 AND co.idUsuario = idU
	GROUP BY dc.idCompra
    ORDER BY co.fecha DESC;

END;
%%


-- -------------------- FUNCION VALIDAR SI COMENTA O NO



-- --------- VALIDAR COMENTARIO --------------
DELIMITER $$
CREATE PROCEDURE spValidarSiComenta
(
	idUser int,
    idProduct int
)
BEGIN
	
   	DECLARE comentar BOOLEAN;
    SELECT fnPuedeComentar(idUser, idProduct) INTO comentar;
    IF comentar > 0 THEN
		SELECT 'OK' com;
    ELSE
		SELECT 'NO' com;
    END IF;
END;
$$



-- --------- COMENTAR PRODUCTO -------------------
DELIMITER $$
CREATE PROCEDURE spComentarProducto
(
	idUser int,
    idProduct int,
    texto longtext
)
BEGIN
	DECLARE comentar BOOLEAN;
    SELECT fnPuedeComentar(idUser, idProduct) INTO comentar;
    IF comentar = 1 THEN
		INSERT comentario(comentario, idUsuario, idArticulo)
        VALUES (texto, idUser, idProduct);
    END IF;
END;
$$


--  ----- COMENTARIOS POR PRODUCTO ----------------
CREATE VIEW vComentariosPorArticulo
AS
SELECT com.idComentario, com.fecha, com.comentario, com.idUsuario, com.idArticulo, u.nickname, u.avatar
FROM comentario com
JOIN usuario u ON com.idUsuario = u.idUsuario
ORDER BY com.fecha DESC




-- ------------ VER COMENTARIO --------
DELIMITER &&
CREATE PROCEDURE spVerComentarios
(
	idPdt int
)
BEGIN
	SELECT idComentario, fecha, comentario, idUsuario, idArticulo, nickname, avatar
    FROM vComentariosPorArticulo
    WHERE idArticulo = idPdt;
END;
&&


-- ------------ PUBLICAR UN PRODUCTO
DELIMITER &&
CREATE PROCEDURE spPublicarProducto
(
	idP int
)
BEGIN

			UPDATE articulo SET estatus = 1 WHERE idArticulo = idP;

END;
&&



-- ----------- VER DETALLES DE PRODUCTO ---------
DELIMITER $$
CREATE PROCEDURE spVerDetallesArticulo
(
	producto int
)
BEGIN
    BEGIN
		SELECT ar.idArticulo, ar.nombreArticulo, ar.descripcion, ar.precio, ar.unidades, ar.descuento,ar.idVendedor, ven.nickname, fnTotalVentasArticulo(producto) vendidos, fnValoracionArticulo(producto) valoraciones, fnCuentaComentarios(producto) coments
		FROM articulo ar
		JOIN usuario ven ON ar.idVendedor = ven.idUsuario
		WHERE ar.estatus = 1 AND ar.idArticulo = producto;
    END;
    BEGIN
		UPDATE articulo SET visitas = visitas + 1 where idArticulo = producto;
    END;
END;
$$





DELIMITER $$
CREATE PROCEDURE spFormDetallesArticulo
(
	producto int
)
BEGIN

		SELECT ar.idArticulo, ar.nombreArticulo, ar.descripcion, ar.precio, ar.unidades, ar.descuento,ar.idVendedor, ven.nickname
		FROM articulo ar
		JOIN usuario ven ON ar.idVendedor = ven.idUsuario
		WHERE ar.idArticulo = producto;

END;
$$


DELIMITER $$
CREATE PROCEDURE spCateogiasArticulo
(
	producto int
)
BEGIN

		SELECT idCategoria FROM articulocategoria WHERE idArticulo = producto;
END;
$$




DELIMITER //
CREATE PROCEDURE spGetImagenesProducto
(
	id int
)
BEGIN
	SELECT idImagen,imagen, tipo 
    FROM imagen 
    WHERE idArticulo = id and activo = 1
    ORDER BY idImagen ASC;
END;
//



DELIMITER //
CREATE PROCEDURE spGetSimpleImage
(
	id int
)
BEGIN
	SELECT idImagen,imagen, tipo 
    FROM imagen 
   WHERE idArticulo = id and activo = 1
   LIMIT 1;
 
END;
//



DELIMITER //
CREATE PROCEDURE spGetVideosProducto
(
	id int
)
BEGIN
	SELECT idVideo,ruta, tipo 
    FROM video 
    WHERE idArticulo = id and activo = 1
    ORDER BY idVideo ASC;
END;
//








DELIMITER //
CREATE PROCEDURE spGetImagenesCarrusel()
BEGIN
	SELECT idImagen,imagen, tipo 
    FROM imagen 
    WHERE activo = 0
    ORDER BY RAND()
    LIMIT 5;
END;
//




DELIMITER &&
CREATE PROCEDURE spVerCategorias()
BEGIN
	SELECT c.idCategoria, c.nombreCategoria, COUNT(ac.idArticuloCat) cantidad
	FROM categoria c 
	LEFT JOIN articulocategoria ac ON c.idCategoria = ac.idCategoria
	JOIN articulo a ON ac.idArticulo = a.idArticulo
	WHERE a.estatus = 1
	GROUP BY c.idCategoria
	UNION
	SELECT c.idCategoria, c.nombreCategoria, 0
	FROM categoria c;
END;
&&


DELIMITER &&
CREATE PROCEDURE spCampoCategoria()
BEGIN
	SELECT ct.idCategoria, ct.nombreCategoria
    FROM categoria ct;
END;
&&







-- ------------- PRODUCTOS EN BORRADOR ----------------
DELIMITER $$
CREATE PROCEDURE spVerBorradorArticulo
(
	producto int
)
BEGIN
	SELECT ar.idArticulo, ar.nombreArticulo, ar.descripcion, ar.precio, ar.unidades, ar.descuento, img.imagen, img.tipo, ven.nickname
    FROM articulo ar
    JOIN imagen img ON ar.idArticulo = img.idArticulo
    JOIN usuario ven ON ar.idVendedor = ven.idUsuario
    WHERE ar.estatus = 0 AND ar.idArticulo = producto;
END;
$$


-- ----- BORRADORES DE PRODUCTO -------



-- --------- ACTUALIZAR IMAGENES DE USUARIO ----------
DELIMITER &&
CREATE PROCEDURE spNuevasImagenes
(
	avtr longblob,
    portd longblob,
    id int
)
BEGIN
	UPDATE usuario SET avatar = avtr, portada = portd WHERE idUsuario = id;
END;
&&



-- --------- ACTUALIZAR DATOS DE USUARIO ----------
DELIMITER &&
CREATE PROCEDURE spActualizarDatos
(
    id int,
    nombre varchar(30),
    apell varchar(30),
    nick varchar(30),
    tel varchar(10),
    correo varchar(50)
)
BEGIN
	UPDATE usuario SET nombreUsuario = nombre, apellidoUsuario = apell, nickname = nick, telefono = tel, email = correo WHERE idUsuario = id;
END;
&&



-- --------- ACTUALIZAR CONTRASEÑA ----------
DELIMITER &&
CREATE PROCEDURE spCambiarPassword
(
    id int,
    contra varchar(100)
)
BEGIN
	UPDATE usuario SET passsword = MD5(contra) WHERE idUsuario = id;
    
END;
&&





DELIMITER //
CREATE PROCEDURE spNuevoArticulo
(
	nombre varchar(35),
    descripcion text,
    precio decimal(5,2),
    unidades int,
    vendedor int,
    descuento double
)
BEGIN
	INSERT articulo (nombreArticulo, descripcion, precio, unidades, idVendedor, descuento, estatus) 
    VALUES (nombre, descripcion, precio, unidades, vendedor, descuento, 0);
    
    SELECT last_insert_id() idp;
    
END;
//





DELIMITER //
CREATE PROCEDURE spActualizaArticulo
(
	nombre varchar(35),
    descripcion text,
    precio decimal(5,2),
    unidades int,
    descuento double,
    id int
)
BEGIN
	UPDATE articulo SET nombreArticulo=nombre, descripcion = descripcion, precio = precio, unidades = unidades, descuento = descuento WHERE idArticulo = id;    
END;
//




DELIMITER //
CREATE PROCEDURE spCategoriasNuevoArticulo
(
 idCat int,
 idProd int
)
BEGIN
	INSERT articulocategoria (idCategoria, idArticulo) VALUES (idCat,idProd);
END;
//


DELIMITER //
CREATE PROCEDURE spImagenesNuevoArticulo
(
	idArt int,
    img longblob,
    t varchar(10)
)
BEGIN
	INSERT imagen (imagen, tipo, idArticulo, activo) VALUES (img, t, idArt,1);
END;
//


DELIMITER //
CREATE PROCEDURE spVideosNuevoArticulo
(
	path varchar(200),
    tp varchar(4),
    idA int
)
BEGIN
	INSERT video (ruta, tipo, idArticulo) VALUES(path, tp, idA);
END;
//




DELIMITER %%
CREATE PROCEDURE spAddAlCarrito
(
	producto int,
    cant int,
    usuario int
)
BEGIN
	DECLARE carrito BOOL;
    DECLARE upCant INT;
    DECLARE idC INT;
    
    SELECT fn_EsCarrito(usuario) INTO carrito;
    
    IF carrito = 1 THEN
		SELECT idCompra INTO idC 
        FROM compra 
        WHERE idUsuario = usuario AND confirmacion = 0;
        
		SELECT SUM(cantidad) INTO upCant 
        FROM detallecompra dc 
        JOIN compra c ON dc.idCompra = c.idCompra 
        WHERE c.idUsuario = usuario AND dc.idArticulo = producto AND c.confirmacion = 0;

			IF upCant > 0 OR upCant IS NOT NULL THEN
				UPDATE detallecompra SET cantidad = cantidad + cant WHERE idCompra = idC AND idArticulo = producto;
            ELSE
				INSERT detallecompra (idCompra, idArticulo, cantidad, activo) VALUES (idC, producto, cant,1);
			END IF;
    ELSE
		INSERT compra (idUsuario, confirmacion) VALUES(usuario, 0);
        SET idC = last_insert_id();
        INSERT detallecompra (idCompra, idArticulo, cantidad, activo) VALUES (idC, producto, cant,1);
    END IF;
END;
%%



DELIMITER $$
CREATE PROCEDURE spActualizarUnidadesCarrito
(
	usuario int,
    producto int,
    cantidad int
)
BEGIN
	UPDATE detallecompra dc
    JOIN compra c ON dc.idCompra = c.idCompra
    SET cantidad = cantidad
    WHERE c.confirmacion = 0 AND c.idUsuario = usuario AND dc.idArticulo = producto;
   
END;
$$



DELIMITER !!
CREATE PROCEDURE spConfirmarCompra
(
	usuario int,
    pago int
)
BEGIN
	DECLARE metodo VARCHAR(16);
    
    CASE pago
		WHEN 1 THEN SET metodo = 'TC';
        WHEN 2 THEN SET metodo = 'Transferencia';
        WHEN 3 THEN SET metodo = 'OXXO';
        WHEN 4 THEN SET metodo = 'Paypal';
        WHEN 5 THEN SET metodo = 'Debito';
        WHEN 6 THEN SET metodo = 'Deposito';
	END CASE;
    
	UPDATE compra SET formaDePago = metodo, fecha=NOW(),confirmacion = 1 WHERE idUsuario = usuario AND confirmacion = 0;
	
END;
!!



DELIMITER &&
CREATE PROCEDURE spEliminarCompraCarrito
(
	idU int,
    fecha datetime
)
BEGIN
	DECLARE carrito BOOL;
    DECLARE idC INT;
    
    SELECT fn_EsCarrito(idU) INTO carrito;
    
    IF carrito = 1 THEN
		SELECT idCompra INTO idC 
        FROM compra 
        WHERE idUsuario = idU AND confirmacion = 0;
        
        DELETE FROM compra WHERE idCompra =idC AND idUsuario = idU;
    ELSE 
		SELECT fnGetIdCompra(idU, fecha) INTO idC;
		DELETE FROM compra WHERE idCompra =idC AND idUsuario = idU;
    END IF;
END;
&&





DELIMITER %%
CREATE PROCEDURE spElimiarArticuloCarrito
(
	idU int,
    articulo int
)
BEGIN
		DECLARE carrito BOOL;
    DECLARE idC INT;
    
    SELECT fn_EsCarrito(idU) INTO carrito;
    
    IF carrito = 1 THEN
		SELECT idCompra INTO idC 
        FROM compra 
        WHERE idUsuario = idU AND confirmacion = 0;
        
        DELETE FROM detallecompra WHERE idCompra =idC AND idArticulo = articulo;

    END IF;
END;
%%


DELIMITER %%
CREATE PROCEDURE spVaciarCarrito
(
	idU int
)
BEGIN
	DECLARE carrito BOOL;
    DECLARE idC INT;
    
    SELECT fn_EsCarrito(idU) INTO carrito;
    
    IF carrito = 1 THEN
		SELECT idCompra INTO idC 
        FROM compra 
        WHERE idUsuario = idU AND confirmacion = 0;
        
        
        DELETE FROM detallecompra WHERE idCompra =idC;
        DELETE FROM compra WHERE idCompra = idC;

    END IF;
END;
%%






DELIMITER $$
CREATE PROCEDURE spEliminarArticulo
(
	id int
)
BEGIN
	DELETE FROM articulo WHERE idArticulo = id;
END;
$$

show triggers;


DELIMITER //
CREATE PROCEDURE spEliminarCuentaPermanente
(
	usuario int
)
BEGIN
	DELETE FROM usuario WHERE idUsuario = usuario;
END;
//

DELIMITER //
CREATE PROCEDURE spDesactivarCuenta
(
	usuario int
)
BEGIN
	UPDATE usuario SET activo = 0 WHERE idUsuario = usuario;
END;
//


DELIMITER &&
CREATE PROCEDURE spValorarProducto
(
	idU int,
    idProd int,
    puntos double
)
BEGIN
	DECLARE val INT;
    DECLARE puede BOOL;
    
    SELECT fnPuedeComentar(idU, idProd) INTO puede;
    
    IF puede = 1 THEN
		SELECT COUNT(*) INTO val FROM valoracionarticulo WHERE idUsuario = idU AND idArticulo = idProd;
		
		IF val > 0 THEN
			UPDATE valoracionarticulo SET puntuacion = puntos WHERE idUsuario = idU AND idArticulo = idProd;
		ELSE
			INSERT valoracionarticulo(idUsuario, idArticulo, puntuacion) VALUES(idU, idProd, puntos);
		END IF;
    END IF;
END;
&&



