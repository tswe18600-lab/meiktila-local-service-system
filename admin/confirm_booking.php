<?php
session_start();
require_once '../config/db.php';

if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Status ကို Confirmed လို့ Update လုပ်မယ်
    $stmt = $pdo->prepare("UPDATE bookings SET status = 'Confirmed' WHERE id = ?");
    
    if ($stmt->execute([$id])) {
        header("Location: bookings.php?msg=confirmed");
        exit();
    }
}
?>