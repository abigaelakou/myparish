<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../vendor/autoload.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $sujet = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // Configuration serveur SMTP
        $mail->isSMTP();
        $mail->Host       = 'mail.paroissesmart.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'contact@paroissesmart.com';
        $mail->Password   = 'I8#kp520k8-]mmYs';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        // Expéditeur & Destinataire
        $mail->setFrom('contact@paroissesmart.com', 'Paroisse Smart');
        $mail->addAddress('contact@paroissesmart.com'); 

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = $sujet;
        $mail->Body    = "
            <strong>Nom :</strong> $nom<br>
            <strong>Email :</strong> $email<br>
            <strong>Message :</strong><br>$message
        ";

        $mail->send();
        echo 'Votre message a été envoyé avec succès.';
    } catch (Exception $e) {
        echo 'Erreur lors de l’envoi : ', $mail->ErrorInfo;
    }
} else {
    echo 'Méthode non autorisée';
}
