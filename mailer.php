<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    public static function sendEmail($to, $subject, $body) {
        $mail = new PHPMailer(true); // Create a new PHPMailer instance
        try {
            // Server settings
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'pibushan28@gmail.com'; // Your Gmail address
            $mail->Password = 'pcaspdkkdmvvoehl'; // Your App Password without spaces
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption
            $mail->Port = 587; // TCP port to connect to

            // Recipients
            $mail->setFrom('pibushan28@gmail.com', 'Group_01'); // Sender's email
            $mail->addAddress($to); // Add a recipient

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send(); // Send the email
            return true; // Return true if email is sent
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; // Display error
            return false; // Return false if email sending fails
        }
    }
}
?>
