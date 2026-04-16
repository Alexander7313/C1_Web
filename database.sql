-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS control_visitantes;
USE control_visitantes;

-- Tabla de despachos/oficinas
CREATE TABLE IF NOT EXISTS despacho (
    id_despacho INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- Tabla de funcionarios (personas a visitar)
CREATE TABLE IF NOT EXISTS funcionario (
    id_funcionario INT AUTO_INCREMENT PRIMARY KEY,
    id_despacho INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    cargo VARCHAR(100),
    FOREIGN KEY (id_despacho) REFERENCES despacho(id_despacho)
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
    id_funcionario INT NOT NULL,
    fecha DATE NOT NULL,
    hora_entrada TIME NOT NULL,
    hora_salida TIME DEFAULT NULL,
    tiempo_permanencia VARCHAR(50) DEFAULT NULL,
    FOREIGN KEY (id_persona) REFERENCES persona(id_persona),
    FOREIGN KEY (id_despacho) REFERENCES despacho(id_despacho),
    FOREIGN KEY (id_funcionario) REFERENCES funcionario(id_funcionario)
);

-- Datos de prueba para despachos
INSERT INTO despacho (nombre) VALUES 
('Gerencia General'),
('Recursos Humanos'),
('Logística'),
('Contabilidad'),
('Sistemas');

-- Datos de prueba para funcionarios
INSERT INTO funcionario (id_despacho, nombre, cargo) VALUES 
(1, 'Lic. Roberto Gómez', 'Gerente General'),
(2, 'Dra. Elena Rivas', 'Jefa de RR.HH.'),
(3, 'Ing. Mario Soto', 'Jefe de Logística'),
(4, 'CPCC. Julia Mendoza', 'Contadora General'),
(5, 'Ing. Kevin Torres', 'Jefe de Sistemas'),
(2, 'Lic. Ana Pérez', 'Asistente de RR.HH.'),
(5, 'Ing. Luis García', 'Especialista de Redes');

-- Datos de prueba para personas
INSERT INTO persona (nombre, dni) VALUES 
('Juan Pérez', '12345678'),
('María García', '87654321'),
('Carlos López', '11223344'),
('Ana Martínez', '44332211'),
('Luis Rodríguez', '55667788');

-- Datos de prueba para visitas
INSERT INTO visita (id_persona, id_despacho, id_funcionario, fecha, hora_entrada, hora_salida, tiempo_permanencia) VALUES 
(1, 1, 1, CURDATE(), '08:00:00', '09:30:00', '1 hora 30 minutos'),
(2, 2, 2, CURDATE(), '08:15:00', '08:45:00', '0 horas 30 minutos'),
(3, 3, 3, CURDATE(), '09:00:00', NULL, NULL),
(4, 4, 4, CURDATE(), '09:30:00', '11:00:00', '1 hora 30 minutos'),
(5, 5, 5, CURDATE(), '10:00:00', NULL, NULL);
