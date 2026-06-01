<?php
session_start();
// config file လမ်းကြောင်း မှန်မမှန် ပြန်စစ်ပေးပါ (ဥပမာ - admin folder ထဲမှာ ရှိနေရင် ../ ဖြစ်ရပါမယ်)
require_once '../config/db.php';



// URL ကနေ id နဲ့ role တန်ဖိုး ပါမပါ စစ်ဆေးပါတယ်
if (isset($_GET['id']) && isset($_GET['to'])) {
    $user_id = (int)$_GET['id']; // လုံခြုံရေးအတွက် integer ပြောင်းပါတယ်
    $new_role = $_GET['to'];

    // Role တန်ဖိုးက 'user' သို့မဟုတ် 'provider' ဟုတ်မဟုတ် စစ်ဆေးပါတယ်
    if (in_array($new_role, ['user', 'provider'])) {
        try {
            $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
            if ($stmt->execute([$new_role, $user_id])) {
                // အောင်မြင်ရင် manage_users.php ဆီကို status=success နဲ့ ပြန်ပို့ပါတယ်
                header("Location: ./manage_users.php?status=success");
                exit();
            }
        } catch (PDOException $e) {
            // Database error တက်ရင် ပြပေးမှာပါ
            die("Error updating role: " . $e->getMessage());
        }
    } else {
        // Role တန်ဖိုး မှားနေရင် ပြန်ပို့မယ်
        header("Location: ./manage_users.php?status=error");
        exit();
    }
} else {
    // Parameter မပါရင် ပြန်ပို့မယ်
    header("Location: ./manage_users.php");
    exit();
}