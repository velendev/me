<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // se usi Composer
// oppure require 'PHPMailer/PHPMailer.php'; se usi la versione manuale

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject'] ?: 'Messaggio dal sito');
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // Config SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'robertsaurobert@gmail.com'; // Gmail tua
        $mail->Password   = 'wjsufdfudnlsfyto';       // Password app!
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        // Mittente & destinatario
        $mail->setFrom($email, $name);
        $mail->addAddress('tuaemail@gmail.com', 'Robert Dev');

        // Contenuto
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "
            <h3>Nuovo messaggio da $name</h3>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Messaggio:</strong><br>$message</p>
        ";

        $mail->send();

        // Redirect o messaggio JS
        echo "<script>alert('Messaggio inviato con successo!'); window.location.href = 'contact.html';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Errore: {$mail->ErrorInfo}'); window.location.href = 'contact.html';</script>";
    }
}
?>
