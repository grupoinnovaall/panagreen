<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Ajusta estas rutas según dónde guardaste la carpeta de la librería
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = new PHPMailer(true);

    try {
        // --- CONFIGURACIÓN DEL SERVIDOR SMTP ---
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST; // Usamos la constante del config.php
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER; // Usamos la constante del config.php
        $mail->Password   = SMTP_PASS; // Usamos la constante del config.php
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;
        $mail->CharSet    = 'UTF-8';

        // Desactivar verificación de SSL (Solo para Laragon/Localhost)
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // --- DESTINATARIOS ---
        $mail->setFrom(SMTP_USER, 'Web Panagreen');
        $mail->addAddress('grupo.innova.all@gmail.com'); // Destino final
        $mail->addReplyTo($_POST['email'], $_POST['nombre']); // Para responder al cliente

        // --- CONTENIDO DEL CORREO (Diseño Institucional) ---
        $mail->isHTML(true);
        $mail->Subject = 'Consulta Web Panagreen: ' . $_POST['nombre'];
        
        $cuerpo = "
        <div style='font-family: sans-serif; border: 1px solid #0d4e5a; padding: 20px;'>
            <div style='background: #0d4e5a; color: white; padding: 10px; text-align: center;'>
                <h2 style='margin:0;'>Panagreen S.A.C.</h2>
            </div>
            <p style='margin-top:20px;'><strong>Nombre:</strong> {$_POST['nombre']}</p>
            <p><strong>Correo:</strong> {$_POST['email']}</p>
            <p><strong>Teléfono:</strong> {$_POST['celular']}</p>
            <p style='background: #f4f4f4; padding: 15px;'><strong>Mensaje:</strong><br>{$_POST['mensaje']}</p>
        </div>";

        $mail->Body = $cuerpo;

        $mail->send();
        echo "<script>
                alert('Mensaje enviado con éxito a grupo.innova.all@gmail.com');
                window.location.href='contacto.html';
              </script>";

    } catch (Exception $e) {
        echo "<script>
                alert('Error al enviar: {$mail->ErrorInfo}');
                window.history.back();
              </script>";
    }
} else {
    header("Location: contacto.html");
}