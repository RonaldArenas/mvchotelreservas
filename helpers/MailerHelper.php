<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class MailerHelper
{
    public static function enviarCorreoReserva($correoDestino, $nombreCliente, $datosReserva)
    {
        $mail = new PHPMailer(true);

        try {
            // 🔹 Configuración SMTP
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'correo.adso@gmail.com';
            $mail->Password = 'inby kwye smdh veei';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // 🔹 Remitente y destinatario
            $mail->setFrom('correo.adso@gmail.com', 'Hotel Naturaleza');
            $mail->addAddress($correoDestino, $nombreCliente);

            // 🔹 Nombre del usuario logueado
            session_start();
            $nombreUsuario = isset($_SESSION['user'])
                ? $_SESSION['user']['nombre'] . ' ' . $_SESSION['user']['apellido']
                : $nombreCliente;

            // 🔹 Plantilla HTML elegante
            $mail->isHTML(true);
            $mail->Subject = '🌿 Confirmación de Reserva - Hotel Naturaleza';
            $mail->Body = "
            <div style='background-color:#f4f4f4; padding:30px; font-family:Arial, sans-serif;'>
                <div style='max-width:600px; margin:auto; background-color:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.1);'>

                    <!-- Encabezado -->
                    <div style='background-color:#2e8b57; color:white; text-align:center; padding:20px 0;'>
                        <h1 style='margin:0; font-size:24px;'>Hotel Naturaleza</h1>
                        <p style='margin:5px 0 0; font-size:14px;'>Vive la tranquilidad de la naturaleza 🌿</p>
                    </div>

                    <!-- Contenido -->
                    <div style='padding:25px; color:#333333;'>
                        <h2 style='color:#2e8b57;'>¡Hola {$nombreUsuario}!</h2>
                        <p>Se realizó una reserva a nombre de <b>{$nombreCliente}</b>.</p>

                        <h3 style='color:#2e8b57; border-bottom:2px solid #2e8b57; display:inline-block;'>Detalles de la reserva</h3>
                        <ul style='line-height:1.7; list-style:none; padding:0;'>
                            <li>🏡 <b>Tipo de habitación:</b> {$datosReserva['habitacion']}</li>
                            <li>📅 <b>Fecha de entrada:</b> {$datosReserva['fecha_entrada']}</li>
                            <li>📅 <b>Fecha de salida:</b> {$datosReserva['fecha_salida']}</li>
                            <li>👥 <b>Personas:</b> {$datosReserva['personas']}</li>
                            <li>💬 <b>Comentarios:</b> " . (!empty($datosReserva['comentarios']) ? $datosReserva['comentarios'] : 'Ninguno') . "</li>
                        </ul>

                        <p style='margin-top:20px;'>Gracias por confiar en nosotros.<br>
                        <b>Hotel Naturaleza</b> 🌿</p>
                    </div>

                    <!-- Pie -->
                    <div style='background-color:#f0f0f0; text-align:center; padding:15px; font-size:12px; color:#777;'>
                        © " . date('Y') . " Hotel Naturaleza. Todos los derechos reservados.
                    </div>

                </div>
            </div>
            ";

            $mail->AltBody = "Se realizó una reserva a nombre de {$nombreCliente}, tipo de habitación {$datosReserva['habitacion']}. Gracias por elegir Hotel Naturaleza.";

            $mail->send();
            return true;

        } catch (Exception $e) {
            error_log("Error al enviar correo: {$mail->ErrorInfo}");
            return false;
        }
    }
}
