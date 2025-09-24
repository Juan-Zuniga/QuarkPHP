<?php
/**
 * Define rutas:
 * mapea URLs a controladores y funcoines con @
**/

$router->setNamespace('\App\Controllers');

$router->get('', 'HomeController@index');

// Rutas de ejemplo *************************************************************************************
$router->get('home/{title}', 'HomeController@recibeGet');     // get con parametro
$router->post('formulario', 'HomeController@recibePOST');     // recepcion de datos y envio json    
$router->get('/db', 'HomeController@exampleDB');              // Ejemplo de conexion con db
$router->get('/mail', 'HomeController@exampleMail');          // Ejemplo de envio de correo con plantilla
// ******************************************************************************************************