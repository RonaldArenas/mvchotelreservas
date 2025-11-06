<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // 🔹 Configuración del servidor SMTP de Gmail
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'correo.adso@gmail.com'; // 👉 tu correo Gmail
    $mail->Password = 'inby kwye smdh veei'; // 👉 la de 16 caracteres de Google
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // 🔹 Remitente y destinatario
    $mail->setFrom('correo.adso@gmail.com', 'Hotel Naturaleza');
    $mail->addAddress($correo, 'Cliente de prueba');

    // 🔹 Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Reserva confirmada - Hotel Naturaleza';
    $mail->Body = '
        <h2>¡Reserva confirmada! 🏨</h2>
        <p>Hola, este es un correo de prueba enviado desde <b>Hotel Naturaleza</b> usando <b>Gmail + PHPMailer</b>.</p>
        <p>Si ves este mensaje, la configuración funcionó correctamente ✅.</p>
    ';
    $mail->AltBody = 'Este es un correo de prueba enviado desde Hotel Naturaleza.';

    // 🔹 Enviar
    $mail->send();
    echo '✅ Correo enviado correctamente con Gmail.';
} catch (Exception $e) {
    echo "❌ Error al enviar el correo: {$mail->ErrorInfo}";
}
?>
