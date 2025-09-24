<?php
/* Punto de entrada único: carga config, rutas y sirve */

/* Carga config principal (incluye .env y BASE_URL) */
require_once __DIR__ . '/../config/config.php';

/* Inicia buffering de salida para capturar todo y limpiar en errores */
ob_start();

// Crea router con bramus/router
$router = new \Bramus\Router\Router();

/* Manejo de errores simple: 404 y excepciones */
$router->set404(function() {
    // Redirige a página de error o muestra vista 404
    ob_clean();
    header('HTTP/1.1 404 Not Found');
    require_once __DIR__ . '/../app/Views/404.php';
});

/* Manejo de errores */
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    set_exception_handler(function($exception) {
        ob_clean();
        require_once __DIR__ . '/../app/Views/errors/development.php';
        exit;
    });
    set_error_handler(function($errno, $errstr, $errfile, $errline) {
        ob_clean();
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        exit;
    });
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    set_exception_handler(function($exception) {
        ob_clean();
        //\Quarkphp\Helpers\Log::error($exception->getMessage());
        require_once __DIR__ . '/../app/Views/errors/production.php';
        exit;
    });
    set_error_handler(function($errno, $errstr, $errfile, $errline) {
        ob_clean();
        //\Quarkphp\Helpers\Log::error("$errstr in $errfile:$errline");
        require_once __DIR__ . '/../app/Views/errors/production.php';
        exit;
    });
}

/* Carga rutas definidas en app/routes.php */
require_once __DIR__ . '/../app/routes.php';
$router->run();