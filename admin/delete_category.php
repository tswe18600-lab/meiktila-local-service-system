<?php
session_start();
require_once '../config/db.php';

if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Categories table ကနေ ဖျက်မယ်
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    
    if ($stmt->execute([$id])) {
        header("Location: categories.php?msg=deleted");
        exit();
    } else {
        echo "Error: Category ဖျက်လို့ မရပါဘူး။ (ဒီ Category အောက်မှာ ဆိုင်စာရင်းတွေ ရှိနေလို့ ဖြစ်နိုင်ပါတယ်)";
    }
}
?>