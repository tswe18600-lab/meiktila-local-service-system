<?php
session_start();
require_once '../config/db.php';
if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // ပုံပါရှိရင် ပုံကိုပါ ဖိုင်ထဲကနေ တစ်ခါတည်း ဖျက်ထုတ်မယ်
    $stmt = $pdo->prepare("SELECT image FROM services WHERE id = ?");
    $stmt->execute([$id]);
    $service = $stmt->fetch();
    
    if ($service && $service['image']) {
        @unlink("../assets/img/services/" . $service['image']);
    }

    $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
    if ($stmt->execute([$id])) {
        header("Location: services.php?msg=deleted");
        exit();
    }
}
?>