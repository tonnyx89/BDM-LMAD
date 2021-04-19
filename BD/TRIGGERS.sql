

delimiter //
CREATE TRIGGER trBienvenida AFTER INSERT ON articulo FOR EACH ROW
BEGIN
	DECLARE comentario longtext;
    SET comentario = 'ESTIMADO USUARIO: Este producto solamente podrá ser comentaro y/o valorado por usuarios que hayan realizado una compra del mismo, por seguridad y para evitar SPAM. Agradecemos su preferencia por usar nuestra plataforma.';
	INSERT comentario (idUsuario, idArticulo, comentario)
    VALUES (1, new.idArticulo, comentario);
END;
//




DELIMITER %%
CREATE TRIGGER trRestarUnidades
AFTER UPDATE ON compra FOR EACH ROW
BEGIN   
	IF new.confirmacion = 1 THEN
		UPDATE  articulo a
		JOIN detallecompra dc ON a.idArticulo = dc.idArticulo
		JOIN compra c ON dc.idCompra = c.idCompra
		SET unidades = unidades - cantidad
		WHERE c.idCompra = new.idCompra;	
    END IF;
END;
%%




DELIMITER %%
CREATE TRIGGER trEliminarCompraProductos
BEFORE DELETE ON compra FOR EACH ROW
BEGIN
	DELETE FROM detallecompra WHERE idCompra = old.idCompra;
END;
%%



DELIMITER %%
CREATE TRIGGER trEliminarMultimediaArticulo
BEFORE DELETE ON articulo FOR EACH ROW
BEGIN
	DELETE FROM imagen WHERE idArticulo = old.idArticulo;
    DELETE FROM video WHERE idArticulo = old.idArticulo;
    DELETE FROM comentario WHERE idArticulo = old.idArticulo;
    DELETE FROM valoracionarticulo WHERE idArticulo = old.idArticulo;
    DELETE FROM articulocategoria WHERE idArticulo = old.idArticulo;
    DELETE FROM detallecompra WHERE idArticulo = old.idArticulo;
END;
%%



