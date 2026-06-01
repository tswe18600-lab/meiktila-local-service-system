<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'provider') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $provider_id = $_SESSION['user_id'];

    // ပိုင်ရှင် ဟုတ်မဟုတ် အရင်စစ်ပြီးမှ ဖျက်မယ်
    $stmt = $pdo->prepare("DELETE FROM services WHERE id = ? AND provider_id = ?");
    if ($stmt->execute([$id, $provider_id])) {
        header("Location: dashboard.php?msg=Deleted");
        exit();
    }
}