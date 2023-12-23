# Proyecto Web de Gestión de Productos
Este repositorio contiene el código fuente de una aplicación web desarrollada en PHP, HTML y CSS, con una base de datos MySQL para la gestión de productos en una tienda. El proyecto sigue el patrón Modelo-Vista-Controlador (MVC) para garantizar una estructura modular y mantenible.

## Estructura del Proyecto
El código se organiza siguiendo el patrón MVC, separando las responsabilidades de la siguiente manera:

- Modelo: Contiene los archivos relacionados con la interacción con la base de datos y la lógica de negocio.
- Vista: Almacena los archivos relacionados con la interfaz de usuario, como HTML y CSS.
- Controlador: Contiene los archivos PHP responsables de manejar las solicitudes del usuario y coordinar la interacción entre el modelo y la vista.
## Características Principales
### 1. Autenticación de Usuarios
La aplicación implementa un sistema de autenticación para permitir el acceso de diferentes tipos de usuarios al sistema. Los usuarios tendrán roles específicos que determinan sus permisos.

### 2. Gestión de Usuarios por el Superadmin
El superadmin tiene la capacidad de acceder al listado de usuarios y cambiar los permisos asociados a cada uno, brindando un control total sobre la gestión de productos en la tienda.

### 3. Sistema de Gestión de Productos
El sistema ofrece las siguientes funcionalidades para la gestión de productos:

- Agregar: Permite la adición de nuevos productos al catálogo.
- Editar: Permite realizar modificaciones en los detalles de los productos existentes.
- Eliminar: Facilita la eliminación de productos del catálogo.
- Consulta: Permite visualizar la lista de productos disponibles en la tienda.
## Requisitos del Sistema
Para ejecutar la aplicación, asegúrate de tener instalado lo siguiente:

Servidor web (por ejemplo, Apache)
PHP 7.x
MySQL 5.x
Navegador web moderno
## Instrucciones de Instalación
1. Clona este repositorio en tu máquina local.

```bash 
git clone https://github.com/tuusuario/nombre-del-repo.git
```

1. Importa la base de datos proporcionada en el archivo database.sql en tu servidor MySQL.

1. Configura la conexión a la base de datos en el archivo config/database.php.

1. Abre la aplicación en tu navegador.

```bash 
Usuario: superadmin
Contraseña: contraseña
```
## Contribuciones
Si deseas contribuir a este proyecto, por favor sigue las mejores prácticas de desarrollo y envía tus pull requests. Si encuentras problemas o tienes sugerencias, crea una nueva issue.

¡Gracias por tu interés en este proyecto!
