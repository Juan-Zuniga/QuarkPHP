<?php
namespace Quarkphp\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* Helper para enviar emails con templates de vistas */

class EmailTemplate {
    /**
     * Renderiza una vista a string HTML
     * @param string $view Nombre de la vista (ej. 'emails/welcome')
     * @param array $data Datos para la vista
     * @return string HTML renderizado
     */
    private static function renderView($view, $data = []) {
        ob_start();
        extract($data);
        require_once __DIR__ . '/../../app/Views/' . $view . '.php';
        return ob_get_clean();
    }

    /**
     * Envía email usando una vista como body
     * @param string $to Destino
     * @param string $subject Asunto
     * @param string $view Nombre de vista para body (ej. 'emails/welcome')
     * @param array $data Datos para inyectar en la vista
     * @return bool True si enviado
     */
    public static function send($to, $subject, $view, $data = []) {
        $mail = new PHPMailer(true);
        try {
            /* Config desde .env */
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USER'];
            $mail->Password = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  /* O SMTPS */
            $mail->Port = $_ENV['SMTP_PORT'];

            /* Remitente */
            $mail->setFrom($_ENV['SMTP_FROM_EMAIL'], $_ENV['SMTP_FROM_NAME']);
            $mail->addAddress($to);

            /* Contenido HTML desde vista */
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = self::renderView($view, $data);

            $mail->send();
            return true;
        } catch (Exception $e) {
            Log::debug("Fallo al enviar email template: " . $e->getMessage());
            return false;
        }
    }
}