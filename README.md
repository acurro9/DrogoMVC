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
   2. [Controllers](#controllers)
   3. [Includes](#includes)
   4. [Models](#models)
   5. [Public](#public)
   6. [Views](#views)
5. [Instrucciones de Uso](#instrucciones-de-uso)
   1. [Requisitos Previos](#requisitos-previos)
   2. [Configuración de la Base de Datos](#configuración-de-la-base-de-datos)
   3. [Explicación de la Base de Datos](#explicación-de-la-base-de-datos)
   4. [Registro y Login](#registro-y-login)
   5. [Sección de Admin](#sección-de-admin)
   6. [Crud Lockers](#crud-lockers)
   7. [Crud Usuarios](#crud-usuarios)
   8. [Crud Pedidos](#crud-pedidos)
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

El proyecto de PHP se ha desarrollado siguiendo los principios de la Programación Orientada a Objetos (POO), haciendo uso de patrones de diseño como Active Record y Model-View-Controller (MVC) para garantizar una estructura clara y mantenible del código. La gestión de dependencias y la carga automática de clases se manejan a través de Composer, lo que facilita la integración de bibliotecas externas y mejora la organización del proyecto mediante el uso de namespaces. Esto nos permite ahorrar código y aumentar la eficiencia en el desarrollo, al evitar la necesidad de incluir manualmente los archivos de clases y permitir una estructura de proyecto más modular.

### Estructura general

#### Controllers

Actúan como intermediarios entre los modelos y las vistas para recibir las solicitudes del usuario y procesarlos con el objetivo de enviar los datos a las vistas que mostrarán la información especificada por el usuario.

Entre los mismos podemos encontrar aquellos de la clase Usuarios, englobando también los procesos de registro y login en la plataforma:

**UsuariosController.php**

**LoginController.php**

**RegistroController.php**

Los de las páginas generales, a las cuales no hace falta loguearse para realizar acciones:

**PaginasController.php**

**NewsletterController.php**

Además, existe uno de contacto, a través del cual el administrador gestiona las consultas a través del formulario:

**ContactoController.php**

y aquellos pertenecientes a los modelos de envío y lockers:

**EnvioController.php**

**LockersController.php**

#### Includes

El directorio includes incluye:

1. **/config/database.php**: directorio de configuración con la conexión a la base de datos en PDO.
2. **funciones.php**: archivo que contiene funciones comunes utilizadas en varias partes del proyecto para mejorar la modularidad y el mantenimiento del código.
3. **app.php**: inicializa la aplicación cargando dependencias con Composer, estableciendo la conexión a la base de datos mediante conectarDB(), y configurando el patrón Active Record para el manejo de modelos con la base de datos. Con ello, se facilita la integración de bibliotecas y la gestión de la base de datos, simplificando el desarrollo, conectando componentes clave y preparando el entorno de ejecución.
4. **templates**: incluye todos los formularios y todas las tablas del proyecto que luego se referenciarán en las vistas mediante rutas donde corresponda, facilitando el mantenimiento y la reutilización del código empleado.
5. **paginado.php**: permite al usuario seleccionar la cantidad de productos a mostrar por página a través de un menú desplegable, con opciones de 3, 5, 10 o 20 productos, y enviar la selección mediante un botón de envío.

#### Models

Equivalentes a las clases en la POO, los modelos en el patrón MVC gestionan la lógica de negocio y el acceso a datos, sirviendo como puente entre la base de datos y el controlador.

**Clase Router**: gestiona las rutas de la aplicación, diferenciando entre solicitudes GET y POST a través de los arrays `$getRoutes` y `$postRoutes`. Con `comprobarRutas`, se determina la ruta actual y el método de solicitud, ejecutando la función asociada en caso de coincidencia. Por otro lado, `render` se encarga de la presentación, extrayendo los datos enviados a la vista y los encapsula dentro del layout especificado. Con esta estructura de enrutamiento se facilita la organización del flujo de navegación y la separación clara entre la lógica de procesamiento y la presentación visual en la aplicación.

**ActiveRecord**: implementa el patrón de diseño Active Record en PHP, facilitando la interacción con la base de datos mediante operaciones CRUD de manera orientada a objetos. Principales características:

- **Conexión a la Base de Datos**: Utiliza `setDB` para compartir una conexión a la base de datos entre todas las instancias de clases derivadas de `ActiveRecord`.

- **Manejo de Errores**: A través de `getErrores`, gestiona y proporciona acceso a los errores de validación.

- **Operaciones CRUD**: Incluye métodos para crear (`crear`), leer (`all`, `find`, `get`), actualizar (`actualizar`), y eliminar (`eliminar`) registros, adaptándose automáticamente a las especificaciones de las clases hijas.

- **Validación**: El método `validar` permite la implementación de validaciones personalizadas para asegurar la integridad de los datos.

- **Consulta y Manipulación de Datos**: Métodos como `consultarSQL` y `crearObjeto` facilitan la ejecución de consultas personalizadas y la instanciación de objetos a partir de resultados de consultas, respectivamente.

- **Sanitización de Atributos**: Previene inyecciones SQL y otros problemas de seguridad sanitizando atributos antes de cualquier operación en la base de datos.

- **Sincronización de Datos**: `sincronizar` actualiza los atributos del objeto con nuevos valores, facilitando la gestión de formularios y actualizaciones de datos.

#### Descripción General de los modelos específicos

Todos los modelos (`Contacto`, `Envio`, `Locker`, `Newsletter`, `Pedido`, `Usuario`) heredan de `ActiveRecord`, compartiendo funcionalidades como conexión a la base de datos y operaciones CRUD. Representan tablas en la base, con `protected static $tabla` y `protected static $columnasDB` definiendo su estructura en la base de datos, facilitando la manipulación de datos.

##### Diferencias Clave

- **Contacto**: gestiona datos de contacto, con métodos para conteo y paginación específicos a contactos.

- **Envio**: rnfocado en la gestión de envíos, incluye detalles como distribuidor, fechas de recogida/deposito y referencias a lockers, con validaciones específicas.

- **Locker**: maneja lockers para paquetes, incluyendo métodos para contar y paginar lockers, y validaciones para dirección y contraseña.

- **Newsletter**: administra suscripciones a boletines, trabajando con direcciones de correo y proporcionando funcionalidades para conteo y paginación de suscriptores.

- **Pedido**: gestiona pedidos, con información sobre compradores, vendedores y transacciones, y validaciones para garantizar la integridad de la información del pedido.

- **Usuario**: encargado de la gestión de usuarios, incluye autenticación, registro, actualización de datos, y métodos para el manejo de permisos y validaciones de datos de usuario.

Cada modelo está diseñado para satisfacer necesidades específicas dentro de la aplicación, manteniendo la lógica de negocio organizada y modular.

#### Directorio public

La carpeta `public` de nuestro proyecto actúa como el punto de entrada para los usuarios, conteniendo el archivo `index.php` que inicializa la aplicación y un directorio `build` para el front-end. Dentro de `build`, se organizan los archivos estáticos como CSS, JavaScript, e imágenes, esenciales para el diseño y funcionalidad de la interfaz de usuario; el `index.php`, por otro lado, configura las dependencias, inicia el enrutador (`Router`) y define las rutas hacia distintos controladores (`Controllers`), gestionando así las solicitudes y respuestas dentro del patrón MVC. Este diseño separa claramente la lógica de presentación del manejo de la lógica de negocio, promoviendo una estructura organizada y modular para el desarrollo web.

#### Views

Incluye todas las vistas a la que tiene acceso el usuario. Además, el archivo en la carpeta `views` sirve como plantilla base para el contenido generado dinámicamente en la aplicación, incorporando un diseño consistente en todas las páginas. Inicia sesión automáticamente si no existe una previa, y determina si el usuario está autenticado para mostrar contenido personalizado en la barra de navegación. La estructura incluye un encabezado con enlaces de navegación, un área condicional para usuarios autenticados con opciones específicas según el tipo de usuario (Administrador o Usuario regular), y un pie de página con información de contacto y un formulario de suscripción al newsletter. Los recursos estáticos para el estilo y la funcionalidad (CSS y JavaScript) se cargan desde la carpeta `build`, asegurando una experiencia de usuario coherente y atractiva.

La subdivisión de las vistas se realiza en función de los siguientes apartados:

### Páginas generales

- index.php: página principal del sitio web (index). En esta página, se muestra información principal sobre el servicio de envío anónimo, destacando la privacidad y confidencialidad que ofrece Drogo. Además, incluye secciones sobre la garantía de privacidad y enlaces a servicios adicionales.

- datos.php: página para modificar datos del usuario; permite al usuario modificar información como nombre de usuario, dirección de correo electrónico, contraseña y cartera.

- equipo.php: página para visualizar al equipo de la empresa. En esta página se muestra información sobre los miembros del equipo, incluyendo sus roles, experiencia y contribuciones a la empresa.

- form-contacto.php: página para mostrar un formulario de contacto. Así, los usuarios pueden completar un formulario de contacto, proporcionando información como nombre, correo electrónico, teléfono y mensaje. La información ingresada se procesa y se valida antes de ser enviada.

- preguntas-frecuentes.php: página que presenta una lista de preguntas frecuentes y respuestas para proporcionar a los usuarios información detallada sobre el funcionamiento de Drogo.

- servicios.php: página que detalla los diversos servicios ofrecidos por Drogo, desde envío y recepción de paquetes hasta servicios de almacenamiento temporal y gestión de envíos internacionales.

### Auth: registro y login

- registro.php: formulario de registro de nuevos usuarios con validación de datos para garantizar la integridad de la información ingresada.

- registro2.php: página para completar el proceso de registro, incluyendo la información de la cartera del usuario; se utiliza para finalizar la creación de la cuenta.

- login.php: página de inicio de sesión para usuarios registrados, donde los usuarios pueden acceder a sus cuentas proporcionando credenciales válidas.

- loginAdmin.php: página para realizar el inicio de sesión del administrador. En esta página, se procesa el formulario de inicio de sesión del administrador, se verifica la identidad del usuario y se manejan los errores. Además, se incluye el encabezado, se conecta a la base de datos y se generan mensajes de error si es necesario. Finalmente, se presenta el formulario de inicio de sesión del administrador.

### Sección de admin

- usuario.php: página para la visualización y gestión de usuarios. Este script se utiliza para mostrar la tabla de usuarios y realizar operaciones como bloquear/desbloquear y actualizar.

- contacto.php: página para la visualización y gestión de las peticiones hechas en los formularios. Muestra una página de contacto con estilos específicos, permite al usuario seleccionar el número de mensajes a visualizar por página mediante un formulario, muestra los mensajes en una tabla importada y ofrece paginación para navegar entre diferentes páginas de mensajes.

- newsletter.php: carga estilos específicos, muestra un formulario para seleccionar la cantidad de entradas por página y presenta una tabla con emails suscritos al newsletter, permitiendo borrar suscripciones individuales mediante formularios específicos, todo acompañado de paginación para explorar eficientemente las suscripciones.

### Crud lockers

- actualizarLockers.php: actualiza los lockers en el sistema

- crearLockers.php: habilita nuevos lockers en el sistema

- lockers: muestra una tabla con la información de los lockers

### Crud Usuarios

- areaPersonal.php: página del área personal del usuario común. Este script PHP se encarga de mostrar el área personal del usuario común, proporcionando opciones y detalles específicos del usuario.

- areaPersonalAdmin.php: página del área personal del administrador; se encarga de mostrar el área personal del administrador, proporcionando opciones y detalles específicos del administrador.

- bloquearUsuario.php: página para bloquear o desbloquear usuarios; permite a un administrador bloquear o desbloquear usuarios a través de formularios de búsqueda y acciones correspondientes.

- modDatos.php: página que permite a los usuarios modificar información personal almacenada en la plataforma, como cambiar la contraseña o actualizar la dirección de correo electrónico.

- actualizarUsuario.php: página para la actualización de usuarios; se utiliza para actualizar la información de un usuario en el sistema

### Crud pedidos

- crearPedidos.php: creación de nuevos pedidos en el sistema

- pedidos.php: se utiliza para la visualización de pedidos (sin distribuidor) en el sistema.

- envio.php: se utiliza para la visualización de distribuciones (pedidos con distribuidor) en el sistema

- actualizarEnvio.php: se utiliza para la actualización de envíos en el sistema, es decir, de pedidos con distribución

- actualizarPedido.php: se utiliza para la actualización de pedidos en el sistema, es decir, de pedidos sin distribución

## Instrucciones de Uso

### Requisitos Previos:

1. Asegúrate de tener un servidor web configurado con soporte para PHP y una base de datos MySQL. En este sentido, se recomienda utilizar [XAMPP], que proporciona un entorno de desarrollo local que incluye Apache, MySQL, PHP y phpMyAdmin, facilitando la configuración y gestión del entorno de desarrollo.

2. Importa la estructura de la base de datos desde el archivo SQL proporcionado en la carpeta baseDatos (drogoDB.sql).

3. Para visualizar las páginas, hay que ejecutar `php -S localhost:<puerto>` desde el directorio `public` del proyecto, reemplazando `<puerto>` con el número de puerto que se desea utilizar. Por ejemplo, para usar el puerto 3000, el comando sería `php -S localhost:3000`.

### Configuración de la Base de Datos:

1. Descargar e Instalar XAMPP:

- Asegúrate de tener XAMPP instalado en tu sistema. XAMPP proporciona un entorno de desarrollo local que incluye Apache, MySQL, PHP y phpMyAdmin.

2. Importar la Base de Datos:

- Abre phpMyAdmin desde el panel de control de XAMPP (http://localhost/phpmyadmin).

- Crea una nueva base de datos llamada drogodb.

- Selecciona la base de datos recién creada y haz clic en la pestaña "Importar".

- Sube el archivo SQL proporcionado (drogodb.sql) para importar la estructura y los datos.

3. Configurar Conexión a la Base de Datos:

- Abre el archivo includes/config/database.php en tu editor de texto.

- Recuerda modificar los credenciales de conexión si son diferentes a las predeterminadas de XAMPP para poder acceder a la base de datos.

- Registro de usuarios: los usuarios clientes se registran y loguean desde registro.php y login.php, respectivamente; los clientes además deberán aportar un hash de cartera en registro2.php, a donde serán llevados una vez hayan aportado sus datos de registro generales.

- Logueo de admin: Primero debemos ir al login.php e introducir como usuario "admin" y contraseña "1234", eso nos llevará a loginAdmin.php. Ahí debemos iniciar sesión con el usuario "admin" y contraseña "admin". Este es el usuario administrador que esta en la base de datos. Desde ahí el administrador será llevado al área personal de administradores, donde ejercerá funciones específicas acordes a su posición. El administrador es dado de alta de manera interna por el equipo, ya que es un empleado de la empresa, no puede crearse un administrador desde el registro de la página.

### Explicación de la base de datos

#### Usuarios

En la base de datos hay 8 usuarios normales y un administrador. Los usuarios normales son dos compradores (Aaron y Javier), dos vendedores (Eliazar y Oscar) y dos distribuidores (Cristina e Ismael), todos tienen la misma contraseña '1234'. El admin tiene nombre de usuario 'admin' y contraseña 'admin'. Este para loguearse debe acceder al login normal e introducir como nombre de usuario 'admin' y contraseña '1234', esto te redirigirá al login del admin donde ya te logueas con las credenciales de la base de datos.

#### Pedidos

Además de los usuarios tambien se añadieron pedidos para todos los usuarios, de forma que según el usuario con el que hagas login te aparecerán unos pedidos u otros. El administrador puede ver todos los pedidos.En el caso de ser usuario distribuidor no puede ver los pedidos, solo las distribuciones asociadas a su ID.

## Autoría

Este proyecto fue desarrollado por @acurro9, @EliazarAS7 y @csdaria

## Licencia

Proyecto elaborado para fines educativos para la asignatura Desarrollo Web en Entorno Servidor de segundo del CFGS de Desarrollo de Aplicaciones Web en el IES Ana Luisa Benítez.
