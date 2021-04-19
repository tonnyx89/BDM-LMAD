DROP DATABASE IF EXISTS if_shop;

CREATE SCHEMA if_shop;

USE if_shop;



CREATE TABLE IF NOT EXISTS usuario
(
	idUsuario int auto_increment not null	primary key,
    nombreUsuario varchar(30) not null,
    apellidoUsuario varchar(30) not null,
    nickname varchar(30) not null unique,
    email varchar(50) not null unique,
    passsword varchar(100) not null,
    telefono long, 
    avatar longblob,
    portada longblob, 
    lastUpdate timestamp, 
    activo bit not null default 1
);

CREATE TABLE IF NOT EXISTS categoria 
(
	idCategoria int auto_increment not null primary key,
    nombreCategoria varchar(30) not null
);


CREATE TABLE IF NOT EXISTS articulo
(
	idArticulo int not null auto_increment primary key,
    nombreArticulo varchar(35) not null,
    descripcion text not null,
    precio double not null,
    unidades int not null,
    idVendedor int not null,
    lastUpdate timestamp, 
    estatus bit not null default 0,
    visitas  bigint unsigned,
    descuento double default 0.0, 
    activo bit not null default 1,
    CONSTRAINT FK_VendedorArticulo FOREIGN KEY (idVendedor)
    REFERENCES usuario(idUsuario)
    
);



CREATE TABLE IF NOT EXISTS imagen
(
	idImagen int not null auto_increment primary key,
    imagen longblob not null,
    tipo varchar(16) not null,
    idArticulo int not null,
    activo bit not null default 1,
    CONSTRAINT FK_ImagenArticulo FOREIGN KEY (idArticulo)
    REFERENCES articulo(idArticulo)
);

CREATE TABLE IF NOT EXISTS video
(
	idVideo int not null auto_increment primary key,
    ruta varchar(200) not null,
    tipo varchar(4) not null,
	idArticulo int not null,
    activo bit not null default 1,
    CONSTRAINT FK_VideoArticulo FOREIGN KEY (idArticulo)
    REFERENCES articulo(idArticulo)
    
);

CREATE TABLE IF NOT EXISTS compra
(
	idCompra int not null auto_increment primary key,
    idUsuario int not null,
    fecha timestamp,
    formaDePago enum ('TC', 'Transferencia','OXXO','Paypal','Debito', 'Deposito') default 'Debito',
    confirmacion bit not null default 0,
    CONSTRAINT FK_usuarioCompra FOREIGN KEY (idUsuario)
    REFERENCES usuario(idUsuario)
);

CREATE TABLE IF NOT EXISTS detalleCompra
(
	idDetail int not null auto_increment primary key,
    idCompra int not null,
    idArticulo int not null,
    cantidad int,
    activo bit not null default 1,
    CONSTRAINT FK_compra FOREIGN KEY (idCompra)
    REFERENCES compra (idCompra),
    CONSTRAINT FK_articuloDetail FOREIGN KEY (idArticulo)
    REFERENCES articulo(idArticulo)
);



CREATE TABLE IF NOT EXISTS articuloCategoria
(
	idArticuloCat int auto_increment not null primary key,
    idCategoria int not null,
    idArticulo int not null,
    lastUpdate timestamp,
    CONSTRAINT FK_Articulo FOREIGN KEY (idArticulo)
    REFERENCES articulo(idArticulo),
	CONSTRAINT FK_Categoria FOREIGN KEY (idCategoria)
    REFERENCES categoria(idCategoria)
);



CREATE TABLE IF NOT EXISTS comentario
(
	idComentario int not null auto_increment primary key,
    fecha timestamp,
    comentario longtext not null,
    idUsuario int not null,
    idArticulo int not null,
    CONSTRAINT FK_UsuarioC FOREIGN KEY (idUsuario)
    REFERENCES usuario(idUsuario),
    CONSTRAINT FK_ArticuloC FOREIGN KEY (idArticulo)
    REFERENCES articulo (idArticulo)
);



CREATE TABLE IF NOT EXISTS valoracionArticulo
(
	idValoracion int not null auto_increment primary key,
    fecha timestamp,
    puntuacion double not null,
    idUsuario int not null,
    idArticulo int not null,
    CONSTRAINT FK_UsuarioV FOREIGN KEY (idUsuario)
    REFERENCES usuario(idUsuario),
    CONSTRAINT FK_ArticuloV FOREIGN KEY (idArticulo)
    REFERENCES articulo (idArticulo)
);