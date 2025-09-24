<?php
namespace Quarkphp\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* Helper para enviar emails con PHPMailer */

class Email {
    public static function send($to, $subject, $body, $isHtml = true) {
        $mail = new PHPMailer(true);
        try {
            /* Config desde .env */
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USER'];
            $mail->Password = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  /* O ENCRYPTION_SMTPS para 465 */
            $mail->Port = $_ENV['SMTP_PORT'];

            /* Remitente */
            $mail->setFrom($_ENV['SMTP_FROM_EMAIL'], $_ENV['SMTP_FROM_NAME']);
            $mail->addAddress($to);

            /* Contenido */
            $mail->isHTML($isHtml);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            /* Log error en writable/logs/ */
            file_put_contents(__DIR__ . '/../../writable/logs/email.log', $e->getMessage() . PHP_EOL, FILE_APPEND);
            return false;
        }
    }
}