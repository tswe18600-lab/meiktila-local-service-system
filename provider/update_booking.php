<?php
session_start();
require_once '../config/db.php';
require_once '../config/mail_helper.php'; // လမ်းကြောင်းကို သေချာစစ်ပါ

// ဆိုင်ရှင်ဖြစ်ကြောင်း စစ်ဆေးခြင်း
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'provider') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    try {
        // ၁။ Status ကို Update လုပ်မယ်
        $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        if ($stmt->execute([$status, $id])) {
            
            // ၂။ Email ပို့ရန် အချက်အလက်ယူမယ်
            // ဆိုင်ရှင်ရဲ့ ကိုယ်ပိုင် Booking ဖြစ်မှသာ Mail ပို့နိုင်အောင် စစ်ထားပါတယ်
            $sql = "SELECT b.user_name, u.email, s.service_name 
                    FROM bookings b 
                    JOIN users u ON b.user_id = u.id 
                    JOIN services s ON b.service_id = s.id 
                    WHERE b.id = ?";
            
            $stmt_info = $pdo->prepare($sql);
            $stmt_info->execute([$id]);
            $info = $stmt_info->fetch();

            if ($info && !empty($info['email'])) {
                // ၃။ Mail ပို့တဲ့ Function ကို ခေါ်မယ်
                sendStatusEmail(
                    $info['email'], 
                    $info['user_name'], 
                    $status, 
                    $info['service_name']
                );
            }

            // ၄။ အောင်မြင်ရင် Dashboard ကို ပြန်သွားမယ်
            header("Location: dashboard.php?msg=success");
            exit();
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>