<?php
session_start();
require_once '../config/db.php';
require_once '../config/mail_helper.php'; // လမ်းကြောင်းမှန်အောင် စစ်ပေးပါ

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    try {
        // ၁။ Booking Status ကို အရင် Update လုပ်မယ်
        $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        if ($stmt->execute([$status, $id])) {
            
            // ၂။ Email ပို့ဖို့အတွက် User ရဲ့ Email နဲ့ Service အမည်ကို JOIN တွဲပြီး ဆွဲထုတ်မယ်
            // သင့် Database ပုံအရ user_phone, user_name တွေက bookings table ထဲမှာလည်း ရှိနေလို့ အဲဒီကပဲ တိုက်ရိုက်ယူပါမယ်
            $sql = "SELECT b.user_phone, b.user_name, u.email, s.service_name 
                    FROM bookings b 
                    JOIN users u ON b.user_id = u.id 
                    JOIN services s ON b.service_id = s.id 
                    WHERE b.id = ?";
            
            $stmt_info = $pdo->prepare($sql);
            $stmt_info->execute([$id]);
            $info = $stmt_info->fetch();

            if ($info && !empty($info['email'])) {
                // ၃။ Mail Helper ထဲက Function ကို လှမ်းခေါ်မယ်
                // Parameter များ - (Email, Name, Status, Service Name)
                sendStatusEmail(
                    $info['email'], 
                    $info['user_name'], 
                    $status, 
                    $info['service_name']
                );
            }

            // ၄။ အောင်မြင်ရင် မူလစာမျက်နှာကို ပြန်လွှတ်မယ်
            header("Location: manage_bookings.php?msg=success");
            exit();
        }
    } catch (PDOException $e) {
        die("Database Error: " . $e->getMessage());
    }
} else {
    header("Location: manage_bookings.php");
    exit();
}
?>