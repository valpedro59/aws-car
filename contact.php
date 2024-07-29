<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

// Define variables and set to empty values
$array = array(
    "username" => "",
    "email" => "",
    "phone" => "",
    "subject" => "",
    "car" => "",
    "content" => "",
    "usernameErr" => "",
    "emailErr" => "",
    "phoneErr" => "",
    "subjectErr" => "",
    "carErr" => "",
    "contentErr" => "",
    "isSuccess" => false,
);

$to = "contact@aws-carrental.com";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $array["username"] = htmlspecialchars($_POST['username']);
    $array["email"] = htmlspecialchars($_POST['email']);
    $array["phone"] = htmlspecialchars($_POST['phone']);
    $array["subject"] = htmlspecialchars($_POST['subject']);
    $array["car"] = htmlspecialchars($_POST['car']);
    $array["content"] = htmlspecialchars($_POST['content']);

    // Validate the inputs
    if (empty($array["username"])) {
        $array["usernameErr"] = "Name is required.";
    }
    if (empty($array["email"]) || !filter_var($array["email"], FILTER_VALIDATE_EMAIL)) {
        $array["emailErr"] = "Valid email is required.";
    }

    if (empty($array["usernameErr"]) && empty($array["emailErr"])) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'contact@aws-carrental.com';
            $mail->Password = 'Rentalcar1234@'; // Replace with your actual password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            //Recipients
            $mail->setFrom('contact@aws-carrental.com', 'AWS Car Rental');
            $mail->addAddress("contact@aws-carrental.com");

            //Content
            $mail->isHTML(false);
            $mail->Subject = $array["subject"];
            $mail->Body = "Name: " . $array["username"] . "\n"
                . "Email: " . $array["email"] . "\n"
                . "Phone: " . $array["phone"] . "\n"
                . "Car: " . $array["car"] . "\n"
                . "Message:\n" . $array["content"];

            $mail->send();
            $array["isSuccess"] = true;
            header("Location: contact.html");
        } catch (Exception $e) {
            $array["emailErr"] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}