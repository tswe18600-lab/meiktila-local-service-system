<?php
session_start();
require_once 'config/db.php'; // ဖိုင်က အပြင်မှာရှိနေရင် ဒီအတိုင်းထားပါ

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // အီးမေးလ်ဖြင့် User ကို အရင်ရှာပါ
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // User ရှိပြီး Password မှန်ကန်ပါက (Hash သို့မဟုတ် Plain text နှစ်မျိုးလုံးစစ်ပေးထားသည်)
    if ($user && ($password === $user['password'] || password_verify($password, $user['password']))) {
        
        // Session ထဲသို့ အချက်အလက်များ ထည့်ခြင်း (နာမည်မှန်အောင် ပြင်ထားသည်)
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['fullname']; 
        
        // Header အတွက် user_name ဟု သုံးထားသည်
        $_SESSION['user_image'] = $user['profile_image'];
        $_SESSION['role'] = $user['role']; 

        // Role အလိုက် သက်ဆိုင်ရာ စာမျက်နှာသို့ လွှတ်ပေးခြင်း
        if ($user['role'] === 'admin') {
            header("Location: admin/dashboard.php");
        } elseif ($user['role'] === 'provider') {
            header("Location: provider/dashboard.php"); // provider စာလုံးပေါင်း ပြင်ထားသည်
        } else {
            header("Location: index.php");
        }
        exit();

    } else {
        echo "<script>alert('Email သို့မဟုတ် Password မှားနေပါတယ်။'); window.location='login.php';</script>";
        exit();
    }
}
?>