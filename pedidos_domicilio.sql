CREATE DATABASE pedidos_domicilio
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE pedidos_domicilio;

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    producto VARCHAR(100) NOT NULL,
    cantidad INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    costo_express DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    estado VARCHAR(30) NOT NULL DEFAULT 'Pendiente',
    fecha_pedido DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);