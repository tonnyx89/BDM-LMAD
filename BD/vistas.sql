CREATE VIEW vProductosPorVendedor
AS
SELECT a.idArticulo, a.nombreArticulo, a.precio,a.idVendedor,  i.imagen, i.tipo, i.idImagen, a.estatus
FROM  articulo a 
JOIN imagen i ON a.idArticulo = i.idArticulo
WHERE i.activo = 1
GROUP BY i.idArticulo;




CREATE VIEW vArticulosMasNuevos
AS
SELECT a.idArticulo, a.nombreArticulo, a.precio, im.imagen, im.tipo
FROM articulo a
JOIN imagen im ON a.idArticulo = im.idArticulo
WHERE a.activo = 1 AND estatus = 1 AND im.activo = 1
GROUP BY a.idArticulo
ORDER BY a.lastUpdate ASC
LIMIT 4;


CREATE VIEW vArticulosConDescuento
AS
SELECT a.idArticulo, a.nombreArticulo, a.precio, a.descuento, im.imagen, im.tipo
FROM articulo a
JOIN imagen im ON a.idArticulo = im.idArticulo
WHERE a.activo = 1 AND a.descuento > 0 AND estatus = 1 AND im.activo = 1
GROUP BY a.idArticulo
ORDER BY a.lastUpdate ASC
LIMIT 4;


CREATE VIEW vArticulosMasVisitados
AS
SELECT a.idArticulo, a.nombreArticulo, a.precio, a.descuento, im.imagen, im.tipo
FROM articulo a
JOIN imagen im ON a.idArticulo = im.idArticulo
WHERE a.activo = 1 AND a.estatus = 1 AND a.visitas > 0  AND im.activo = 1
GROUP BY a.idArticulo
ORDER BY a.visitas DESC
LIMIT 4;


CREATE VIEW vArticulosDestacados
AS
SELECT a.idArticulo, a.nombreArticulo, a.precio, a.descuento, im.imagen, im.tipo
FROM articulo a
JOIN imagen im ON a.idArticulo = im.idArticulo
WHERE a.activo = 1 AND a.estatus = 1 AND im.activo = 1
GROUP BY a.idArticulo
ORDER BY RAND() DESC
LIMIT 4;



CREATE VIEW vArticulosMasVendidos
AS
SELECT  ar.idArticulo, ar.nombreArticulo, ar.precio, ar.descuento, im.imagen, im.tipo,SUM(dc.cantidad) vendidos
FROM detallecompra dc
JOIN articulo ar ON dc.idArticulo = ar.idArticulo
JOIN imagen im ON dc.idArticulo = im.idArticulo
JOIN compra c ON dc.idCompra = c.idCompra
WHERE c.confirmacion = 1 AND im.activo = 1
GROUP BY dc.idArticulo
ORDER BY vendidos DESC
LIMIT 4;



CREATE VIEW vComentariosPorArticulo
AS
SELECT com.idComentario, com.fecha, com.comentario, com.idUsuario, com.idArticulo, u.nickname, u.avatar
FROM comentario com
JOIN usuario u ON com.idUsuario = u.idUsuario
ORDER BY com.fecha DESC


