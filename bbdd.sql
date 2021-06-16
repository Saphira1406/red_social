DROP DATABASE IF EXISTS red_social;
CREATE DATABASE
IF NOT EXISTS red_social;
USE red_social;


-- -----------------------------------------------------
-- Tabla usuarios
-- -----------------------------------------------------
CREATE TABLE
IF NOT EXISTS usuarios
(
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  email VARCHAR
(45) NOT NULL UNIQUE,
  usuario VARCHAR
(45) UNIQUE,
  password VARCHAR
(255) NOT NULL,
nombre VARCHAR
(45),
  apellido VARCHAR
(45),
imagen VARCHAR
(60) NOT NULL DEFAULT 'default.jpg',

  PRIMARY KEY
(id)
)ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabla publicaciones
-- -----------------------------------------------------
CREATE TABLE
IF NOT EXISTS publicaciones
(id INT UNSIGNED NOT NULL AUTO_INCREMENT, 
imagen VARCHAR
(60),
texto TEXT
(1000), 
usuarios_id INT UNSIGNED,

PRIMARY KEY
(id),

FOREIGN KEY
(usuarios_id) REFERENCES usuarios
(id) ON
DELETE
SET NULL
ON
UPDATE CASCADE

)ENGINE = InnoDB;


-- -----------------------------------------------------
-- Tabla comentarios
-- -----------------------------------------------------
CREATE TABLE
IF NOT EXISTS comentarios
(id INT UNSIGNED NOT NULL AUTO_INCREMENT, 
texto TEXT
(1000), 
usuarios_id INT UNSIGNED,
publicaciones_id INT UNSIGNED,

PRIMARY KEY
(id),

FOREIGN KEY
(usuarios_id) REFERENCES usuarios
(id) ON
DELETE
SET NULL
ON
UPDATE CASCADE,

FOREIGN KEY
(publicaciones_id) REFERENCES publicaciones
(id)
ON
DELETE
SET NULL
ON
UPDATE CASCADE
)ENGINE = InnoDB;