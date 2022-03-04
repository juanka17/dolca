<?php

require 'PHPMailer/PHPMailerAutoload.php';

class clsMailHelper
{   
    
    public static function EnviarMailSolicitarClave($parametros)
    {
        $asunto = 'Restauracion de contraseña';
        $mensaje = 'Estimando '.$parametros["nombre"];
        $mensaje = $mensaje."<br/>";
        $mensaje = $mensaje."<br/>";
        $mensaje = $mensaje."Se ha restaurado su contraseña:";
        $mensaje = $mensaje."Su nueva contraseña es: ".$parametros["CLAVE"];
        $mensaje = $mensaje."<br/>";
        $mensaje = $mensaje."<p>Para mayor información comunicate a la Linéa Atención 018000-416717</p>";
        $mensaje = $mensaje."<br/>";
        $alt = '';
        
        return clsMailHelper::EnviarMail($parametros["correo_corporativo"], $parametros["nombre"], $asunto, $mensaje, $alt, null, null);
    } 

    private static function EnviarMail($email, $nombre, $asunto, $mensaje, $alt, $cc, $ccNombre)
    {
        $mail = new PHPMailer;

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->CharSet = 'UTF-8';
        $mail->Host = 'mail.andipuntos.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'info@andipuntos.com';                 // SMTP username
        $mail->Password = "Formas3strategicaS";                           // SMTP password
        $mail->SMTPSecure = false;                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 25;                                // TCP port to connect to

        $mail->From = 'info@andipuntos.com';
        $mail->FromName = 'Andi Puntos ';
        $mail->addAddress($email, $nombre);     // Add a recipient
        
        if(isset($cc))
            $mail->AddCC($cc, $ccNombre);

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $asunto;
        $mail->Body    = $mensaje;
        $mail->AltBody = $alt;
        
        if(!$mail->send()) {
            return 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            return 'ok';
        }
    }
}

?>