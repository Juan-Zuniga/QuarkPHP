<?php
namespace App\Models;

use Quarkphp\Helpers\DB;

class ExampleModel {
    public function save() {
        DB::query("INSERT INTO users(nombre, apellidos) VALUES (?, ?)", ['juan', 'Example']);
    }
}