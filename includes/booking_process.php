<?php
session_start();
require_once '../config/db.php';

// Login မဝင်ထားရင် လက်မခံဘူး
if(!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $service_id    = $_POST['service_id'];
    $user_id       = $_SESSION['user_id']; 
    $customer_name = $_POST['customer_name'];
    $phone         = $_POST['phone'];
    $booking_date  = $_POST['booking_date'];
    $note          = $_POST['note'];

    try {
        // SQL query ထဲက column နာမည်တွေ database နဲ့ ကိုက်အောင် စစ်ထားပါတယ်
        $sql = "INSERT INTO bookings (service_id, user_id, user_name, user_phone, booking_date, notes, status) 
                VALUES (?, ?, ?, ?, ?, ?, 'pending')";

        $stmt = $pdo->prepare($sql);
        
        // variable များကို array ပုံစံ [] ထဲထည့်ရပါမယ်
        $result = $stmt->execute([$service_id, $user_id, $customer_name, $phone, $booking_date, $note]);

        if($result) {
            // အောင်မြင်ရင် SweetAlert2 ပြမယ်
            echo "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <style>
                    body { font-family: sans-serif; }
                </style>
            </head>
            <body>
                <script>
                    Swal.fire({
                        title: 'အောင်မြင်ပါသည်!',
                        text: 'သင်၏ Booking ကို လက်ခံရရှိပါပြီ။',
                        icon: 'success',
                        confirmButtonText: 'အိုကေ',
                        confirmButtonColor: '#0d6efd'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '../my_bookings.php';
                        }
                    });
                </script>
            </body>
            </html>";
        }
    } catch (PDOException $e) {
        // အကယ်၍ အမှားတက်ခဲ့ရင် အဖြူရောင်ကြီး မဖြစ်ဘဲ ဘာမှားလဲဆိုတာ ပေါ်လာအောင် လုပ်ထားပါတယ်
        echo "Database Error: " . $e->getMessage();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>