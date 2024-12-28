<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'includes/config.php';
// Load PHPMailer files
require 'auth/assets/vendor/PHPMailer/src/Exception.php';
require 'auth/assets/vendor/PHPMailer/src/PHPMailer.php';
require 'auth/assets/vendor/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstName = htmlspecialchars($_POST['first_name']);
    $lastName = htmlspecialchars($_POST['last_name']);
    $city = htmlspecialchars($_POST['city']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Send email using PHPMailer
    if (sendContactEmail($firstName, $lastName, $city, $email, $telephone, $subject, $message)) {
        // echo "Message sent successfully!";
        header(
            "Location: /"
        );
    } else {
        echo "Failed to send message. Please try again.";
    }
}

function sendContactEmail($firstName, $lastName, $city, $email, $telephone, $subject, $message)
{
    global $mailHost, $mailUsername, $mailPassword, $mailPort;

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = $mailHost;
        $mail->SMTPAuth = true;
        $mail->Username = $mailUsername;
        $mail->Password = $mailPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = $mailPort;

        // Recipients
        $mail->setFrom($email, $firstName . ' ' . $lastName);
        $mail->addAddress('info@soulmate.com.pk'); // The recipient's email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Contact Us Form Submission: ' . $subject;
        $mail->Body = "
            <h3>Contact Form Submission</h3>
            <p><strong>Name:</strong> $firstName $lastName</p>
            <p><strong>City:</strong> $city</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Telephone:</strong> $telephone</p>
            <p><strong>Subject:</strong> $subject</p>
            <p><strong>Message:</strong><br>$message</p>
        ";
        $mail->AltBody = "Contact Form Submission\n\nName: $firstName $lastName\nCity: $city\nEmail: $email\nTelephone: $telephone\nSubject: $subject\nMessage: $message";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
