-- Base de datos completa - PowerLetters (Con limpieza automática para evitar duplicados)
DROP DATABASE IF EXISTS powerletters;
CREATE DATABASE powerletters;
USE powerletters;
 
CREATE TABLE tb_usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre_usuario varchar(50) NOT NULL,
  apellido_usuario varchar(50) NOT NULL,
  dui_usuario varchar(10) NOT NULL,
  correo_usuario varchar(100) NOT NULL,
  telefono_usuario varchar(9) NOT NULL,
  direccion_usuario varchar(250) NOT NULL,
  nacimiento_usuario date NOT NULL,
  clave_usuario varchar(100) NOT NULL,
  imagen VARCHAR(25),
  estado_cliente tinyint(1) NOT NULL DEFAULT 1,
  fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE administrador (
	id_administrador INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	nombre_administrador VARCHAR(50) NOT NULL,
	apellido_administrador VARCHAR(50) NOT NULL,
	correo_administrador VARCHAR(100) NOT NULL,
	alias_administrador VARCHAR(25) NOT NULL,
	clave_administrador VARCHAR(100) NOT NULL,
	fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_administrador)
);

CREATE TABLE tb_generos (
    id_genero INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100)
);

 
CREATE TABLE tb_clasificaciones (
    id_clasificacion INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    descripcion VARCHAR(100)
);
 
CREATE TABLE tb_autores (
    id_autor INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(1000),
    biografia VARCHAR(1000)
);
 
CREATE TABLE tb_editoriales (
    id_editorial INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100)
);
 
CREATE TABLE tb_libros (
    id_libro INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(100),
    id_autor INT,
    precio DECIMAL(10, 2),
    descripcion VARCHAR(200),
    imagen VARCHAR(25),
    id_clasificacion INT,
    id_editorial INT,
    existencias INT,
    id_genero INT,
    CONSTRAINT fk_generolibro FOREIGN KEY (id_genero) REFERENCES tb_generos(id_genero),
    CONSTRAINT fk_autor FOREIGN KEY (id_autor) REFERENCES tb_autores(id_autor),
    CONSTRAINT fk_clasificacion FOREIGN KEY (id_clasificacion) REFERENCES tb_clasificaciones(id_clasificacion),
    CONSTRAINT fk_editorial FOREIGN KEY (id_editorial) REFERENCES tb_editoriales(id_editorial)
);

SELECT*FROM tb_libros;

CREATE TABLE tb_pedidos (
    id_pedido INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    direccion_pedido varchar(250) NOT NULL,
    estado ENUM('FINALIZADO', 'PENDIENTE', 'ENTREGADO', 'CANCELADO') NULL DEFAULT 'PENDIENTE',
    fecha_pedido DATETIME DEFAULT NOW(),
    CONSTRAINT fk_usuario FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id_usuario)
);

CREATE TABLE tb_detalle_pedidos (
    id_detalle INT PRIMARY KEY AUTO_INCREMENT,
    id_libro INT,
    cantidad INT,
    id_pedido INT,
    precio DECIMAL(10, 2),
    CONSTRAINT fk_libro FOREIGN KEY (id_libro) REFERENCES tb_libros(id_libro),
    CONSTRAINT fk_pedido FOREIGN KEY (id_pedido) REFERENCES tb_pedidos(id_pedido)
);

CREATE TABLE tb_comentarios (
    id_comentario INT PRIMARY KEY AUTO_INCREMENT,
    comentario VARCHAR(250),
    calificacion INT,
    estado_comentario ENUM('ACTIVO', 'BLOQUEADO') NULL DEFAULT 'ACTIVO', 
    id_detalle INT,
    CONSTRAINT fk_comentario_detalle FOREIGN KEY (id_detalle) REFERENCES tb_detalle_pedidos(id_detalle)
);

-- ==========================================
-- INSERCIÓN DE DATOS INICIALES
-- ==========================================
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE tb_comentarios;
TRUNCATE TABLE tb_detalle_pedidos;
TRUNCATE TABLE tb_pedidos;
TRUNCATE TABLE tb_libros;
TRUNCATE TABLE tb_editoriales;
TRUNCATE TABLE tb_autores;
TRUNCATE TABLE tb_clasificaciones;
TRUNCATE TABLE tb_generos;
TRUNCATE TABLE tb_usuarios;
TRUNCATE TABLE administrador;

SET FOREIGN_KEY_CHECKS = 1;

-- 1. Insertar Usuarios
INSERT INTO tb_usuarios (id_usuario, nombre_usuario, apellido_usuario, dui_usuario, correo_usuario, telefono_usuario, direccion_usuario, nacimiento_usuario, clave_usuario, imagen, estado_cliente) VALUES 
(1, 'Frankie', 'De Jong', '00000001', 'frankie@barca.com', '123456789', 'Calle Barça, 1', '1997-05-12', 'contraseña123', 'frankie.jpg', 1),
(2, 'Lionel', 'Messi', '00000002', 'messi@barca.com', '123456780', 'Calle Barça, 10', '1987-06-24', 'contraseña456', 'messi.jpg', 1),
(3, 'Jordi', 'Alba', '00000003', 'alba@barca.com', '123456781', 'Calle Barça, 11', '1989-03-21', 'contraseña789', 'alba.jpg', 1),
(4, 'Sergio', 'Busquets', '00000004', 'busquets@barca.com', '123456782', 'Calle Barça, 12', '1988-07-16', 'contraseña012', 'busquets.jpg', 1),
(5, 'Jordi', 'Alba', '00000005', 'alba@barca.com', '123456783', 'Calle Barça, 13', '1989-03-21', 'contraseña345', 'alba.jpg', 1);

-- 2. Insertar Administradores
INSERT INTO administrador (nombre_administrador, apellido_administrador, correo_administrador, alias_administrador, clave_administrador) VALUES 
('Admin', 'Principal', 'admin@powerletters.com', 'admin', 'admin123');

-- 3. Insertar Géneros (Ejemplo)
INSERT INTO tb_generos (id_genero, nombre) VALUES 
(1, 'Novela'),
(2, 'Ficción'),
(3, 'Poesía');

-- 4. Insertar Clasificaciones (Ejemplo)
INSERT INTO tb_clasificaciones (id_clasificacion, nombre, descripcion) VALUES 
(1, 'General', 'Para todo público'),
(2, 'Juvenil', 'Literatura juvenil');

-- 5. Insertar Autores (Ejemplo)
INSERT INTO tb_autores (id_autor, nombre, biografia) VALUES 
(1, 'Gabriel García Márquez', 'Escritor colombiano, premio Nobel de Literatura.'),
(2, 'Jane Austen', 'Autora británica de novelas clásicas.'),
(3, 'Isabel Allende', 'Escritora chilena.'),
(4, 'Fiódor Dostoyevski', 'Novelista ruso.');

-- 6. Insertar Editoriales (Ejemplo)
INSERT INTO tb_editoriales (id_editorial, nombre) VALUES 
(1, 'Editorial Sudamericana'),
(2, 'Penguin Random House'),
(3, 'Routledge');

-- 7. Insertar Libros (Ejemplos principales)
INSERT INTO tb_libros (id_libro, titulo, id_autor, precio, descripcion, imagen, id_clasificacion, id_editorial, existencias, id_genero) VALUES 
(1, 'Cien años de soledad', 1, 15.99, 'Una saga familiar en Macondo', 'imagen1.jpg', 1, 1, 50, 1),
(2, 'Orgullo y Prejuicio', 2, 12.99, 'Amor y prejuicios en la Inglaterra del siglo XIX', 'imagen2.jpg', 2, 2, 30, 1),
(4, 'Orgullo y Prejuicio', 4, 12.99, 'Amor y prejuicios en la Inglaterra del siglo XIX', 'imagen2.jpg', 2, 2, 30, 1),
(5, 'Orgullo y Prejuicio', 4, 12.99, 'Amor y prejuicios en la Inglaterra del siglo XIX', 'imagen2.jpg', 2, 2, 30, 1),
(3, 'Crimen y castigo', 4, 13.99, 'Crimen moral y castigo psicológico en San Petersburgo', 'imagen3.jpg', 1, 3, 40, 1);

-- 8. Insertar Pedidos
INSERT INTO tb_pedidos (id_pedido, id_usuario, direccion_pedido, estado, fecha_pedido) VALUES 
(1, 1, 'Calle Principal 123', 'PENDIENTE', NOW()),
(2, 2, 'Avenida Central 456', 'ENTREGADO', NOW()),
(3, 3, 'Plaza Mayor 789', 'FINALIZADO', NOW());

-- 9. Insertar Detalle de Pedidos
INSERT INTO tb_detalle_pedidos (id_detalle, id_libro, cantidad, id_pedido, precio) VALUES 
(1, 1, 2, 1, 15.99),
(2, 2, 1, 2, 12.99),
(3, 3, 3, 3, 13.99);

-- 10. Insertar Comentarios
INSERT INTO tb_comentarios (id_comentario, comentario, calificacion, estado_comentario, id_detalle) VALUES 
(1, 'Me encantó el libro', 5, 'ACTIVO', 1),
(2, 'Muy buena trama', 4, 'ACTIVO', 2),
(3, 'Excelente obra literaria', 5, 'ACTIVO', 3);

-- ==========================================
-- VISTA / CONSULTA GENERAL
-- ==========================================
SELECT
 c.id_comentario,
 c.comentario,
 c.calificacion,
 c.estado_comentario,
 u.nombre_usuario,
 dp.id_detalle,
 dp.id_libro,
 dp.cantidad,
 dp.precio,
 l.titulo,
 l.imagen, 
 CASE WHEN c.estado_comentario = 1 THEN "ACTIVO" WHEN c.estado_comentario = 0 THEN "BLOQUEADO" END AS "ESTADO"
FROM 
tb_comentarios AS c
INNER JOIN 
tb_detalle_pedidos AS dp ON c.id_detalle = dp.id_detalle
INNER JOIN 
tb_pedidos AS p ON dp.id_pedido = p.id_pedido
INNER JOIN 
tb_usuarios AS u ON p.id_usuario = u.id_usuario
INNER JOIN 
tb_libros AS l ON dp.id_libro = l.id_libro
WHERE c.estado_comentario ="ACTIVO";

-- Trigger para los usuarios
DELIMITER //

CREATE TRIGGER before_insert_tb_usuarios
BEFORE INSERT ON tb_usuarios
FOR EACH ROW
BEGIN
  SET NEW.fecha_registro = CURDATE();
END//

DELIMITER ;