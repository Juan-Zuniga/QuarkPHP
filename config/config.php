<?php
/** 
 * Carga .env y define constantes globales
*/

/** 
 * Requiere autoload de Composer para dependencias
*/
require_once __DIR__ . '/../vendor/autoload.php';

/* Carga .env con phpdotenv */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

/* Define BASE_URL dinámicamente */
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$script = dirname($_SERVER['SCRIPT_NAME']);
define('BASE_URL', $protocol . $host . $script . '/');

/* Entorno: para manejo de errores */
define('APP_ENV', $_ENV['APP_ENV'] ?? 'production');

/* Versión del framework */
define('QUARKPHP_VERSION', '1.0.0');