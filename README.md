# Proyecto Drogo (PHP)

# Tabla de contenidos

1. [Aviso importante](#aviso-importante)
    1. [Leer la explicación de la base de datos](#leer-la-explicación-de-la-base-de-datos)
2. [Descripción](#descripción)
3. [Diagramas](#diagramas)
    1. [Diagrama de casos de uso](#diagrama-de-casos-de-uso)
    2. [Diagrama de clases](#diagrama-de-clases)
    3. [Diagrama de entidad-relación](#diagrama-de-entidad-relación)
4. [Estructura del Proyecto](#estructura-del-proyecto)
    1. [Estructura general](#estructura-general)
    2. [Crud usuarios](#crud-usuarios)
    3. [Crud pedidos](#crud-pedidos)
    4. [Crud lockers](#crud-lockers)
5. [Instrucciones de Uso](#instrucciones-de-uso)
   1. [Requisitos Previos](#requisitos-previos)
   2. [Configuración de la Base de Datos](#configuración-de-la-base-de-datos)
   3. [Explicación de la Base de Datos](#explicación-de-la-base-de-datos)
6. [Autoría](#autoría)
7. [Licencia](#licencia)

# Aviso importante
Leer la explicación de la base de datos antes de entrar en la página para conocer los usuarios existentes y como loguearse como admin.

## Descripción

Drogo es una plataforma integral que facilita el envío, recepción y gestión de paquetes de manera anónima y confidencial, ofreciendo una variedad de servicios diseñados para brindar privacidad, comodidad y flexibilidad a los usuarios. Este repositorio contiene el código fuente PHP utilizado para implementar diferentes características de la plataforma.

## Diagramas

### Diagrama de casos de uso

![diagrama3](https://hackmd.io/_uploads/BkJFDR44p.jpg)


### Diagrama de clases

![diagrama2](https://hackmd.io/_uploads/HJ0R5XE4a.jpg)


### Diagrama de entidad-relación


![diagrama1](https://hackmd.io/_uploads/BywC9QNEa.jpg)

## Estructura del proyecto

### Estructura general

* registro.php: formulario de registro de nuevos usuarios con validación de datos para garantizar la integridad de la información ingresada.

* registro2.php: página para completar el proceso de registro, incluyendo la información de la cartera del usuario; se utiliza para finalizar la creación de la cuenta.

* login.php: página de inicio de sesión para usuarios registrados, donde los usuarios pueden acceder a sus cuentas proporcionando credenciales válidas.

* loginAdmin.php: página para realizar el inicio de sesión del administrador. En esta página, se procesa el formulario de inicio de sesión del administrador, se verifica la identidad del usuario y se manejan los errores. Además, se incluye el encabezado, se conecta a la base de datos y se generan mensajes de error si es necesario. Finalmente, se presenta el formulario de inicio de sesión del administrador.

* areaPersonal.php: página del área personal del usuario común. Este script PHP se encarga de mostrar el área personal del usuario común, proporcionando opciones y detalles específicos del usuario.

* areaPersonalAdmin.php: página del área personal del administrador; se encarga de mostrar el área personal del administrador, proporcionando opciones y detalles específicos del administrador.

* bloquear-usuario.php: página para bloquear o desbloquear usuarios; permite a un administrador bloquear o desbloquear usuarios a través de formularios de búsqueda y acciones correspondientes.

* borrar-cuenta.php: script para borrar la cuenta del usuario; posibilita a un usuario eliminar su cuenta.

* cerrar-sesion.php: script para cerrar la sesión de un usuario; destruye la sesión actual del usuario y lo redirige a la página de inicio.

* datos.php: página para modificar datos del usuario; permite al usuario modificar información como nombre de usuario, dirección de correo electrónico, contraseña y cartera.

* equipo.php: página para visualizar al equipo de la empresa. En esta página se muestra información sobre los miembros del equipo, incluyendo sus roles, experiencia y contribuciones a la empresa.

* form-contacto.php: página para mostrar un formulario de contacto. Así, los usuarios pueden completar un formulario de contacto, proporcionando información como nombre, correo electrónico, teléfono y mensaje. La información ingresada se procesa y se valida antes de ser enviada.

* index.php: página principal del sitio web (index). En esta página, se muestra información principal sobre el servicio de envío anónimo, destacando la privacidad y confidencialidad que ofrece Drogo. Además, incluye secciones sobre la garantía de privacidad y enlaces a servicios adicionales.

* modificarDatos.php: página que permite a los usuarios modificar información personal almacenada en la plataforma, como cambiar la contraseña o actualizar la dirección de correo electrónico.

* preguntas-frecuentes.php: página que presenta una lista de preguntas frecuentes y respuestas para proporcionar a los usuarios información detallada sobre el funcionamiento de Drogo.

* servicios.php: página que detalla los diversos servicios ofrecidos por Drogo, desde envío y recepción de paquetes hasta servicios de almacenamiento temporal y gestión de envíos internacionales.

* includes/funciones.php: archivo que contiene funciones comunes utilizadas en varias partes del proyecto para mejorar la modularidad y el mantenimiento del código.

* includes/config/database.php: configuración de la base de datos y función de conexión a la base de datos para gestionar la persistencia de los datos del usuario.

* css/: Carpeta que contiene archivos de estilo (CSS) para mejorar la presentación visual de las páginas.

* assets/: Carpeta que almacena imágenes y otros recursos utilizados en la interfaz de usuario.

### Crud usuarios

* actualizarusuario.php: página para la actualización de usuarios; se utiliza para actualizar la información de un usuario en el sistema. 

* usuario.php: página para la visualización y gestión de usuarios. Este script se utiliza para mostrar la tabla de usuarios y realizar operaciones como bloquear/desbloquear y actualizar.

* usuarios.php: muestra un listado de usuarios. Se encarga de mostrar un listado de usuarios almacenados en la base de datos.

### Crud pedidos

* pedidos.php: se utiliza para la actualización de pedidos en el sistema.

* crearPedidos.php: creación de nuevos pedidos en el sistema 

* entregas.php: muestra la tabla de entregas en el sistema

* distribuciones.php: se utiliza para la actualización de distribuciones en el sistema.



### Crud lockers

* actualizarLockers.php: actualiza los lockers en el sistema

* crearLockers.php: habilita nuevos lockers en el sistema

* lockers: muestra una tabla con la información de los lockers

## Instrucciones de Uso

### Requisitos Previos:

1. Asegúrate de tener un servidor web configurado con soporte para PHP y una base de datos MySQL. En este sentido, se recomienda utilizar [XAMPP], que proporciona un entorno de desarrollo local que incluye Apache, MySQL, PHP y phpMyAdmin, facilitando la configuración y gestión del entorno de desarrollo.


2. Importa la estructura de la base de datos desde el archivo SQL proporcionado en la carpeta baseDatos (drogoDB.sql).

### Configuración de la Base de Datos:

1. Descargar e Instalar XAMPP:

* Asegúrate de tener XAMPP instalado en tu sistema. XAMPP proporciona un entorno de desarrollo local que incluye Apache, MySQL, PHP y phpMyAdmin.

2. Importar la Base de Datos:

* Abre phpMyAdmin desde el panel de control de XAMPP (http://localhost/phpmyadmin).
 
* Crea una nueva base de datos llamada drogodb.
 
* Selecciona la base de datos recién creada y haz clic en la pestaña "Importar".
 
* Sube el archivo SQL proporcionado (drogodb.sql) para importar la estructura y los datos.

3. Configurar Conexión a la Base de Datos:

* Abre el archivo includes/config/database.php en tu editor de texto.

* Recuerda modificar los credenciales de conexión si son diferentes a las predeterminadas de XAMPP para poder acceder a la base de datos.

* Registro de usuarios: los usuarios clientes se registran y loguean desde registro.php y login.php, respectivamente; los clientes además deberán aportar un hash de cartera en registro2.php, a donde serán llevados una vez hayan aportado sus datos de registro generales.

* Logueo de admin: Primero debemos ir al login.php e introducir como usuario "admin" y contraseña "1234", eso nos llevará a loginAdmin.php. Ahí debemos iniciar sesión con el usuario "admin" y contraseña "admin". Este es el usuario administrador que esta en la base de datos. Desde ahí el administrador será llevado al área personal de administradores, donde ejercerá funciones específicas acordes a su posición. El administrador es dado de alta de manera interna por el equipo, ya que es un empleado de la empresa, no puede crearse un administrador desde el registro de la página.

### Explicación de la base de datos

#### Usuarios
En la base de datos hay 8 usuarios normales y un administrador. Los usuarios normales son dos compradores (Aaron y Javier), dos vendedores (Eliazar y Oscar) y dos distribuidores (Cristina e Ismael), todos tienen la misma contraseña '1234'. El admin tiene nombre de usuario 'admin' y contraseña 'admin'. Este para loguearse debe acceder al login normal e introducir como nombre de usuario 'admin' y contraseña '1234', esto te redirigirá al login del admin donde ya te logueas con las credenciales de la base de datos.

#### Pedidos
Además de los usuarios tambien se añadieron pedidos para todos los usuarios, de forma que según el usuario con el que hagas login te aparecerán unos pedidos u otros. El administrador puede ver todos los pedidos.En el caso de ser usuario distribuidor no puede ver los pedidos, solo las distribuciones asociadas a su ID.

## Autoría
Este proyecto fue desarrollado por @acurro9, @EliazarAS7 y @csdaria

## Licencia
Proyecto elaborado para fines educativos para la asignatura Desarrollo Web en Entorno Servidor de segundo del CFGS de Desarrollo de Aplicaciones Web en el IES Ana Luisa Benítez.
