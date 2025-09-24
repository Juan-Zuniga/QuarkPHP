<?php
namespace Quarkphp\Helpers;

/* Helper para logging en writable/logs/log-YYYY-MM-DD.log */

class Log {
    /**
     * Obtiene el path del archivo de log del día actual
     */
    private static function getLogFile() {
        $date = date('Y-m-d');
        $logDir = __DIR__ . '/../../writable/logs/';
        /* Asegura que el directorio logs exista */
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        return $logDir . "log-{$date}.log";
    }

    /**
     * Escribe un mensaje en el archivo de log
     * @param string $message Mensaje a registrar
     * @param string $level Nivel del log (INFO, ERROR, DEBUG)
     */
    public static function write($message, $level = 'INFO') {
        $logFile = self::getLogFile();
        $timestamp = date('Y-m-d H:i:s');
        $formattedMessage = "[$timestamp] [$level] $message" . PHP_EOL;

        /* Escribe en el archivo */
        file_put_contents($logFile, $formattedMessage, FILE_APPEND | LOCK_EX);
    }

    /**
     * Log de información
     * @param string $message
     */
    public static function info($message) {
        self::write($message, 'INFO');
    }

    /**
     * Log de error
     * @param string $message
     */
    public static function error($message) {
        self::write($message, 'ERROR');
    }

    /**
     * Log de depuración (solo en desarrollo)
     * @param string $message
     */
    public static function debug($message) {
        if (defined('APP_ENV') && APP_ENV === 'development') {
            self::write($message, 'DEBUG');
        }
    }
}