<?php
session_start();

// Database တိုက်ရိုက်ချိတ်ဆက်ခြင်း
$conn = mysqli_connect("localhost", "root", "", "meiktila_service_db"); // meiktila_hub နေရာမှာ သင့် DB နာမည်သေချာစစ်ပါ

if (!$conn) {
    die(json_encode(['status' => 'error', 'message' => 'DB Connection Failed']));
}

// User login ဝင်မဝင်စစ်ခြင်း
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'unauthorized']);
    exit;
}

// POST ကနေ service_id ရမရ စစ်ခြင်း
if (isset($_POST['service_id'])) {
    $user_id = $_SESSION['user_id'];
    $service_id = $_POST['service_id'];

    // အရင်ရှိမရှိစစ်ဆေးခြင်း
    $check = mysqli_query($conn, "SELECT * FROM favorites WHERE user_id = '$user_id' AND service_id = '$service_id'");

    if (mysqli_num_rows($check) > 0) {
        // ရှိရင်ဖျက်
        mysqli_query($conn, "DELETE FROM favorites WHERE user_id = '$user_id' AND service_id = '$service_id'");
        echo json_encode(['status' => 'removed']);
    } else {
        // မရှိရင်အသစ်ထည့်
        mysqli_query($conn, "INSERT INTO favorites (user_id, service_id) VALUES ('$user_id', '$service_id')");
        echo json_encode(['status' => 'added']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No Service ID provided']);
}
?>