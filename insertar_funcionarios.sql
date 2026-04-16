-- Script para agregar más funcionarios al sistema
-- Asegúrese de haber ejecutado primero el database.sql principal

USE control_visitantes;

-- Limpiar funcionarios previos si desea re-insertar (Opcional)
-- TRUNCATE TABLE funcionario;

INSERT INTO funcionario (id_despacho, nombre, cargo) VALUES 
-- Gerencia General (ID 1)
(1, 'Dra. Patricia Arrieta', 'Gerente General'),
(1, 'Abg. Sergio Valdivia', 'Asesor Jurídico'),
(1, 'Lic. Claudia Benavente', 'Secretaria de Gerencia'),

-- Recursos Humanos (ID 2)
(2, 'Lic. Ricardo Zúñiga', 'Jefe de Recursos Humanos'),
(2, 'Bach. Milagros Choque', 'Analista de Planillas'),
(2, 'Psic. Fernando Morán', 'Bienestar Social'),
(2, 'Sra. Nancy Guevara', 'Asistente Administrativo'),

-- Logística (ID 3)
(3, 'Ing. Gustavo Vizcarra', 'Jefe de Logística'),
(3, 'Sr. Jorge Cáceres', 'Encargado de Almacén'),
(3, 'Lic. Silvia Paredes', 'Adquisiciones y Compras'),
(3, 'Bach. Alberto Quispe', 'Control Patrimonial'),

-- Contabilidad (ID 4)
(4, 'CPCC. Martha Vizcarra', 'Contadora General'),
(4, 'CPC. Daniel Espinoza', 'Tesorero'),
(4, 'Bach. Laura Medina', 'Auxiliar Contable'),
(4, 'Sr. Roberto Jara', 'Encargado de Caja'),

-- Sistemas (ID 5)
(5, 'Ing. Sandro Martínez', 'Jefe de TI'),
(5, 'Ing. Diego Salas', 'Especialista en Ciberseguridad'),
(5, 'Bach. Pedro Alca', 'Soporte Técnico'),
(5, 'Ing. Vanessa Ticona', 'Desarrolladora de Software'),
(5, 'Sr. Manuel Coaguila', 'Administrador de Redes');
