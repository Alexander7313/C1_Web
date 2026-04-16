-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS control_visitantes;
USE control_visitantes;

-- Tabla de usuarios (para el personal de seguridad/admin)
CREATE TABLE IF NOT EXISTS usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Tabla de despachos/oficinas
CREATE TABLE IF NOT EXISTS despacho (
    id_despacho INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- Tabla de personas (visitantes)
CREATE TABLE IF NOT EXISTS persona (
    id_persona INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    dni VARCHAR(20) NOT NULL UNIQUE
);

-- Tabla de visitas
CREATE TABLE IF NOT EXISTS visita (
    id_visita INT AUTO_INCREMENT PRIMARY KEY,
    id_persona INT NOT NULL,
    id_despacho INT NOT NULL,
    persona_visitada VARCHAR(100) NOT NULL,
    fecha DATE NOT NULL,
    hora_entrada TIME NOT NULL,
    hora_salida TIME DEFAULT NULL,
    tiempo_permanencia VARCHAR(50) DEFAULT NULL,
    FOREIGN KEY (id_persona) REFERENCES persona(id_persona),
    FOREIGN KEY (id_despacho) REFERENCES despacho(id_despacho)
);

-- Insertar usuario por defecto (admin / admin123)
-- Usamos MD5 para el ejemplo rápido, aunque en PHP usaremos password_hash. 
-- Para admin123 el hash MD5 es: 0192023a7bbd73250516f069df18b500
INSERT INTO usuario (username, password) VALUES ('admin', '0192023a7bbd73250516f069df18b500');

-- Datos de prueba para despachos
INSERT INTO despacho (nombre) VALUES 
('Gerencia General'),
('Recursos Humanos'),
('Logística'),
('Contabilidad'),
('Sistemas');

-- Datos de prueba para personas
INSERT INTO persona (nombre, dni) VALUES 
('Juan Pérez', '12345678'),
('María García', '87654321'),
('Carlos López', '11223344'),
('Ana Martínez', '44332211'),
('Luis Rodríguez', '55667788');

-- Datos de prueba para visitas (algunas con salida, otras sin salida)
INSERT INTO visita (id_persona, id_despacho, persona_visitada, fecha, hora_entrada, hora_salida, tiempo_permanencia) VALUES 
(1, 1, 'Lic. Roberto Gómez', CURDATE(), '08:00:00', '09:30:00', '1 hora 30 minutos'),
(2, 2, 'Dra. Elena Rivas', CURDATE(), '08:15:00', '08:45:00', '0 horas 30 minutos'),
(3, 3, 'Ing. Mario Soto', CURDATE(), '09:00:00', NULL, NULL),
(4, 4, 'CPCC. Julia Mendoza', CURDATE(), '09:30:00', '11:00:00', '1 hora 30 minutos'),
(5, 5, 'Ing. Kevin Torres', CURDATE(), '10:00:00', NULL, NULL),
(1, 2, 'Lic. Roberto Gómez', DATE_SUB(CURDATE(), INTERVAL 1 DAY), '14:00:00', '15:15:00', '1 hora 15 minutos'),
(2, 3, 'Ing. Mario Soto', DATE_SUB(CURDATE(), INTERVAL 1 DAY), '15:00:00', '16:00:00', '1 hora 0 minutos'),
(3, 1, 'Lic. Roberto Gómez', DATE_SUB(CURDATE(), INTERVAL 2 DAY), '08:00:00', '10:30:00', '2 horas 30 minutos'),
(4, 5, 'Ing. Kevin Torres', DATE_SUB(CURDATE(), INTERVAL 2 DAY), '11:00:00', '11:45:00', '0 horas 45 minutos'),
(5, 2, 'Dra. Elena Rivas', DATE_SUB(CURDATE(), INTERVAL 3 DAY), '09:00:00', '12:00:00', '3 horas 0 minutos');
