<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP (Datos de tu hosting)
        $mail->isSMTP();
        $mail->Host       = 'mail.panagreen.com.pe'; // Tu servidor de correo
        $mail->SMTPAuth   = true;
        $mail->Username   = 'contacto@panagreen.com.pe'; // Tu cuenta corporativa
        $mail->Password   = 'TuPasswordSegura';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Destinatarios
        $mail->setFrom('contacto@panagreen.com.pe', 'Web Panagreen');
        $mail->addAddress('grupo.innova.all@gmail.com'); // Correo destino

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Nueva consulta web: ' . $_POST['nombre'];
        $mail->Body    = "
            <h3>Nueva consulta desde la web</h3>
            <p><strong>Nombre:</strong> {$_POST['nombre']}</p>
            <p><strong>Email:</strong> {$_POST['email']}</p>
            <p><strong>Celular:</strong> {$_POST['celular']}</p>
            <p><strong>Mensaje:</strong><br>{$_POST['mensaje']}</p>
        ";

        $mail->send();
        echo "<script>alert('Mensaje enviado con éxito'); window.location.href='contacto.html';</script>";
    } catch (Exception $e) {
        echo "Error al enviar: {$mail->ErrorInfo}";
    }
}