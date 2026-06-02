<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Error တက်နေတဲ့ DIR နေရာမှာ ဒီလမ်းကြောင်းတွေနဲ့ အစားထိုးပါ
require_once __DIR__ . '/../phpmailer/Exception.php';
require_once __DIR__ . '/../phpmailer/PHPMailer.php';
require_once __DIR__ . '/../phpmailer/SMTP.php';

function sendStatusEmail($user_email, $user_name, $status, $service_name) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'tswe18600@gmail.com'; 
        $mail->Password   = 'YOUR_GMAIL_APP_PASSWORD_HERE'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('tswe18600@gmail.com', 'Meiktila Service');
        $mail->addAddress($user_email, $user_name);

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = "Booking Update - " . $service_name;
        $mail->Body    = "မင်္ဂလာပါ $user_name,<br>သင်၏ $service_name ဘိုကင်မှာ <b>$status</b> ဖြစ်သွားပါပြီ။";

        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}
