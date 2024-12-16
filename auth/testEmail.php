<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer files
require 'assets/vendor/PHPMailer/src/Exception.php';
require 'assets/vendor/PHPMailer/src/PHPMailer.php';
require 'assets/vendor/PHPMailer/src/SMTP.php';


// SMTP Configuration
$mailHost = 'mail.soulmate.com.pk';
$mailUsername = 'admin@soulmate.com.pk';
$mailPassword = 'nX^B=[cJ];e;';
$mailPort = 465;

// Email test details
$toEmail = 'aneesmalikgul@gmail.com'; // Replace with your test recipient email
$subject = 'SMTP Test Email';
$body = 'This is a test email sent via PHPMailer with SMTP configuration.';

// Test email function
function testSMTPMail($mailHost, $mailUsername, $mailPassword, $mailPort, $toEmail, $subject, $body)
{
    $mail = new PHPMailer(true);

    try {
        // Enable verbose debug output
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';

        // Server settings
        $mail->isSMTP();
        $mail->Host = $mailHost;
        $mail->SMTPAuth = true;
        $mail->Username = $mailUsername;
        $mail->Password = $mailPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SSL
        $mail->Port = $mailPort;

        // Optional: Bypass SSL verification for testing
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Recipients
        $mail->setFrom($mailUsername, 'Test Mailer');
        $mail->addAddress($toEmail);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = strip_tags($body);

        // Send email
        if ($mail->send()) {
            echo "Test email sent successfully to {$toEmail}";
        }
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}

// Call the test function
testSMTPMail($mailHost, $mailUsername, $mailPassword, $mailPort, $toEmail, $subject, $body);
