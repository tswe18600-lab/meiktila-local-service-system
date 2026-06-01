<?php
session_start();
require_once '../config/db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->execute([$email, $password]);
    $user = $stmt->fetch();

    if ($user) {
        if ($user['role'] == 'admin') {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['fullname'];
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['fullname'];
            header("Location: ../index.php"); // အပြင်က index ဆီသွားမယ်
            exit();
        }
    } else {
        echo "<script>alert('Email သို့မဟုတ် Password မှားနေပါတယ်။'); window.location='../login.php';</script>";
        exit();
    }
}