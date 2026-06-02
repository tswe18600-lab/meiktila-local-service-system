<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name    = $_POST['name'];
    $phone   = $_POST['phone'];
    $email   = $_POST['email'];   // user gmail
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // SMTP config
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;

        // 🔴 သင့် Gmail
        $mail->Username   = 'tswe18600@gmail.com';
        $mail->Password   = 'GMAIL_APP_RASSWORD'; // Gmail App Password

        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // sender (user)
        $mail->setFrom($email, $name);

        // receiver (your gmail)
        $mail->addAddress('tswe18600@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = 'New Contact Message';
        $mail->Body = "
            <b>အမည်:</b> $name <br>
            <b>ဖုန်း:</b> $phone <br>
            <b>Email:</b> $email <br><br>
            <b>Message:</b><br>
            $message
        ";

        $mail->send();
        echo "Message ပို့ပြီးပါပြီ။";

    } catch (Exception $e) {
        echo "Mail မပို့နိုင်ပါ : {$mail->ErrorInfo}";
    }
}
?>
