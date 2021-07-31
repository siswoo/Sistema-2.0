DROP DATABASE IF EXISTS sistemav2;
CREATE DATABASE sistemav2;
USE sistemav2;

DROP TABLE IF EXISTS roles;
CREATE TABLE roles (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	estatus INT NOT NULL,
	inicio INT NOT NULL,
	responsable INT NOT NULL,
	id_empresa INT NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE roles CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO roles (nombre,estatus,inicio,responsable,id_empresa,fecha_creacion) VALUES 
('admin',1,1,1,1,'2021-04-18'),
('modelos',1,1,1,1,'2021-04-18');

DROP TABLE IF EXISTS modulos;
CREATE TABLE modulos (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	estatus INT NOT NULL,
	responsable INT NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE modulos CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO modulos (nombre,estatus,responsable,fecha_creacion) VALUES 
('admin',1,1,'2021-04-18'),
('pasantes',1,1,'2021-04-18'),
('modelos',1,1,'2021-04-18'),
('paginas',1,1,'2021-04-18'),
('presabanas',1,1,'2021-04-18');

DROP TABLE IF EXISTS funciones;
CREATE TABLE funciones (
	id INT AUTO_INCREMENT,
	ver INT NOT NULL,
	crear INT NOT NULL,
	modificar INT NOT NULL,
	eliminar INT NOT NULL,
	responsable INT NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE funciones CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS documento_tipo;
CREATE TABLE documento_tipo (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE documento_tipo CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO documento_tipo (nombre) VALUES 
('Cedula de Ciudadania'),
('Cedula de Extranjeria'),
('Pasaporte'),
('PEP');

DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
	id INT AUTO_INCREMENT,
	nombre1 VARCHAR(250) NOT NULL,
	nombre2 VARCHAR(250) NOT NULL,
	apellido1 VARCHAR(250) NOT NULL,
	apellido2 VARCHAR(250) NOT NULL,
	documento_tipo INT NOT NULL,
	documento_numero VARCHAR(250) NOT NULL,
	correo_personal VARCHAR(250) NOT NULL,
	correo_empresa VARCHAR(250) NOT NULL,
	clave VARCHAR(250) NOT NULL,
	telefono VARCHAR(250) NOT NULL,
	rol INT NOT NULL,
	estatus_modelo INT DEFAULT 0, 
	estatus_nomina INT DEFAULT 0, 
	estatus_satelite INT DEFAULT 0, 
	estatus_pasantia INT DEFAULT 0, 
	estatus_empresa INT DEFAULT 0, 
	estatus_pasantes INT DEFAULT 0, 
	genero INT NOT NULL,
	direccion VARCHAR(250) NOT NULL,
	responsable INT NOT NULL,
	id_empresa INT NOT NULL,
	id_pais INT NOT NULL,
	fecha_modificacion date NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE usuarios CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO usuarios (nombre1,nombre2,apellido1,apellido2,documento_tipo,documento_numero,correo_personal,correo_empresa,clave,telefono,rol,estatus_modelo,estatus_nomina,estatus_satelite,estatus_pasantia,estatus_empresa,estatus_pasantes,genero,direccion,responsable,id_empresa,id_pais,fecha_modificacion,fecha_creacion) VALUES
('Juan','Jose','Maldonado','La Cruz',1,'955948708101993','juanmaldonado.co@gmail.com','programador@camaleonmg.com','e1f2e2d4f6598c43c2a45d2bd3acb7be','3016984868',1,1,1,0,1,1,1,1,'Barrio Olarte',1,1,5,'','2021-04-18');

DROP TABLE IF EXISTS roles_funciones;
CREATE TABLE roles_funciones (
	id INT AUTO_INCREMENT,
	id_roles INT NOT NULL,
	id_funciones INT NOT NULL,
	ver INT NOT NULL,
	crear INT NOT NULL,
	modificar INT NOT NULL,
	eliminar INT NOT NULL,
	responsable INT NOT NULL,
	id_empresa INT NOT NULL,
	fecha_modificacion date NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE roles_funciones CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS funciones_usuarios;
CREATE TABLE funciones_usuarios (
	id INT AUTO_INCREMENT,
	id_usuarios INT NOT NULL,
	id_modulos INT NOT NULL,
	id_usuario_rol VARCHAR(250) NOT NULL,
	crear INT NOT NULL,
	modificar INT NOT NULL,
	eliminar INT NOT NULL,
	responsable INT NOT NULL,
	id_empresa INT NOT NULL,
	fecha_modificacion date NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE funciones_usuarios CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO funciones_usuarios (id_usuarios,id_modulos,id_usuario_rol,crear,modificar,eliminar,responsable,id_empresa,fecha_creacion) VALUES 
(1,2,'Nomina',1,1,1,1,1,'2021-04-19'),
(1,3,'Nomina',1,1,1,1,1,'2021-04-22'),
(1,4,'Nomina',1,1,1,1,1,'2021-04-22'),
(1,5,'Nomina',1,1,1,1,1,'2021-04-22');

DROP TABLE IF EXISTS usuario_conexion;
CREATE TABLE usuario_conexion (
	id INT AUTO_INCREMENT,
	id_usuarios INT NOT NULL,
	ip VARCHAR(250) NOT NULL,
	dispositivo VARCHAR(250) NOT NULL,
	token VARCHAR(250) NOT NULL,
	profile_photo_path TEXT NOT NULL,
	conexion_desde datetime NOT NULL,
	conexion_hasta datetime NOT NULL,
	conexion_cerrada datetime NOT NULL,
	estatus INT NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE usuario_conexion CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS empresas;
CREATE TABLE empresas (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	direccion VARCHAR(250) NOT NULL,
	ciudad VARCHAR(250) NOT NULL,
	descripcion VARCHAR(250) NOT NULL,
	responsable VARCHAR(250) NOT NULL,
	cedula VARCHAR(250) NOT NULL,
	rut VARCHAR(250) NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE empresas CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO empresas (nombre,direccion,ciudad,descripcion,responsable,cedula,rut) VALUES 
('Camaleon Models Group','Direccion','Bogotá D.C','BERNAL GROUP  SAS','Andres Fernando Bernal Correa', '80.774.671', '901.257.204-8'),
('Camaleon Models Group Medellin','Carrera 81 #30A 67','Medellin','BERNAL GROUP  SAS','Andres Fernando Bernal Correa', '80.774.671', '901322261-6');
	
DROP TABLE IF EXISTS sedes;
CREATE TABLE sedes (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	direccion VARCHAR(250) NOT NULL,
	ciudad VARCHAR(250) NOT NULL,
	cedula VARCHAR(250) NOT NULL,
	id_empresa VARCHAR(250) NOT NULL,
	fecha_creacion DATE NOT NULL,
	fecha_modificacion DATE NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE sedes CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO sedes (nombre,direccion,ciudad,cedula,id_empresa,fecha_creacion,fecha_modificacion) VALUES 
('VIP Occidente','Direccion','Bogotá D.C', '80.774.671',1,'2021-06-20','2021-06-29'),
('Norte','Direccion','Bogotá D.C', '80.774.671',1,'2021-06-20','2021-06-29'),
('Occidente I','Direccion','Bogotá D.C', '80.774.671',1,'2021-06-20','2021-06-29'),
('VIP Suba','Direccion','Bogotá D.C', '80.774.671',1,'2021-06-20','2021-06-29'),
('Medellin','Direccion','Medellin', '80.774.671',2,'2021-06-20','2021-06-29'),
('Soacha','Direccion','Bogotá D.C', '80.774.671',1,'2021-06-20','2021-06-29'),
('Belen','Carrera 81 #30A 67','Medellin', '80.774.671',2,'2021-06-20','2021-06-29'),
('Sur Americana','Calle 48 #66 70','Medellin', '80.774.671',2,'2021-06-20','2021-06-29'),
('Manrique','Carrera 36 #70 41','Medellin', '80.774.671',2,'2021-06-20','2021-06-29');

DROP TABLE IF EXISTS datos_pasantes;
CREATE TABLE datos_pasantes (
	id INT AUTO_INCREMENT,
	id_usuarios INT NOT NULL,
	sede INT NOT NULL,
	estatus INT NOT NULL,
	turno INT DEFAULT 0,
	fecha_modificacion date NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE datos_pasantes CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO datos_pasantes (id_usuarios,sede,estatus,turno,fecha_modificacion,fecha_creacion) VALUES 
(1,1,1,1,'','2021-04-19');

DROP TABLE IF EXISTS peticiones;
CREATE TABLE peticiones (
	id INT AUTO_INCREMENT,
	id_usuarios INT NOT NULL,
	opcion INT NOT NULL,
	asunto INT NOT NULL,
	responsable INT NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE peticiones CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS datos_nominas;
CREATE TABLE datos_nominas (
	id INT AUTO_INCREMENT,
	id_usuarios INT NOT NULL,
	sede INT NOT NULL,
	estatus INT NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE datos_nominas CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO datos_nominas (id_usuarios,sede,estatus,fecha_creacion) VALUES 
(1,1,1,'2021-04-19');

DROP TABLE IF EXISTS modulos_sub;
CREATE TABLE modulos_sub (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	url VARCHAR(250) NOT NULL,
	id_modulos INT NOT NULL,
	estatus INT NOT NULL,
	responsable INT NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE modulos_sub CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO modulos_sub (nombre,url,id_modulos,estatus,responsable,fecha_creacion) VALUES 
('Listado','index.php',2,1,1,'2021-07-29'),
('Solicitudes','solicitudes.php',2,1,1,'2021-07-29'),
('Listado','index.php',3,1,1,'2021-04-18'),
('Soporte','soporte.php',3,1,1,'2021-04-18'),
('Jefe Soporte','jefesoporte.php',3,1,1,'2021-04-18');

DROP TABLE IF EXISTS modulos_sub_usuarios;
CREATE TABLE modulos_sub_usuarios (
	id INT AUTO_INCREMENT,
	id_modulos_sub INT NOT NULL,
	id_usuarios INT NOT NULL,
	estatus INT NOT NULL,
	responsable INT NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE modulos_sub_usuarios CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO modulos_sub_usuarios (id_modulos_sub,id_usuarios,estatus,responsable,fecha_creacion) VALUES 
(1,1,1,1,'2021-04-22'),
(2,1,1,1,'2021-04-22'),
(3,1,1,1,'2021-04-22');

DROP TABLE IF EXISTS datos_modelos;
CREATE TABLE datos_modelos (
	id INT AUTO_INCREMENT,
	id_usuarios INT NOT NULL,
	banco_cedula VARCHAR(250) NOT NULL,
	banco_nombre VARCHAR(250) NOT NULL,
	banco_tipo VARCHAR(250) NOT NULL,
	banco_numero VARCHAR(250) NOT NULL,
	banco_banco VARCHAR(250) NOT NULL,
	banco_bcpp VARCHAR(250) NOT NULL,
	banco_tipo_documento INT NOT NULL,
	altura VARCHAR(250) NOT NULL,
	peso VARCHAR(250) NOT NULL,
	tpene VARCHAR(250) NOT NULL,
	tsosten VARCHAR(250) NOT NULL,
	tbusto VARCHAR(250) NOT NULL,
	tcintura VARCHAR(250) NOT NULL,
	tcaderas VARCHAR(250) NOT NULL,
	tipo_cuerpo VARCHAR(250) NOT NULL,
	pvello VARCHAR(250) NOT NULL,
	color_cabello VARCHAR(250) NOT NULL,
	color_ojos VARCHAR(250) NOT NULL,
	ptattu VARCHAR(250) NOT NULL,
	ppiercing VARCHAR(250) NOT NULL,
	turno INT DEFAULT 0,
	estatus INT NOT NULL,
	sede INT NOT NULL,
	fecha_modificacion date NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE datos_modelos CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO datos_modelos (id_usuarios,banco_cedula,banco_nombre,banco_tipo,banco_numero,banco_banco,banco_bcpp,banco_tipo_documento,altura,peso,tpene,tsosten,tbusto,tcintura,tcaderas,tipo_cuerpo,pvello,color_cabello,color_ojos,ptattu,ppiercing,turno,estatus,sede,fecha_creacion) VALUES 
(1,"955948708101993","Juan Jose Maldonado la Cruz","Ahorro","545454545454","Bancolombia","propia",1,"1.76","75","25","","","","","Delgado","afeitado","negro","negro","No","No",1,1,1,"2021-04-22");

DROP TABLE IF EXISTS genero;
CREATE TABLE genero (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	id_empresa INT NOT NULL,
	fecha_modificacion DATE NOT NULL,
	fecha_creacion DATE NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE genero CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO genero (nombre,id_empresa,fecha_creacion) VALUES 
('Hombre',1,'2021-07-28'),
('Mujer',1,'2021-07-28'),
('Transexual',1,'2021-07-28');

DROP TABLE IF EXISTS enterado;
CREATE TABLE enterado (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE enterado CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO enterado (nombre) VALUES 
('Facebook'),
('Twitter'),
('Instagram'),
('Pagina Web'),
('Conocido');

DROP TABLE IF EXISTS datos_pasantias;
CREATE TABLE datos_pasantias (
	id INT AUTO_INCREMENT,
	id_usuarios INT NOT NULL,
	sede INT NOT NULL,
	fecha_creacion date NOT NULL,
	hora_creacion time NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE datos_pasantias CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO datos_pasantias (id_usuarios,sede,fecha_creacion,hora_creacion) VALUES 
(1,1,"2021-04-22","14:10:25");

DROP TABLE IF EXISTS apiwhatsapp;
CREATE TABLE apiwhatsapp (
	id INT AUTO_INCREMENT,
	token VARCHAR(250) NOT NULL,
	url VARCHAR(250) NOT NULL,
	fecha_creacion date NOT NULL,
	hora_creacion time NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE apiwhatsapp CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO apiwhatsapp (token,url,fecha_creacion,hora_creacion) VALUES 
('hyg1a0vao95bq3ij',"instance261035","2021-06-30","03:39:25");

DROP TABLE IF EXISTS paises;
CREATE TABLE paises (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	codigo VARCHAR(250) NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE paises CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO paises (codigo,nombre) VALUES 
('54','Argentina'),
('591','Bolivia'),
('55','Brasil'),
('56','Chile'),
('57','Colombia'),
('506','Costa Rica'),
('53','Cuba'),
('593','Ecuador'),
('503','El Salvador'),
('594','Guayana Francesa'),
('1_granada','Granada'),
('502','Guatemala'),
('592','Guayana'),
('509','Haití'),
('504','Honduras'),
('1_jamaica','Jamaica'),
('52','México'),
('505','Nicaragua'),
('595','Paraguay'),
('507','Panamá'),
('51','Perú'),
('1_puerto_rico','Puerto Rico'),
('1_republica_dominicana','República Dominicana'),
('597','Surinam'),
('598','Uruguay'),
('58','Venezuela');

DROP TABLE IF EXISTS modulos_empresas;
CREATE TABLE modulos_empresas (
	id INT AUTO_INCREMENT,
	id_empresas INT NOT NULL,
	id_modulos INT NOT NULL,
	estatus INT NOT NULL,
	fecha_modificacion date NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE modulos_empresas CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO modulos_empresas (id_modulos,id_empresas,estatus,fecha_creacion) VALUES 
(2,1,1,"2021-07-29"),
(3,1,1,"2021-07-29");

DROP TABLE IF EXISTS turnos;
CREATE TABLE turnos (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	responsable INT NOT NULL,
	fecha_modificacion date NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE turnos CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO turnos (nombre,fecha_creacion) VALUES 
('Mañana','2021-07-30'),
('Tarde','2021-07-30'),
('Noche','2021-07-30');