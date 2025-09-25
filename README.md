# QuarkPHP v1.0.0

QuarkPHP es un micro-framework PHP ligero para proyectos simples, construido con PHP 8.1+, `bramus/router` para enrutamiento, `medoo/medoo` para base de datos, y `phpmailer/phpmailer` para emails. Este README muestra cómo usar rutas, controladores, respuestas JSON, datos POST, consultas a base de datos, y cómo configurar la seguridad.

## Requisitos

- PHP >= 8.1
- Composer
- Servidor web (ej. Apache/XAMPP)
- MySQL/MariaDB
- Configuración SMTP

## Instalación Básica

1. Clona el repositorio y ejecuta:
   ```bash
   composer install
   ```
2. Copia `.env.example` a `.env` y configura (base de datos, SMTP, `BASE_URL`).
3. Asegura permisos:
   ```bash
   chmod -R 755 .
   chmod -R 777 writable/
   ```

## Seguridad

- **Restringir Acceso**: Solo la carpeta `public/` debe ser accesible. Otras carpetas (`writable/`, `app/`, `config/`, `system/`) deben estar protegidas.
- **Configurar DocumentRoot**: Asegúrate de que el servidor web apunte a `public/`:
  - En XAMPP, edita `/opt/lampp/etc/httpd.conf`:
    ```apache
    DocumentRoot "/opt/lampp/htdocs/quarkphp/public"
    <Directory "/opt/lampp/htdocs/quarkphp/public">
        AllowOverride All
        Require all granted
    </Directory>
    ```
  - En HostGator, configura el dominio/subdominio para apuntar a `public_html/quarkphp/public/`.
- **Proteger Carpetas**: Crea un archivo `.htaccess` en la raíz:
  ```apache
  <IfModule mod_rewrite.c>
      RewriteEngine On
      RewriteCond %{REQUEST_URI} !^/public/ [NC]
      RewriteRule ^(.*)$ - [F,L]
  </IfModule>
  <FilesMatch "\.(env|log|cache)$">
      Order Allow,Deny
      Deny from all
  </FilesMatch>
  ```
- **Proteger `writable/`**: Agrega `writable/.htaccess`:
  ```apache
  Deny from all
  ```

## Uso del Framework

### Definir Rutas

Las rutas se definen en `app/routes.php` usando `bramus/router`. Usa `@` para mapear a métodos de controladores.

```php
<?php
/**
 * Define rutas: mapea URLs a controladores y funciones con @
 */
$router->setNamespace('\App\Controllers');

$router->get('', 'HomeController@index');

// Rutas de ejemplo
$router->get('home/{title}', 'HomeController@recibeGet');     // GET con parámetro
$router->post('formulario', 'HomeController@recibePOST');     // Recepción de datos y envío JSON
$router->get('/db', 'HomeController@exampleDB');              // Ejemplo de conexión con DB
$router->get('/mail', 'HomeController@exampleMail');          // Ejemplo de envío de correo con plantilla
```

### Controladores

Los controladores están en `app/controllers/` y extienden `BaseController`. Ejemplo en `app/controllers/HomeController.php`:

```php
<?php
namespace App\Controllers;

use Quarkphp\Core\BaseController;
use Quarkphp\Helpers\EmailTemplate;
use Quarkphp\Helpers\DB;

class HomeController extends BaseController {
    public function index() {
        $this->view('home', ['titulo' => 'Bienvenido']);
    }

    public function recibeGet($title) {
        $this->view('home', ['titulo' => $title]);
    }

    public function recibePOST() {
        /* Obtiene todo POST sanitizado si son multipart/form-data o application/x-www-form-urlencoded */
        $data = $this->postData();
        $this->responseJson(['success' => true, 'datos' => $data], 200);
    }

    public function exampleDB() {
        /**
         * $db = DB::getInstance();
         * Usando el ORM de Medoo
         * $respuesta = $db->select('test', '*', ['id' => 1, 'LIMIT' => 10]);
         */
        $id = DB::insert('test', ['mensaje' => 'Juan']);
        $this->view('home', ['titulo' => 'Bienvenido', 'id' => $id]);
    }

    public function exampleMail() {
        $to = 'juannw@example.com';
        $subject = 'Bienvenido';
        $viewData = ['nombre' => 'juannw', 'email' => 'juannw@example.com'];
        if (EmailTemplate::send($to, $subject, 'emails/welcome', $viewData)) {
            echo "Enviado";
        } else {
            echo "Error";
        }
    }
}
```

### Respuestas JSON

Usa `$this->responseJson()` en controladores para devolver JSON:

```php
$this->responseJson(['success' => true, 'datos' => ['nombre' => 'Juan']], 200);
```

### Manejo de Datos POST

Usa `$this->postData()` para obtener datos POST sanitizados (multipart, urlencoded, o JSON):

```php
$data = $this->postData();
$nombre = $data['nombre'] ?? 'Sin nombre';
$this->responseJson(['success' => true, 'datos' => $data], 200);
```

**Formulario de Ejemplo** (en `app/views/contacto.php`):

```html
<form method="post" action="<?php echo BASE_URL; ?>formulario">
    <input type="text" name="nombre" value="Juan">
    <input type="email" name="email" value="juan@example.com">
    <textarea name="mensaje">Hola</textarea>
    <button type="submit">Enviar</button>
</form>
```

### Consultas a Base de Datos

Usa el helper `DB` con Medoo para consultas. Ejemplo:

```php
// Select con filtros y límite
$users = \Quarkphp\Helpers\DB::select('test', ['id', 'mensaje'], ['id[>]' => 0], 10);

// Insert
$id = \Quarkphp\Helpers\DB::insert('test', ['mensaje' => 'Juan']);

// Update
$affected = \Quarkphp\Helpers\DB::update('test', ['mensaje' => 'Actualizado'], ['id' => $id]);

// Delete
$deleted = \Quarkphp\Helpers\DB::delete('test', ['id' => $id]);
```

### Envío de Emails con Plantillas

Usa `EmailTemplate` para enviar emails renderizando vistas en `app/views/emails/`:

```php
\Quarkphp\Helpers\EmailTemplate::send(
    'destino@example.com',
    'Asunto',
    'emails/welcome',
    ['nombre' => 'Juan', 'email' => 'juan@example.com']
);
```

**Vista de Email** (en `app/views/emails/welcome.php`):

```html
<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido</title>
    <style>body { font-family: Arial; }</style>
</head>
<body>
    <h1>Bienvenido, <?php echo $nombre; ?>!</h1>
    <p>Tu email es: <?php echo $email; ?></p>
</body>
</html>
```

## Depuración

En `APP_ENV=development`, un panel de depuración aparece en la esquina inferior derecha, mostrando vista, datos y sesión. Los logs se guardan en `writable/logs/log-YYYY-MM-DD.log`.

## Licencia

MIT License.

## Autor

Juan Zuñiga (mxjuanjose@gmail.com)
