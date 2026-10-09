Sistema de Pedidos a Domicilio — Lab II

Sistema web para la gestión de pedidos a domicilio, desarrollado como continuación del proyecto realizado en el Laboratorio I de Integración de Sistemas.

En esta segunda etapa, el proyecto fue migrado de PHP nativo a Laravel, incorporando un CRUD completo de pedidos, formularios con validación, autenticación de usuarios, manejo de sesiones y aislamiento de información por usuario.

1. Descripción del proyecto

El Sistema de Pedidos a Domicilio permite registrar, consultar, actualizar y eliminar pedidos realizados por los clientes.

Cada usuario registrado en el sistema puede administrar únicamente sus propios pedidos. Para ello, el sistema utiliza autenticación y una relación entre usuarios y pedidos mediante user_id.

El proyecto corresponde a la segunda etapa del desarrollo realizado en el Laboratorio I, conservando el historial del repositorio original y evolucionando la aplicación hacia una arquitectura basada en Laravel y Eloquent ORM.

2. Integrantes del equipo
Carné	Integrante
MN-64016-23	Francisco Javier Moreno Navas
PG-64792-23	Alexander Maximiliano Pérez García
CL-64224-24	Aaron Steven Cabrera López
CD-64257-23	Denys Ezequiel Córdova Domínguez

Participación del equipo
Integrante	Participación
Francisco Javier Moreno Navas	90%
Alexander Maximiliano Pérez García	80%
Aaron Steven Cabrera López	80%
Denys Ezequiel Córdova Domínguez	80%

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

Antes de ejecutar el proyecto se necesita tener instalado:

PHP 8.4 o compatible con Laravel 13.
Composer.
MySQL.
Node.js y npm.
Git.

También se recomienda utilizar un entorno de desarrollo como Laravel Herd, XAMPP u otro entorno compatible.

Paso 1. Clonar el repositorio
git clone https://github.com/javiermoreno0022-ui/lab2-integracionsistemas-pedidosdomicilio.git

Ingresar al proyecto:

cd lab2-integracionsistemas-pedidosdomicilio

El enlace anterior corresponde al repositorio del proyecto. La versión final del Laboratorio II conserva el historial del Laboratorio I.

Paso 2. Instalar dependencias PHP
composer install
Paso 3. Instalar dependencias frontend
npm install
Paso 4. Configurar el archivo .env

Copiar el archivo de ejemplo:

copy .env.example .env

En sistemas Linux/macOS:

cp .env.example .env

Configurar las credenciales de MySQL en .env.

Ejemplo:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pedidos_domicilio
DB_USERNAME=root
DB_PASSWORD=

La base de datos debe existir previamente en MySQL.

Paso 5. Generar la clave de la aplicación
php artisan key:generate
Paso 6. Ejecutar las migraciones
php artisan migrate

Esto crea las tablas necesarias de Laravel y la tabla pedidos.

Paso 7. Iniciar el servidor
php artisan serve

Después ingresar desde el navegador a:

http://localhost:8000
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

15. Control de versiones

El proyecto utiliza Git para controlar el desarrollo y conservar la evolución del sistema.

La estructura histórica principal corresponde a:

Lab I
  │
  ├── Initial commit
  │
  ├── Sistema de Pedidos a Domicilio
  │
  └── Integrar proyecto con repositorio de GitHub
           │
           ▼
        Lab II
           │
           └── Migrar proyecto de Lab I a Laravel
               e implementar Lab II

El historial permite identificar la transición del proyecto original en PHP nativo hacia la versión desarrollada con Laravel.

16. Estado actual del proyecto

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

17. Nota sobre uso de IA

Durante el desarrollo del proyecto se utilizaron herramientas de Inteligencia Artificial como apoyo para comprender conceptos, revisar código, identificar errores y mejorar la documentación.

El código fue revisado, adaptado y probado por el equipo de acuerdo con los requerimientos del proyecto y las pruebas realizadas localmente.

18. Licencia

Proyecto académico desarrollado para la asignatura Integración de Sistemas.

No está destinado a uso comercial.