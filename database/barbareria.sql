CREATE DATABASE IF NOT EXISTS barberia;
USE barberia;

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(15) NOT NULL UNIQUE
);

CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    telefono VARCHAR(15),
    fecha DATE NOT NULL,
    hora TIME NOT NULL
);

CREATE TABLE servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(6,2) NOT NULL
);

INSERT INTO servicios (nombre, precio) VALUES
('Corte de cabello', 150.00),
('Afeitado clásico', 100.00),
('Corte + Barba', 220.00);
