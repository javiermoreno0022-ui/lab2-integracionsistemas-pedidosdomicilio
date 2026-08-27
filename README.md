- Sistema de Pedidos a Domicilio

- Integrantes

Francisco Javier Moreno Navas: MN-64016-23

Alexander Maximiliano Pérez García: PG-64792-23

Aaron Steven Cabrera López: CL-64224-24

Denys Ezequiel Córdova Domínguez: CD-64257-23

- Descripción del proyecto

Descripción del proyecto

El Sistema de Pedidos a Domicilio es una aplicación desarrollada en PHP nativo que permite gestionar pedidos mediante un sistema CRUD desde un menú de consola.

El sistema permite registrar, listar, buscar, actualizar y eliminar pedidos. Además, aplica conceptos de Programación Orientada a Objetos (POO) como encapsulamiento, herencia e interfaces.

El proyecto contempla pedidos Normales y Express. Los pedidos Express utilizan la clase PedidoExpress, que hereda de Pedido y agrega el comportamiento relacionado con el costo adicional del envío.

- Tecnologías utilizadas

PHP 8.2
MySQL
PDO
Composer
Programación Orientada a Objetos
Namespaces
Autoload PSR-4
Git
GitHub

- Requisitos

Para ejecutar el proyecto localmente se necesita:

PHP 8.2 o superior
MySQL
XAMPP u otro servidor local compatible
Composer
Git

- Instalación

1. Clonar el repositorio

Clonar el repositorio desde GitHub dentro de la carpeta correspondiente del servidor local.

2. Instalar las dependencias

Desde la carpeta raíz del proyecto ejecutar:

composer install

Este comando instala las dependencias definidas en Composer y genera el autoload necesario para utilizar las clases mediante PSR-4.

3. Configurar la base de datos

Crear la base de datos MySQL correspondiente al proyecto e importar el archivo:

pedidos_domicilio.sql

El archivo contiene la estructura necesaria para crear la tabla utilizada por el sistema.

Verificar que los datos de conexión configurados en:

src/BaseDatos/Conexion.php

correspondan al entorno local.

4. Ejecutar el proyecto

Desde la carpeta raíz del proyecto ejecutar:

php index.php

El sistema mostrará el menú principal en la consola.

- Funcionalidades

El sistema cuenta con las siguientes operaciones:

1. Registrar pedido

Permite registrar un nuevo pedido ingresando:

Cliente
Teléfono
Dirección
Producto
Cantidad
Total
Tipo de envío
Costo Express
Estado

2. Listar pedidos

Permite visualizar los pedidos registrados en la base de datos.

La información mostrada incluye los datos principales del pedido y permite diferenciar los pedidos normales de los pedidos Express.

3. Buscar pedido

Permite consultar un pedido específico utilizando su ID.

4. Actualizar pedido

Permite modificar los datos de un pedido existente.

También permite seleccionar entre pedido Normal y Express y establecer el costo correspondiente para el envío Express.

5. Eliminar pedido

Permite eliminar un pedido utilizando su ID.

Antes de realizar la eliminación, el sistema solicita una confirmación al usuario.

- Organización del proyecto

La aplicación utiliza namespaces y autoload PSR-4 mediante Composer.

src/ 
├── BaseDatos/ 
│     └── Conexion.php 
|
│ ├── Controladores/ 
│     └── PedidoController.php 
|
│ ├── Interfaces/ 
│     └── Entregable.php 
|
│ ├── Modelos/ 
│     ├── Pedido.php 
│     └── PedidoExpress.php 
|
└── Repositorios/ 
      └── PedidoRepository.php

En la raíz del proyecto también se encuentran archivos importantes como:

composer.json
composer.lock
index.php
pedidos_domicilio.sql

- Modelo

La clase Pedido representa la entidad principal del sistema.

Contiene las propiedades y métodos necesarios para representar y administrar la información de un pedido.

La clase PedidoExpress hereda de Pedido y agrega el comportamiento relacionado con los pedidos Express y su costo adicional de envío.

- Interfaz

La interfaz Entregable define el comportamiento relacionado con la entrega de pedidos.

La clase PedidoExpress implementa esta interfaz.

La relación principal de POO utilizada en el proyecto es:

Pedido
   ↑
   │ herencia
   │
PedidoExpress
   │
   └── implementa Entregable

- Controlador

La clase PedidoController coordina las operaciones solicitadas desde el menú.

El controlador recibe las acciones del usuario, realiza las validaciones correspondientes y comunica las operaciones al repositorio.

- Repositorio

La clase PedidoRepository se encarga de realizar las operaciones de persistencia sobre la base de datos.

Entre sus responsabilidades se encuentran:

Crear pedidos.
Listar pedidos.
Buscar pedidos por ID.
Actualizar pedidos.
Eliminar pedidos.

Las operaciones de acceso a datos se realizan mediante PDO y consultas preparadas.

- Conexión a la base de datos

La clase Conexion.php administra la conexión con MySQL utilizando PDO.

La conexión utiliza el juego de caracteres utf8mb4 y permite que los repositorios ejecuten consultas sobre la base de datos pedidos_domicilio.

- Programación Orientada a Objetos

El proyecto aplica los siguientes conceptos de Programación Orientada a Objetos:

Clases.
Objetos.
Encapsulamiento.
Constructores.
Getters y setters.
Herencia.
Interfaces.
Métodos propios de las clases.
Namespaces.

La herencia se implementa mediante:

Pedido
   ↑
PedidoExpress

Mientras que la interfaz se implementa mediante:

Entregable
     ↑
PedidoExpress

- Persistencia con PDO

La persistencia de información se realiza mediante PDO.

Las operaciones que reciben información del usuario utilizan consultas preparadas y parámetros, evitando la concatenación directa de valores dentro de las consultas SQL.

Esto permite realizar las operaciones CRUD de una manera más segura y organizada.

- Validaciones

El sistema realiza validaciones sobre los datos ingresados por el usuario.

Entre ellas se incluyen:

Validación de datos obligatorios.
Validación de cantidades.
Validación de valores numéricos.
Validación de opciones del menú.
Confirmación antes de eliminar un pedido.
Mensajes de error y confirmación.

- Pruebas

Durante el desarrollo se realizaron pruebas de las principales funcionalidades del sistema, incluyendo:

Prueba de conexión PHP ↔ MySQL.
Registro de pedidos.
Listado de pedidos.
Búsqueda de pedidos.
Actualización de pedidos.
Eliminación de pedidos.
Validaciones.
Funcionamiento de las clases y relaciones de POO.

También se incluyen archivos de prueba para verificar algunas operaciones de manera independiente.

- Uso de herramientas de IA

Uso de herramientas de IA

Durante el desarrollo del proyecto se utilizaron herramientas de inteligencia artificial como apoyo para revisar código, detectar errores, mejorar la organización de algunas partes del proyecto y proponer posibles soluciones durante el proceso de desarrollo.

Las sugerencias obtenidas mediante estas herramientas fueron revisadas, adaptadas y probadas por los integrantes del equipo antes de incorporarlas al proyecto.

Las decisiones finales de implementación, integración y pruebas del funcionamiento fueron realizadas y verificadas por el equipo.

- Ejecución para la demostración

Antes de ejecutar el proyecto se debe verificar que:

MySQL se encuentre funcionando.
La base de datos pedidos_domicilio esté creada.
PHP esté disponible desde la consola.
Composer esté instalado.
Las dependencias de Composer hayan sido instaladas.

Luego ejecutar desde la raíz del proyecto:

php index.php

El menú permitirá demostrar las principales operaciones del sistema:

Crear
Listar
Buscar
Editar
Eliminar

Durante la demostración también se pueden mostrar:

Las clases del sistema.
La herencia entre Pedido y PedidoExpress.
La implementación de la interfaz Entregable.
Las consultas preparadas con PDO.
La organización mediante namespaces.
El autoload PSR-4 de Composer.
Las validaciones implementadas.
La conexión con MySQL.
Autoría

- Proyecto académico desarrollado por:

Francisco Javier Moreno Navas

Alexander Maximiliano Pérez García

Aaron Steven Cabrera López

Denys Ezequiel Córdova Domínguez