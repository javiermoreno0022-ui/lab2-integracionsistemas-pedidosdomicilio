Sistema de Pedidos a Domicilio — Lab II

Sistema web para la gestión de pedidos a domicilio, desarrollado como continuación del proyecto realizado en el Laboratorio I de Integración de Sistemas.

En esta segunda etapa, el proyecto fue migrado de PHP nativo a Laravel, incorporando un CRUD completo de pedidos, formularios con validación, autenticación de usuarios, manejo de sesiones y aislamiento de información por usuario.

1. Descripción del proyecto

El Sistema de Pedidos a Domicilio permite registrar, consultar, actualizar y eliminar pedidos realizados por los clientes.

Cada usuario registrado en el sistema puede administrar únicamente sus propios pedidos. Para ello, el sistema utiliza autenticación y una relación entre usuarios y pedidos mediante user_id.

El proyecto corresponde a la segunda etapa del desarrollo realizado en el Laboratorio I, conservando el historial del repositorio original y evolucionando la aplicación hacia una arquitectura basada en Laravel y Eloquent ORM.

2. Integrantes del equipo
Carné	Integrante
- MN-64016-23	Francisco Javier Moreno Navas
- PG-64792-23	Alexander Maximiliano Pérez García
- CL-64224-24	Aaron Steven Cabrera López
- CD-64257-23	Denys Ezequiel Córdova Domínguez

Los porcentajes representan la participación individual de cada integrante durante el desarrollo del proyecto y fueron acordados por el equipo.

3. Tecnologías utilizadas
PHP 8.4.23
Laravel 13.34.0
Composer 2.10.2
MySQL
Blade
Eloquent ORM
HTML5
CSS
JavaScript/Vite
Git
GitHub

4. Funcionalidades principales
Autenticación de usuarios

El sistema permite:

Registrar nuevos usuarios.
Iniciar sesión.
Cerrar sesión.
Mantener la sesión activa.
Proteger las rutas privadas mediante middleware auth.
Regenerar la sesión después del inicio de sesión.
Invalidar la sesión al cerrar sesión.
Gestión de pedidos

Cada usuario puede:

Registrar pedidos.
Consultar sus pedidos.
Consultar el detalle de un pedido.
Editar pedidos.
Actualizar el estado de un pedido.
Eliminar pedidos.
Estados disponibles

Los pedidos pueden tener los siguientes estados:

Pendiente
Preparando
En camino
Entregado
Cancelado
Validación

Los formularios utilizan Form Requests para validar los datos antes de almacenarlos o actualizarlos.

Entre las validaciones implementadas se encuentran:

Campos obligatorios.
Longitud máxima de texto.
Cantidad mínima de productos.
Valores numéricos.
Valores válidos para el estado.
Valores monetarios.
Fecha válida.

Los errores de validación se muestran directamente en las vistas Blade.

Protección de formularios

Los formularios utilizan protección CSRF mediante la directiva:

@csrf

Para las operaciones de actualización y eliminación también se utilizan los métodos HTTP correspondientes mediante:

@method('PUT')

y

@method('DELETE')

5. Aislamiento de información por usuario

Una de las funcionalidades principales del Laboratorio II es garantizar que cada usuario solamente pueda administrar sus propios pedidos.

La relación implementada es:

User
  │
  └── hasMany
          │
          ▼
        Pedido

Cada pedido posee un user_id que identifica al usuario propietario.

En el controlador, las consultas se realizan utilizando la relación del usuario autenticado:

auth()->user()->pedidos()

De esta manera, un usuario no puede consultar, modificar o eliminar pedidos pertenecientes a otro usuario.

Por ejemplo, si un usuario intenta acceder directamente a un pedido que pertenece a otra cuenta, el sistema no lo encuentra y devuelve una respuesta 404.

6. Estructura principal

La estructura relevante del proyecto es:

lab2-pedidosdomicilio/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   └── PedidoController.php
│   │   │
│   │   └── Requests/
│   │       ├── StorePedidoRequest.php
│   │       └── UpdatePedidoRequest.php
│   │
│   └── Models/
│       ├── Pedido.php
│       └── User.php
│
├── database/
│   └── migrations/
│       └── create_pedidos_table.php
│
├── resources/
│   └── views/
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       │
│       ├── layouts/
│       │   └── app.blade.php
│       │
│       └── pedidos/
│           ├── index.blade.php
│           ├── create.blade.php
│           ├── show.blade.php
│           └── edit.blade.php
│
├── routes/
│   └── web.php
│
├── public/
├── config/
├── tests/
├── composer.json
├── composer.lock
├── package.json
├── phpunit.xml
└── artisan

7. Base de datos

El proyecto utiliza MySQL como sistema gestor de base de datos.

La tabla principal creada para el Laboratorio II es:

pedidos
Campo	Descripción
id	Identificador del pedido
user_id	Usuario propietario del pedido
cliente	Nombre del cliente que recibe el pedido
telefono	Teléfono del cliente
direccion	Dirección de entrega
producto	Producto solicitado
cantidad	Cantidad solicitada
total	Total del pedido
estado	Estado actual del pedido
costo_express	Costo adicional del servicio express
fecha_pedido	Fecha del pedido
created_at	Fecha de creación
updated_at	Fecha de actualización

La columna user_id mantiene la relación entre cada pedido y el usuario propietario.

8. Modelo de datos

La relación principal del sistema es de uno a muchos:

┌──────────────┐
│     User     │
├──────────────┤
│ id           │
│ name         │
│ email        │
│ password     │
└──────┬───────┘
       │
       │ 1:N
       │
       ▼
┌──────────────┐
│    Pedido    │
├──────────────┤
│ id           │
│ user_id      │
│ cliente      │
│ telefono     │
│ direccion    │
│ producto     │
│ cantidad     │
│ total        │
│ estado       │
│ costo_express│
│ fecha_pedido │
└──────────────┘

9. Rutas principales
Autenticación
GET   /register
POST  /register

GET   /login
POST  /login

POST  /logout
Pedidos

El sistema utiliza las rutas RESTful de Laravel mediante:

Route::resource('pedidos', PedidoController::class);

Esto genera las operaciones:

GET      /pedidos
GET      /pedidos/create
POST     /pedidos
GET      /pedidos/{pedido}
GET      /pedidos/{pedido}/edit
PUT      /pedidos/{pedido}
DELETE   /pedidos/{pedido}

Las rutas de pedidos se encuentran protegidas mediante:

Route::middleware('auth')->group(function () {
    // ...
});

10. Instalación y configuración
Requisitos

Antes de ejecutar el proyecto, es necesario tener instaladas las siguientes herramientas:

PHP 8.4 o una versión compatible con Laravel 13.
Composer, para administrar las dependencias de PHP.
MySQL, como sistema gestor de base de datos.
Node.js y npm, para instalar las dependencias del frontend.
Git, para clonar el repositorio.

También se recomienda utilizar un entorno de desarrollo como Laravel Herd, XAMPP u otro entorno compatible.

Paso 1. Clonar el repositorio

Abrir una terminal en la carpeta donde se desea guardar el proyecto y ejecutar:

git clone -b lab2 https://github.com/javiermoreno0022-ui/lab2-integracionsistemas-pedidosdomicilio.git

Ingresar a la carpeta del proyecto:

cd lab2-integracionsistemas-pedidosdomicilio

El repositorio contiene el desarrollo del Sistema de Pedidos a Domicilio para el Laboratorio II, basado en Laravel y como continuación del trabajo realizado en el Laboratorio I.

Paso 2. Instalar las dependencias de PHP

Ejecutar:

composer install

Este comando instala las dependencias definidas en composer.json y composer.lock.

Paso 3. Instalar las dependencias del frontend

Ejecutar:

npm install
Paso 4. Configurar el archivo .env

Crear el archivo de configuración local a partir del ejemplo incluido en el repositorio.

En Windows PowerShell:

Copy-Item .env.example .env

En Linux o macOS:

cp .env.example .env

Abrir el archivo .env y configurar las credenciales de conexión a MySQL.

Ejemplo:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pedidos_domicilio
DB_USERNAME=root
DB_PASSWORD=

Los valores de usuario y contraseña deben ajustarse al entorno local de cada integrante. La base de datos pedidos_domicilio debe existir previamente en MySQL.

Paso 5. Generar la clave de la aplicación

Ejecutar:

php artisan key:generate

Este comando genera la clave de cifrado que Laravel utiliza para la aplicación local.

Paso 6. Ejecutar las migraciones

Ejecutar:

php artisan migrate

Este comando crea las tablas definidas en las migraciones del proyecto, incluida la tabla pedidos.

Paso 7. Iniciar la aplicación

Ejecutar:

php artisan serve

Abrir en el navegador:

http://127.0.0.1:8000

Para acceder directamente al módulo de pedidos, utilizar:

http://127.0.0.1:8000/pedidos

Nota: si la aplicación utiliza autenticación, será necesario iniciar sesión para acceder a las rutas protegidas.

11. Flujo de uso

El flujo principal del sistema es:

Inicio
  │
  ├── Registrarse
  │      │
  │      ▼
  │   Crear cuenta
  │      │
  │      ▼
  └── Iniciar sesión
         │
         ▼
     Mis pedidos
         │
         ├── Registrar pedido
         │
         ├── Ver pedido
         │
         ├── Editar pedido
         │
         └── Eliminar pedido

Cada usuario trabaja únicamente con los pedidos asociados a su cuenta.

12. Pruebas realizadas

Durante el desarrollo se realizaron pruebas funcionales de:

Autenticación
Registro de usuario.
Inicio de sesión.
Cierre de sesión.
Acceso protegido a /pedidos.
Redirección al login cuando no existe una sesión.
Validación

Se verificó el comportamiento de los formularios cuando:

Se dejan campos obligatorios vacíos.
Se introducen cantidades inválidas.
Se introducen valores numéricos incorrectos.
Las contraseñas no coinciden.
Se intenta registrar un correo electrónico ya existente.
CRUD

Se verificaron las operaciones:

Crear.
Consultar.
Mostrar detalle.
Actualizar.
Eliminar.
Aislamiento de datos

Se probaron dos usuarios diferentes.

El usuario A puede visualizar sus propios pedidos, mientras que el usuario B no puede acceder a los pedidos pertenecientes al usuario A.

También se verificó el acceso directo a un pedido de otro usuario, obteniendo una respuesta 404, demostrando el aislamiento implementado.

13. Relación con el Laboratorio I

Este proyecto representa la evolución del Sistema de Pedidos a Domicilio desarrollado originalmente en PHP nativo durante el Laboratorio I.

En el Laboratorio I se trabajó principalmente con:

PHP nativo.
Programación Orientada a Objetos.
Herencia.
Interfaces.
Namespaces.
Composer.
PDO.
Operaciones CRUD.

En el Laboratorio II se utiliza Laravel para incorporar:

Arquitectura MVC.
Rutas.
Controladores.
Eloquent ORM.
Migraciones.
Relaciones entre modelos.
Blade.
Form Requests.
Validación.
Autenticación.
Sesiones.
Aislamiento de datos por usuario.

El repositorio conserva el historial anterior para evidenciar la evolución incremental del proyecto.

14. Seguridad implementada

El proyecto incorpora diferentes mecanismos de seguridad proporcionados por Laravel:

Autenticación mediante Auth.
Middleware auth.
Protección CSRF.
Regeneración de sesión después del inicio de sesión.
Invalidación de sesión al cerrar sesión.
Contraseñas almacenadas mediante hashing.
Validación de datos de entrada.
Restricción de acceso a pedidos según el usuario autenticado.

15. Estado actual del proyecto

El proyecto cuenta con:

CRUD completo de pedidos.
Formularios Blade.
Validaciones mediante Form Requests.
Protección CSRF.
Autenticación.
Registro de usuarios.
Inicio y cierre de sesión.
Manejo de sesiones.
Relación User → Pedido.
Aislamiento de pedidos por usuario.
Estados de pedido.
Migraciones de base de datos.
Eloquent ORM.
Rutas protegidas.
Mensajes de confirmación.
Manejo de errores de validación.

16. Nota sobre uso de IA

Durante el desarrollo del proyecto se utilizaron herramientas de Inteligencia Artificial como apoyo para comprender conceptos, revisar código, identificar errores y mejorar la documentación.

El código fue revisado, adaptado y probado por el equipo de acuerdo con los requerimientos del proyecto y las pruebas realizadas localmente.

17. Licencia

Proyecto académico desarrollado para la asignatura Integración de Sistemas.

No está destinado a uso comercial.
