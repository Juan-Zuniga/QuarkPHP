<?php
/* Configuración específica para DB */

/* Retorna array de config para usar en helper DB */
return [
    'type' => $_ENV['DB_TYPE'],
    'host' => $_ENV['DB_HOST'],
    'port' => $_ENV['DB_PORT'],
    'name' => $_ENV['DB_NAME'],
    'user' => $_ENV['DB_USER'],
    'pass' => $_ENV['DB_PASS'],
    'charset' => $_ENV['DB_CHARSET']
];