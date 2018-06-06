<p align="center">
  <img src="https://raw.githubusercontent.com/SoyWACO/QFproject/master/qfproject/public/images/sistema/logo-simple.png" style="width: 150px;">
</p>

# QFproject

*Sistema de reservación de locales para la Facultad de Química y Farmacia de la Universidad de El Salvador.*

## Instalación

1. Clonar el respositorio en `..\xampp\htdocs` con la siguiente instrucción:

```bash
git clone https://github.com/SoyWACO/QFproject.git
```

2. En la consola ubicate en `..\xampp\htdocs\QFproject\qfproject` y ejecuta la siguiente instrucción:

```bash
composer install
```

3. Copia el archivo `.env.example`, cambia su nombre a `.env` y modifica según tus necesidades los siguientes campos:

```
DB_DATABASE=qfproject
DB_USERNAME=root
DB_PASSWORD=
```

> En el ejemplo anterior se usaron las credenciales de usuario por defecto de XAMPP y se nombró a la base de datos `qfproject`.

4. En la consola ubicate en `..\xampp\htdocs\QFproject\qfproject` y ejecuta la siguiente instrucción para realizar las migraciones de la base de datos:

```bash
php artisan migrate
```

5. En la consola ubicate en `..\xampp\htdocs\QFproject\qfproject` y ejecuta la siguiente instrucción para generar la llave de encriptación:

```bash
php artisan key:generate
```

6. Abre XAMPP y enciende el modulo de Apache y MySQL.

7. Ingresa a `http://localhost/QFproject/qfproject/public/` para ver la aplicación.

> También puedes utilizar el servidor de Composer. En la consola ubicate en `..\xampp\htdocs\QFproject\qfproject` y ejecuta la siguiente instrucción: `php artisan serve`. Luego ingresa a `http://localhost:8000` para ver la aplicación.

## Demo del sistema

Ingresa a https://demoqf.000webhostapp.com/ para usar un demo del sistema.

> Las credenciales para ingresar son:
> Usuario: admin
> Contraseña: 123456
