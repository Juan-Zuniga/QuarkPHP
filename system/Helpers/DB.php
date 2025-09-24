<?php
namespace Quarkphp\Helpers;

use Medoo\Medoo;

/* Helper para conexión DB con Medoo (singleton) */

class DB {
    private static $instance = null;

    private function __construct() {
        /* Carga config de DB */
        $config = require __DIR__ . '/../../config/database.php';
        self::$instance = new Medoo([
            'type' => $config['type'],
            'host' => $config['host'],
            'port' => $config['port'],
            'database' => $config['name'],
            'username' => $config['user'],
            'password' => $config['pass'],
            'charset' => $config['charset'],
            'error' => \PDO::ERRMODE_EXCEPTION
        ]);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            new self();  /* Crea instancia si no existe */
        }
        return self::$instance;
    }

    public static function query(string $sql, array $params = [], bool $single = false): array {
        $pdo = self::getInstance()->pdo;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $single
            ? $stmt->fetch(\PDO::FETCH_ASSOC) ?: []
            : $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function selectLimit($table, $columns = '*', $where = [], $limit = null) {
        if (is_numeric($limit)) {
            $where['LIMIT'] = (int)$limit;
        }
        return self::getInstance()->select($table, $columns, $where);
    }
    
    public static function insert(string $table, array $data): int {
        self::getInstance()->insert($table, $data);
        return self::getInstance()->id(); // Último ID insertado
    }

    public static function update(string $table, array $data, array $where = []): int {
        $result = self::getInstance()->update($table, $data, $where);
        return $result->rowCount(); // Número de filas afectadas
    }

    public static function delete(string $table, array $where = []): int {
        $result = self::getInstance()->delete($table, $where);
        return $result->rowCount(); // Número de filas eliminadas
    }
}