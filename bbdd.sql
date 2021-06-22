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

-- INSERTS

-- USUARIOS

INSERT INTO usuarios
SET email
= 'uno@uno',
password = "$2y$10$AeSRdA8WTWJpZ3ZFwkEQIeG6a5g20EVY8ig3slJI3CjA9yQqd7Xtq";

INSERT INTO usuarios
SET email
= 'dos@dos',
password = "$2y$10$BWHWXmfmJrV9sVVQEAxIWu3yBxrFU.hdpKSNBGVDJCmmtU/xLQkLu";

INSERT INTO usuarios
SET email
= 'tres@tres',
password = "$2y$10$FYRDwgiPDZ1A4I4CepGTQ.ZfbZblq2VjVhEKIwCmhCoW/3hokW4tq";

-- PUBLICACIONES

INSERT INTO publicaciones
SET texto
= 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',

imagen = "group-friends.jpg", usuarios_id = 1;

INSERT INTO publicaciones
SET texto
= 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',

usuarios_id = 2;

INSERT INTO publicaciones
SET texto
= 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',

imagen = "img-publicacion.jpg", usuarios_id = 2;

INSERT INTO publicaciones
SET texto
= 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',

usuarios_id = 3;