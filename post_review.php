<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Review ပေးရန် အရင်ဆုံး Login ဝင်ပေးပါ'); window.location.href = 'login.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $service_id = $_POST['service_id'];
    $rating = $_POST['rating'];
    $comment = trim($_POST['comment']);

    if (empty($comment)) {
        echo "<script>alert('မှတ်ချက်တစ်ခုခု ရေးပေးပါဦး'); window.history.back();</script>";
        exit();
    }

    try {
        // Database ထဲ ထည့်မည်
        $sql = "INSERT INTO reviews (user_id, service_id, rating, comment) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$user_id, $service_id, $rating, $comment])) {
            // အောင်မြင်လျှင် အရင်ဆုံး Redirect လုပ်ပါ (ဒါမှ Review ထပ်မနေမှာပါ)
            // success=1 ဆိုတဲ့ variable ကိုပါ ပါးလိုက်ပါမယ်
            header("Location: service_view.php?id=$service_id&success=1");
            exit();
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
    exit();
}
?>