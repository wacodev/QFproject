<p align="center">
  <img src="https://raw.githubusercontent.com/wacodev/QFproject/master/qfproject/public/images/sistema/logo-simple-mini.png" style="width: 150px;">
</p>

# QFproject

Sistema de reservación de locales para la Facultad de Química y Farmacia de la Universidad de El Salvador.

## Instalación

1. Clonar el respositorio.

```
git clone https://github.com/wacodev/QFproject.git
```

2. Abrir una terminal y ubicarse en la carpeta `qfproject` que es la raíz del proyecto.

3. Instalar las dependencias del proyecto.

```
composer install
```

4. Copiar el archivo `.env.example` y nombrarlo como `.env`.

```
cp .env.example .env
```

5. Crear una nueva API key.

```
php artisan key:generate
```

6. Editar el archivo `.env` con las credenciales de su base de datos. A continuación se presenta un ejemplo.

```
DB_DATABASE=qfproject
DB_USERNAME=root
DB_PASSWORD=
```

> En el ejemplo anterior se usaron las credenciales de usuario por defecto de XAMPP y el nombre de la base de datos es `qfproject`.

7. Realizar las migraciones de la base de datos.

```
php artisan migrate
```

8. Activar Tinker.

```
php artisan tinker
```

9. Crear un usuario de tipo `Administrador` para ingresar al sistema. A continuación se presenta un ejemplo.

```php
$user = new qfproject\User;
$user->name = "William";
$user->lastname = "Coto";
$user->username = "wacodev";
$user->email = "wacodev@outlook.com";
$user->password = "123456";
$user->tipo = "Administrador";
$user->save();
```

10. Correr el proyecto.

```
php artisan serve
```

11. Ingresar desde un navegador web a `http://localhost:8000` o url que indique la instrucción anterior.

## Vista preliminar

<p align="center">
  <img src="https://raw.githubusercontent.com/wacodev/QFproject/master/preview.png" style="border-radius: 5px;">
</p>

## Demo

Ingresar a https://demoqfproject.000webhostapp.com/ para usar la demo del sistema.

Las credenciales para ingresar son:

* Usuario: admin
* Contraseña: admin

> En caso que la demo no esté en funcionamiento o no se permita el acceso con las credenciales provistas, escribir al correo wacodev@outlook.com e informar del problema que se presenta.
