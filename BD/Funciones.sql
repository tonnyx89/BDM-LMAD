DELIMITER $$
CREATE FUNCTION fn_EsCarrito
(
	id int
)
RETURNS BOOL
BEGIN
DECLARE carrito BOOL;
DECLARE con INT;
	SELECT COUNT(*) INTO con FROM compra WHERE idUsuario = id AND confirmacion = 0;
    IF con > 0 THEN
		SET carrito = 1;
    ELSE
		SET carrito = 0;
    END IF;
RETURN carrito;
END;
$$



DELIMITER //
CREATE FUNCTION fnPuedeComentar
(
	id int,
    producto int
)
RETURNS BOOLEAN
BEGIN
DECLARE puede BOOLEAN;
DECLARE contar INT;
	SELECT COUNT(*) INTO contar
    FROM compra com
    JOIN detallecompra dc ON com.idCompra = dc.idCompra
    WHERE com.idUsuario = id AND dc.idArticulo = producto
    GROUP BY dc.idArticulo;
    
    IF contar > 0 THEN
		SET puede = true;
	ELSE
		SET puede = false;
	END IF;
RETURN puede;
END;
//




DELIMITER %%
CREATE FUNCTION fnTotalVentasArticulo
(
	id int
)
RETURNS int
BEGIN
DECLARE contador int;
	SELECT SUM(cantidad)  INTO contador
    FROM detallecompra
    WHERE idArticulo = id
    GROUP BY idArticulo;
RETURN contador;
END;
%%


DELIMITER %%
CREATE FUNCTION fnValoracionArticulo
(
	id int
)
RETURNS DOUBLE
BEGIN
	DECLARE prom double;
    SELECT ROUND(AVG(puntuacion),1) INTO prom FROM valoracionarticulo WHERE idArticulo = id;
RETURN prom;
END;
%%

DELIMITER %%
CREATE FUNCTION fnCuentaComentarios
(
	id int
)
RETURNS INT
BEGIN
DECLARE conteo INT;
	SELECT COUNT(*) INTO conteo FROM comentario WHERE idArticulo = id;
RETURN conteo;
END;
%%




delimiter &&
CREATE FUNCTION fnGetIdCompra
(
	idU int,
    fechaC datetime
)
RETURNS INT
BEGIN
	DECLARE idCom INT;
    SELECT idCompra INTO idCom
    FROM compra
    WHERE idUsuario = idU 
    AND fecha = fechaC
    AND confirmacion = 1;
RETURN idCom;
END;
&&



DELIMITER %%
CREATE FUNCTION fn_ValidaUsuario
(
	NickName varchar(30), correo varchar(50)
)
RETURNS boolean

BEGIN
	DECLARE resp boolean;
    DECLARE evalUser tinyint(1);
    
    SELECT COUNT(*) INTO evalUser
    FROM usuario
    WHERE nickname = NickName AND email = correo;
    
    IF evalUser > 0 THEN
		SET resp = true;
    ELSE 
		SET resp = false;
    END IF;
    RETURN resp;
END;
%%


