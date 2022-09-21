###################################################################################
#			CREACIÓN DE LA BASE DE DATOS			  #
###################################################################################
USE 8660393_Convector;
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS entidad, usuario, producto, datalogger, registro, carga, acceso_informacion,
enlace, subruta, vehiculo, vehiculo_carga, alerta;
SET FOREIGN_KEY_CHECKS = 1;

###################################################################################
#			ENTIDAD (1 clave externa añadida después)				  #
###################################################################################

CREATE TABLE IF NOT EXISTS entidad (
	nombre VARCHAR(150) NOT NULL,
	tipo VARCHAR(100) NOT NULL,
	direccion1 VARCHAR(250) NOT NULL,
	direccion2 VARCHAR(250),
	poblacion VARCHAR(100) NOT NULL,
	pais VARCHAR(100) NOT NULL,
	persona_contacto VARCHAR(150),
	PRIMARY KEY(nombre)
);

###################################################################################
#			USUARIO (1 clave externa)				  #
###################################################################################

CREATE TABLE IF NOT EXISTS usuario (
	nombre VARCHAR(150) NOT NULL,
	cargo VARCHAR(100) NOT NULL,
	email VARCHAR(150) NOT NULL,
	rol VARCHAR(100) NOT NULL,
	password VARCHAR(50) NOT NULL,
	entidad VARCHAR(150) NOT NULL,
	PRIMARY KEY(email),
	FOREIGN KEY(entidad) REFERENCES entidad(nombre) ON DELETE CASCADE
);

# Se añade el usuario de contacto a entidad una vez creada la tabla
ALTER TABLE entidad ADD FOREIGN KEY(persona_contacto) REFERENCES usuario(email) ON DELETE SET NULL;

###################################################################################
#			PRODUCTO (1 clave externa)				  #
###################################################################################

CREATE TABLE IF NOT EXISTS producto (
	codigo INT AUTO_INCREMENT,
	nombre VARCHAR(100) NOT NULL,
	variedad VARCHAR(100),
	t_min FLOAT NOT NULL,
	t_max FLOAT NOT NULL,
	entidad VARCHAR(150) NOT NULL,
	PRIMARY KEY(codigo),
	FOREIGN KEY(entidad) REFERENCES entidad(nombre) ON DELETE CASCADE
);

###################################################################################
#			DATALOGGER (1 clave externa)				  #
###################################################################################

CREATE TABLE IF NOT EXISTS datalogger (
	codigo VARCHAR(15) NOT NULL,
	estado VARCHAR(25) NOT NULL,
	entidad VARCHAR(150),
	PRIMARY KEY(codigo),
	FOREIGN KEY(entidad) REFERENCES entidad(nombre) ON DELETE SET NULL
);


###################################################################################
#			REGISTRO (1 clave externa)				  #
###################################################################################

CREATE TABLE IF NOT EXISTS registro (
	datalogger VARCHAR(15) NOT NULL,
	elapsed TIME NOT NULL,
	fecha DATE NOT NULL,
	hora TIME NOT NULL,
	temperatura FLOAT NOT NULL,
	PRIMARY KEY(datalogger, fecha, hora),
	FOREIGN KEY(datalogger) REFERENCES datalogger(codigo) ON DELETE CASCADE
);

###################################################################################
#			CARGA (3 claves externas)				  #
###################################################################################

CREATE TABLE IF NOT EXISTS carga (
	codigo VARCHAR(15) NOT NULL,
	kgs_totales FLOAT,
	num_contenedores INT,
	fecha_inicio DATE,
	fecha_final DATE,
	fecha_caducidad DATE,
	latitud_origen FLOAT,
	longitud_origen FLOAT,
	nombre_origen VARCHAR(125),
	latitud_destino FLOAT,
	longitud_destino FLOAT,
	nombre_destino VARCHAR(125),
	producto INT,
	entidad VARCHAR(150) NOT NULL,
	responsable varchar(150),
	PRIMARY KEY(codigo),
	FOREIGN KEY(producto) REFERENCES producto(codigo) ON DELETE SET NULL,
	FOREIGN KEY(entidad) REFERENCES entidad(nombre) ON DELETE CASCADE,
    FOREIGN KEY(responsable) REFERENCES usuario(email) ON DELETE SET NULL
);

###################################################################################
#			ACCESO_INFORMACION (2 claves externas)			  #
###################################################################################

CREATE TABLE IF NOT EXISTS acceso_informacion (
	carga VARCHAR(15) NOT NULL,
	email VARCHAR(150) NOT NULL,
	PRIMARY KEY(carga, email),
	FOREIGN KEY(carga) REFERENCES carga(codigo) ON DELETE CASCADE,
	FOREIGN KEY(email) REFERENCES usuario(email) ON DELETE CASCADE
);

###################################################################################
#			ENLACE (2 claves externas)				  #
###################################################################################

CREATE TABLE IF NOT EXISTS enlace (
	codigo INT AUTO_INCREMENT NOT NULL,
	contenedor VARCHAR(15) NOT NULL,
	carga VARCHAR(15) NOT NULL,
	datalogger VARCHAR(15) NOT NULL,
	PRIMARY KEY(codigo),
	FOREIGN KEY(carga) REFERENCES carga(codigo) ON DELETE CASCADE,
	FOREIGN KEY(datalogger) REFERENCES datalogger(codigo) ON DELETE CASCADE
);

###################################################################################
#			SUBRUTA (3 claves externas)				  #
###################################################################################

CREATE TABLE IF NOT EXISTS subruta (
	codigo VARCHAR(15) NOT NULL,
	fecha_hora_inicio DATETIME,
	fecha_hora_final DATETIME,
	latitud_origen FLOAT,
	longitud_origen FLOAT,
	nombre_origen VARCHAR(125),
	latitud_destino FLOAT,
	longitud_destino FLOAT,
	nombre_destino VARCHAR(125),
	entidad VARCHAR(150) NOT NULL,
	responsable VARCHAR(150),
	carga VARCHAR(15) NOT NULL,
	PRIMARY KEY(codigo),
	FOREIGN KEY(entidad)  REFERENCES entidad(nombre) ON DELETE CASCADE,
	FOREIGN KEY(responsable) REFERENCES usuario(email) ON DELETE SET NULL,
	FOREIGN KEY(carga) REFERENCES carga(codigo) ON DELETE CASCADE
);

###################################################################################
#			VEHÍCULO (1 clave externa)				  #
###################################################################################

CREATE TABLE IF NOT EXISTS vehiculo (
	matricula VARCHAR(25) NOT NULL,
	tipo VARCHAR(25),
	subruta VARCHAR(15) NOT NULL,
	PRIMARY KEY(matricula, subruta),
	FOREIGN KEY(subruta) REFERENCES subruta(codigo) ON DELETE CASCADE
);

###################################################################################
#			VEHÍCULO_CARGA (1 clave externa)		  #
###################################################################################

CREATE TABLE IF NOT EXISTS vehiculo_carga (
	matricula VARCHAR(25) NOT NULL,
	tipo VARCHAR(25),
	carga VARCHAR(15) NOT NULL,
	PRIMARY KEY(matricula, carga),
	FOREIGN KEY(carga) REFERENCES carga(codigo) ON DELETE CASCADE
);

###################################################################################
#			ALERTA (1 clave externa)				  #
###################################################################################

CREATE TABLE IF NOT EXISTS alerta (
	datalogger VARCHAR(15) NOT NULL,
	fecha TIME NOT NULL,
	hora TIME NOT NULL,
	temperatura FLOAT NOT NULL,
	id_estacion VARCHAR(25) NOT NULL,
	PRIMARY KEY(datalogger, fecha, hora),
	FOREIGN KEY(datalogger) REFERENCES datalogger(codigo) ON DELETE CASCADE
);