<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

$status_msg = "";
$error_msg  = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    $name    = htmlspecialchars($_POST['name']);
    $phone   = htmlspecialchars($_POST['phone']);
    $email   = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $gmail_pattern = '/^[a-z0-9.]{6,30}@gmail\.com$/';

    if (!preg_match($gmail_pattern, $email)) {
        $status_msg = "error";
        $error_msg = "Gmail ပုံစံ မှားယွင်းနေပါသည်။ (စာလုံးအသေး၊ ဂဏန်း နှင့် အစက်သာသုံးပါ၊ အနည်းဆုံး ၆ လုံးရှိရမည်)";
    } else {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'waiphyokyaw227958@gmail.com'; 
            $mail->Password   = 'oner iqrr oopz hsrt'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('waiphyokyaw227958@gmail.com', 'Website Contact');
            $mail->addAddress('waiphyokyaw227958@gmail.com');
            $mail->addReplyTo($email, $name);

            $mail->isHTML(true);
            $mail->Subject = 'New Contact from ' . $name;
            $mail->Body    = "<b>အမည်:</b> $name <br><b>ဖုန်း:</b> $phone <br><b>Email:</b> $email <br><br><b>မက်ဆေ့ချ်:</b><br>$message";

            $mail->send();
            $status_msg = "success";
        } catch (Exception $e) {
            $status_msg = "error";
            $error_msg = "Mail ပို့လို့မရပါ : {$mail->ErrorInfo}";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Meiktila Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');

        :root {
            --primary-navy: #1e3a8a;
            --accent-blue: #3b82f6;
            --soft-bg: #f8fafc;
        }

        body { 
            background-color: var(--soft-bg); 
            font-family: 'Pyidaungsu', sans-serif; 
        }

        /* Hero Section */
        .contact-hero {
            background: linear-gradient(rgba(15, 23, 42, 0.5), rgba(15, 23, 42, 0.7)), 
                        url('assets/img/services/meiktilabackground.jpg');
            background-size: cover;
            background-position: center;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            border-bottom-left-radius: 80px;
            border-bottom-right-radius: 80px;
            padding-bottom: 60px;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            padding: 8px 25px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-decoration: none;
            transition: 0.3s;
            margin-bottom: 20px;
            display: inline-block;
        }

        .btn-back:hover {
            background: white;
            color: var(--primary-navy);
        }

        /* Main Content */
        .content-wrapper {
            margin-top: -100px;
            padding-bottom: 80px;
        }
        .custom-card {
            background: white;
            border: none;
            border-radius: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .info-panel {
            background: var(--primary-navy);
            color: white;
            padding: 50px 40px;
            height: 100%;
        }

        .form-panel {
            padding: 50px 40px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .info-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            font-size: 1.2rem;
            color: #3b82f6;
        }

        .form-control {
            border-radius: 15px;
            padding: 12px 20px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            border-color: var(--accent-blue);
        }

        .btn-send {
            background: var(--primary-navy);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 15px;
            font-weight: 700;
            width: 100%;
            transition: 0.3s;
        }

        .btn-send:hover {
            background: var(--accent-blue);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2);
        }

        .map-box {
            border-radius: 25px;
            overflow: hidden;
            margin-top: 20px;
            border: 4px solid rgba(255, 255, 255, 0.1);
        }

        @media (max-width: 991px) {
            .contact-hero { height: 350px; border-radius: 0 0 40px 40px; }
            .content-wrapper { margin-top: -60px; }
            .info-panel, .form-panel { padding: 40px 25px; }
        }
         .home-icon {
            color: white;
            font-size: 24px;
            text-decoration: none;
            transition: 0.3s;
        }
        .home-icon:hover {
            color: #ffcc00; /* Mouse တင်ရင် အရောင်ပြောင်းမယ် */
        }
    </style>
</head>
<body>

<div class="contact-hero">
    <div class="container">
          <a href="index.php" class="home-icon" title="ပင်မစာမျက်နှာ">
            <i class="fa-solid fa-house"></i> </a>
        <h1 class="display-5 fw-bold mb-2">ကျွန်ုပ်တို့ထံ ဆက်သွယ်ပါ</h1>
        <p class="opacity-75 lead">တိုက်ရိုက်အကြံပြုလို/ မေးမြန်းလိုသည်များကို အချိန်မရွေး ဆက်သွယ်မေးမြန်းနိုင်ပါသည်။</p>
    </div>
</div>

<div class="container content-wrapper">
    <div class="custom-card shadow">
        <div class="row g-0">
            <div class="col-lg-5">
                <div class="info-panel">
                    <h3 class="fw-bold mb-5">ဆက်သွယ်ရန်</h3>
                    
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                        <div>
                            <div class="small opacity-75">ဖုန်းနံပါတ်</div>
                            <div class="fw-bold fs-5">+95 9 757307449</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <div class="small opacity-75">အီးမေးလ်</div>
                            <div class="fw-bold fs-5">waiphyokyaw227958@gmail.com</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <div class="small opacity-75">တည်နေရာ</div>
                            <div class="fw-bold">မိတ္ထီလာမြို့၊ မန္တလေးတိုင်းဒေသကြီး။</div>
                        </div>
                    </div>
                    <div class="map-box shadow-sm">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.361536294747!2d95.9189173!3d20.8797933!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30cb666000000001%3A0xb366037c76742548!2sMeiktila!5e0!3m2!1sen!2smm!4v1700000000000" width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="form-panel">
                    <h4 class="fw-bold mb-4 text-dark">မက်ဆေ့ချ် ပေးပို့ရန်</h4>
                    <form action="" method="POST" id="contactForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">အမည်</label>
                                <input type="text" name="name" class="form-control" placeholder="ဦးမောင်မောင်" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">ဖုန်းနံပါတ်</label>
                                <input type="tel" name="phone" class="form-control" placeholder="၀၉ xxxxxxxx" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">အီးမေးလ် (Gmail သာ)</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="name@gmail.com" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">အကြံပြုလို/မေးမြန်းလိုသည့် အကြောင်းအရာ</label>
                                <textarea name="message" class="form-control" rows="5" placeholder="ဒီနေရာတွင် ရေးသားပါ..." required></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn-send">
                                    မက်ဆေ့ချ် ပို့မည် <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="text-center py-4 bg-white border-top text-muted small">
    © 2026 <strong>Meiktila Hub Project</strong>. All Rights Reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('contactForm');
        const emailInput = document.getElementById('email');

        form.addEventListener('submit', function(e) {
            const emailValue = emailInput.value.trim();
            const gmailRegex = /^[a-z0-9.]{6,30}@gmail\.com$/;
            
            if (!gmailRegex.test(emailValue)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Gmail မှားယွင်းနေပါသည်',
                    text: 'Gmail အသုံးပြုသူအမည်သည် စာလုံးအသေး၊ ဂဏန်း နှင့် အစက်သာဖြစ်ရမည်။',
                    confirmButtonColor: '#1e3a8a'
                });
            }
        });

        <?php if($status_msg == "success"): ?>
            Swal.fire({ icon: 'success', title: 'ပို့ပြီးပါပြီ!', text: 'လူကြီးမင်း၏ မက်ဆေ့ချ်ကို ပေးပို့လိုက်ပါပြီ။', confirmButtonColor: '#1e3a8a' })
            .then(() => { window.location.href = "contact.php"; });
        <?php elseif($status_msg == "error"): ?>
            Swal.fire({ icon: 'error', title: 'မှားယွင်းနေပါသည်', text: '<?php echo $error_msg; ?>', confirmButtonColor: '#d33' });
        <?php endif; ?>
    });
</script>

</body>
</html>