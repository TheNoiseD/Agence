# Manual de Instalacion Test BANDIT

### Requisitos

- PHP v8.1
- node v18.17.0
- Mysql 5.7.19. or MariaDB 10.7.3
- Composer

### Instalación 🔧
1. Clonar el repositorio en el folder del servidor web en uso o en el de su elección, **este folder debe tener permisos para que php se pueda ejecutar por CLI y permisos de lectura y escritura para el archivo .env**.

```sh 
git clone https://github.com/TheNoiseD/Agence
```

2. Instalar paquetes ejecutando en la raíz del folder.

```sh 
composer install
```
Tambien instalar las dependencias de node.
```sh
npm install
```
3. Crear BD `caol`.

```sh 
CREATE DATABASE caol;
```

4. Duplique el archivo `.env.example` incluido en uno de nombre `.env` y dentro de este ingrese los valores de las variables de entorno necesarias

5. Ejecute los siguientes comandos para poner en marcha las configuraciones del sitio.

```sh
php artisan key:generate
``` 
```sh
php artisan migrate
```
```sh
npm run build
```
6. Para poner la aplicación en marcha tiene varias opciones.

- Configurar el servidor web para que apunte a la carpeta public del proyecto.

- Ejecutar el comando `php artisan serve` en la raíz del proyecto y acceder a la url.

## Autor ✒️

* **Guillermo Ordoñez**  [anthmon19@gmail.com](mailto:anthmon19@gmail.com)
