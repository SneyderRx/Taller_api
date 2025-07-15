CREATE DATABASE IF NOT EXISTS php_pdo;

USE php_pdo;

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(20) NOT NULL UNIQUE
);

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    categoria_id INT,
    Foreign Key (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL
);

CREATE TABLE promociones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descripcion TEXT,
    descuento DECIMAL(5, 2) NOT NULL,
    producto_id INT NOT NULL UNIQUE,
    Foreign Key (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

INSERT INTO categorias (nombre) VALUES
('Tecnología'),
('Hogar'),
('Ropa');

-- Insertar 5 productos
INSERT INTO productos (nombre, precio, categoria_id) VALUES
('Laptop Pro X', 2500000.00, 1),
('Mouse Gamer', 150000.00, 1),
('Juego de Sábanas Queen', 120000.00, 2),
('Camiseta de Algodón', 55000.00, 3),
('Cafetera Eléctrica', 210000.00, 2);