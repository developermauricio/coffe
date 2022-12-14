<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Acerca del proyecto por Konecta

### 1. Descripción
KONECTA, necesita para unas de sus cafeterías que tiene en sede de un software, que permita almacenar y gestionar el inventario de sus productos. Este software debe permitir la creación de productos, la edición de los productos, la eliminación de productos y listar todos los productos registrados en el sistema.

Los datos que debe tener cada producto son:
- ID.
- Nombre de producto: OBLIGATORIO.
- Referencia: OBLIGATORIO.
- Precio: ENTERO OBLIGATORIO.
- Peso: ENTERO: OBLIGATORIO.
- Categoría: OBLIGATORIO.
- Stock, (Cantidad del producto en bodega) ENTERO: OBLIGATORIO.
- Fecha de creación: date OBLIGATORIO

Adicionalmente se debe contar con un módulo que permita realizar la venta de un producto, el cual recibirá el id del producto como parámetro y la cantidad del producto vendido. El software debe actualizará el campo de stock restando la cantidad del producto vendido y registrar en una tabla la venta realizada (si el producto no cuenta con stock mayor a cero debe mostrar un mensaje informando que no es posible realizar la venta).

Para finalizar se deben realizar 2 consultas directas en base de datos:
- Realizar una consulta que permita conocer cuál es el producto que más stock tiene.
- Realizar una consulta que permita conocer cuál es el producto más vendido.

### 2. Condiciones
- El lenguaje de programación debe ser PHP.
- El motor de base de datos debe ser MYSQL.
- Recomendamos hacerlo en PHP nativo, pero se puede hacer uso de cualquier framework php
  que conozcas.
- Dispones de 24 horas, a partir del momento en que recibes la prueba, para enviar la solución.

### 3. Entrega
- Crear el archivo README con las consideraciones a tener en cuenta para la instalación y puesta en marcha de la prueba.
- Enviar el link del repositorio (Git, Github) o el enlace de descarga del código fuente y copia de la base de datos y las sentencias de las 2 consultas solicitadas.

## Descripción del proyecto desarrollado

Para este proyecto use como base de datos MySql; cree migraciones para cada una de las tablas y adicionalmente estoy usando "seeders" o semillas las cuales por medio de fakers creamos datos de prueba para llenar nuestra base de datos y trabajar el desarrollo con datos.
Para el frontend estoy usando Vuejs e implemente validaciones para crear y editar los productos. Para ver el [demo clic aquí](https://coffe.socket-aicode.art).

## Guía de Instalación
Para la instalación del proyecto, inicialmente debe tener instalado [compoeser](https://getcomposer.org/download/), y tener instalado [node js](https://nodejs.org/es/download/) para el uso del frontend.


#### Sobre la carpeta raíz del proyecto instalar composer:
```sh
$ composer install
```
#### Luego instala los paquetes node:
```sh
$ npm install
```
Crea la base de datos local y agrega el nombre de tu base de datos en el archivo .env del proyecto.
#### Luego ejecuta las migraciones y los datos semilla (seeders):
```sh
$ php artisan migrate:fresh --seed
```
#### Ejecuta el servidor de laravel:
```sh
$ php artisan serve
```
#### Compilar el proyecto en vue:
```sh
$ npm run dev
```
## Y listo!!! Nuestro proyecto estará funcionado 🔥
