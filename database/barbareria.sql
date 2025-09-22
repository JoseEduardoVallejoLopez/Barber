-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS barberia;
USE barberia;

-- Crear la tabla de clientes
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(15) NOT NULL UNIQUE
);

-- Crear la tabla de servicios
CREATE TABLE servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(6,2) NOT NULL
);

-- Crear la tabla de reservas con la nueva columna 'servicio'
CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    telefono VARCHAR(15),
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    servicio VARCHAR(100) NOT NULL
);

-- Crear la tabla para los usuarios (barberos)
-- Advertencia: La contraseña no está encriptada para simplificar, pero no es seguro para producción.
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL
);

-- Insertar un usuario de ejemplo (barbero)
-- Usuario: barbero, Contraseña: barber123
INSERT INTO usuarios (nombre, usuario, contrasena) VALUES
('El Barbero', 'barbero', 'barber123');

-- Insertar los servicios con sus precios
INSERT INTO servicios (nombre, precio) VALUES
('Corte de Cabello', 180.00),
('Corte y Barba', 250.00),
('Corte, Barba y Facial', 350.00),
('Afeitado Clásico', 200.00),
('Diseño de Barba', 180.00),
('Tratamiento Facial', 280.00),
('Mascarilla Negra', 220.00),
('Peinado y Estilizado', 190.00),
('Corte Infantil', 160.00);