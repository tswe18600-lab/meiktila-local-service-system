<?php
session_start();
require_once '../config/db.php';

if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // SQL ကို သေချာပြင်ပါ
    $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
    
    // Execute လုပ်တဲ့အခါ Error ရှိမရှိ သေချာစစ်မယ်
    if ($stmt->execute([$id])) {
        // ဖျက်တာအောင်မြင်မှ Redirect လုပ်မယ်
        header("Location: bookings.php?msg=deleted");
        exit(); // နေရာမှန်ဖို့ အရေးကြီးပါတယ်
    } else {
        echo "Error: စာရင်းဖျက်လို့ မရပါဘူး။";
        print_r($stmt->errorInfo()); // Error တက်ရင် ဘာလို့လဲဆိုတာ ပြလိမ့်မယ်
    }
}
?>