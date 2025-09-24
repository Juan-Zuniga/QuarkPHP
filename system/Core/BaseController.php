<?php
namespace Quarkphp\Core;

/* Clase base para todos los controladores: provee métodos comunes */

class BaseController {
    /* Método para renderizar vistas */
    protected function view($view, $data = []) {
        /* Solo en desarrollo: captura datos para depuración */
        if (defined('APP_ENV') && APP_ENV === 'development') {
            $debugData = [
                'view' => $view,
                'data' => $data,
                'session' => $_SESSION ?? []  /* Datos de sesión, si existe */
            ];
            $data['__quarkphp_debug'] = $debugData;

            /* Inicia buffering para capturar output de la vista y agregar panel */
            ob_start();
        }

        /* Extrae variables para la vista */
        extract($data);
        /* Incluye la vista desde app/views/ */
        require_once __DIR__ . '/../../app/Views/' . $view . '.php';

        /* Solo en desarrollo: agrega el panel automáticamente */
        if (defined('APP_ENV') && APP_ENV === 'development') {
            /* Obtiene el contenido de la vista */
            $content = ob_get_clean();
            /* Genera panel con Debug helper */
            $panelHtml = \Quarkphp\Helpers\Debug::render($data['__quarkphp_debug']);
            /* Inserta antes de </body> si existe, o al final */
            if (stripos($content, '</body>') !== false) {
                $content = str_ireplace('</body>', $panelHtml . '</body>', $content);
            } else {
                $content .= $panelHtml;
            }
            /* Imprime el contenido final */
            echo $content;
        }
    }

    /* Función para extraer datos POST sanitizados */
    protected function postData() {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        if (empty($data)) {
            $data = json_decode(file_get_contents('php://input'), true);
        }
        return $data ?? [];
    }


    /* Método para redirigir (simple) */
    protected function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit;
    }

    protected function responseJson($data, $code = 200) {
        /* Setea headers para JSON */
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($code);
        /* Imprime JSON y sale */
        echo json_encode($data);
        exit;
    }
}