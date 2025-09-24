<?php
namespace App\Controllers;

use Quarkphp\Core\BaseController;
use Quarkphp\Helpers\EmailTemplate;
use Quarkphp\Helpers\DB;

class HomeController extends BaseController {
    public function index() {
        $this->view('home', ['titulo' => 'Bienvenido']);
    }

    public function recibeGet($title){
        $this->view('home', ['titulo' => $title]);
    }

    public function recibePOST() {
        /* Obtiene todo POST sanitizado si son formmultipart/form-data o application/x-www-form-urlencoded */
        $data = $this->postData();
        $this->responseJSON(['success' => true, 'datos' => $data], 200);
    }

    public function exampleDB(){
        /**
         * $db = DB::getInstance();
         * 
         * Usando el ORM de Medoo
         * $respuesta = $db->select('test', '*', ['id' => 1, 'LIMIT' => 10]);
        */

        $id = DB::insert('test', ['mensaje' => 'JuanExample']);

        $this->view('home', ['titulo' => 'DB', 'mensaje' => 'Insertado..', 'id' => $id]);
    }

    public function exampleMail(){
        $to = 'juannw@example.com';
        $subject = 'Bienvenido';
        $viewData = ['nombre' => 'juannw', 'email' => 'juannw@example.com'];
        if (EmailTemplate::send($to, $subject, 'emails/welcome', $viewData)) {
            $this->view('home', ['titulo' => 'Correo enviado']);
        } else {
            echo "No se pudo enviar el correo";
        }
    }
}