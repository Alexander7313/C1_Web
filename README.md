# 🏛️ Sistema de Control de Visitantes - Portal Institucional

Este es un sistema web profesional diseñado para el registro y gestión de ingresos de visitantes en entidades gubernamentales o corporativas. Permite un seguimiento en tiempo real de quiénes ingresan, a qué oficina se dirigen y cuánto tiempo permanecen en las instalaciones.

## 🚀 Características Principales

- **📦 Gestión de Visitantes**: Registro automático de personas mediante DNI.
- **🏢 Control de Despachos**: Catálogo de oficinas y dependencias.
- **⏱️ Seguimiento de Estancia**: Registro de hora de entrada, salida y cálculo automático de permanencia.

## 📊 Diseño de Base de Datos

El sistema opera bajo un modelo optimizado de cuatro tablas:
- **`despacho`**: Catálogo de oficinas y dependencias institucionales.
- **`funcionario`**: Personal autorizado asignado a cada despacho para recibir visitas.
- **`persona`**: Registro único de visitantes (vinculado por DNI).
- **`visita`**: Historial detallado de ingresos, salidas y tiempos de permanencia.

## ⚙️ Instalación en Local (localhost)

Sigue estos pasos para poner en marcha el proyecto en tu PC:

1.  **Mover el Proyecto**: Copia la carpeta `C1_Web` dentro del directorio `htdocs` de tu instalación de XAMPP.
2.  **Activar Servicios**: Abre el **XAMPP Control Panel** e inicia **Apache** y **MySQL**.
3.  **Configurar Base de Datos**:
    - Abre `http://localhost/phpmyadmin/`.
    - Crea la base de datos `control_visitantes`.
    - Importa el archivo `database.sql`.
4.  **Acceder al Sistema**:
    - Entra a `http://localhost/C1_Web/` en tu navegador. El acceso es directo y no requiere credenciales.

## 📁 Estructura del Proyecto

- `/assets`: Archivos CSS, JS e imágenes.
- `/config`: Conexión centralizada a la base de datos MySQL.
- `/includes`: Componentes reutilizables (Header, Footer, Navbar).
- `/modulos`: Funcionalidades de Registro, Consultas y Reportes.
- `index.php`: Portal de acceso principal.
- `database.sql`: Esquema de base de datos optimizado.

---
© 2026 Todos los derechos reservados. Desarrollado para la Unidad de TI.
