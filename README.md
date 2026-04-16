# 🏛️ Sistema de Control de Visitantes - Portal Institucional

Este es un sistema web profesional diseñado para el registro y gestión de ingresos de visitantes en entidades gubernamentales o corporativas. Permite un seguimiento en tiempo real de quiénes ingresan, a qué oficina se dirigen y cuánto tiempo permanecen en las instalaciones.

## 🚀 Características Principales

- **📦 Gestión de Visitantes**: Registro automático de personas mediante DNI.
- **🏢 Control de Despachos**: Catálogo de oficinas y dependencias.
- **⏱️ Seguimiento de Estancia**: Registro de hora de entrada, salida y cálculo automático de permanencia.
- **📊 Panel de Estadísticas**: Gráficos interactivos de visitas por día y por oficina.
- **🔍 Búsqueda Avanzada**: Filtros por fecha, nombre de visitante y oficina.
- **📤 Exportación de Datos**: Opción para descargar reportes en formato CSV/Excel.
- **🔒 Acceso Seguro**: Sistema de autenticación para personal autorizado.

## 🛠️ Requisitos Técnicos

- **XAMPP** (o cualquier servidor con PHP 8.0+ y MySQL)
- **Base de Datos**: MySQL / MariaDB
- **Frontend**: Bootstrap 5, FontAwesome 6, Chart.js

## ⚙️ Instalación en Local (localhost)

Sigue estos pasos para poner en marcha el proyecto en tu PC:

1.  **Mover el Proyecto**: Copia la carpeta `C1_Web` dentro del directorio `htdocs` de tu instalación de XAMPP (por defecto: `C:\xampp\htdocs`).
2.  **Activar Servicios**: Abre el **XAMPP Control Panel** e inicia los módulos **Apache** y **MySQL**.
3.  **Configurar Base de Datos**:
    - Abre tu navegador y ve a `http://localhost/phpmyadmin/`.
    - Crea una nueva base de datos llamada `control_visitantes`.
    - Haz clic en la pestaña "Importar" y selecciona el archivo `database.sql` que se encuentra en la raíz del proyecto.
    - Presiona "Ejecutar".
4.  **Verificar Conexión**:
    - Abre `config/conexion.php`.
    - Asegúrate de que las credenciales coincidan (por defecto: usuario `root` y sin contraseña).
5.  **Acceder al Sistema**:
    - Entra a `http://localhost/C1_Web/` en tu navegador.

## 🔐 Credenciales de Acceso

Por defecto, puedes ingresar con:
- **Usuario**: `admin`
- **Contraseña**: `admin123`

## 📁 Estructura del Proyecto

- `/assets`: Archivos CSS, JS e imágenes.
- `/auth`: Archivos de lógica de inicio y cierre de sesión.
- `/config`: Conexión a la base de datos MySQL.
- `/includes`: Componentes reutilizables (Header, Footer, Navbar).
- `/modulos`: Funcionalidades principales (Registro de entrada, salida, consultas y reportes).
- `index.php`: Página de inicio y login.
- `database.sql`: Esquema completo de la base de datos.

---
© 2026 Todos los derechos reservados. Desarrollado para la Unidad de TI.
