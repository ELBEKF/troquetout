<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer-6.10.0/src/Exception.php';
require 'phpmailer/PHPMailer-6.10.0/src/PHPMailer.php';
require 'phpmailer/PHPMailer-6.10.0/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($nom && $email && $message) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['contact_success'] = "L'adresse email n'est pas valide.";
        } else {
            // Nettoyage basique pour éviter injection dans l'entête
            $email = str_replace(["\r", "\n"], '', $email);

            $mail = new PHPMailer(true);
            try {
                // Configuration SMTP (exemple avec Gmail)
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'faycaltroquetout@gmail.com';        // Ton email Gmail
                $mail->Password = 'zscpmxdltmkfbndr';                  // Mot de passe d'application Gmail
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Bypass SSL (utile en local, ne pas utiliser en prod)
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true,
                    ],
                ];

                // Expéditeur (adresse de ton compte Gmail)
                $mail->setFrom('faycaltroquetout@gmail.com', 'TroqueTout');

                // Pour que tu puisses répondre directement à l'expéditeur
                $mail->addReplyTo($email, $nom);

                // Destinataire (ton adresse)
                $mail->addAddress('faycaltroquetout@gmail.com');

                $mail->isHTML(false);
                $mail->Subject = 'Nouveau message depuis le site';
                $mail->Body = "Nom: $nom\nEmail: $email\n\nMessage:\n$message";

                $mail->send();
                $_SESSION['contact_success'] = "Votre message a été envoyé avec succès !";
            } catch (Exception $e) {
                $_SESSION['contact_success'] = "Erreur lors de l'envoi du message : {$mail->ErrorInfo}";
            }
        }
    } else {
        $_SESSION['contact_success'] = "Veuillez remplir tous les champs.";
    }

    header("Location: contact.php");
    exit;
}
