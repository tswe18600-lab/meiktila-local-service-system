<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'provider') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$msg = "";

// လက်ရှိ User အချက်အလက်ကို ဆွဲထုတ်ခြင်း
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $new_password = $_POST['new_password'];

    try {
        if (!empty($new_password)) {
            // Password ပါပြောင်းလျှင်
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE users SET fullname = ?, email = ?, password = ? WHERE id = ?";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->execute([$fullname, $email, $hashed_password, $user_id]);
        } else {
            // Password မပြောင်းလျှင်
            $update_sql = "UPDATE users SET fullname = ?, email = ? WHERE id = ?";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->execute([$fullname, $email, $user_id]);
        }
        $msg = "<div class='alert alert-success'>Profile အောင်မြင်စွာ Update ဖြစ်သွားပါပြီ။</div>";
        // Update ဖြစ်ပြီးသား အချက်အလက်ကို ပြန်ဆွဲထုတ်ရန်
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();
    } catch (PDOException $e) {
        $msg = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ကိုယ်ရေးအချက်အလက် ပြင်ဆင်ရန်</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Pyidaungsu', sans-serif; background: #f0f2f5; }
        .profile-card { max-width: 500px; margin: 50px auto; border: none; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container">
        <div class="card profile-card p-4">
            <h3 class="text-center mb-4 fw-bold">Profile ပြင်ဆင်ရန်</h3>
            <?= $msg ?>
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">အမည်အပြည့်အစုံ</label>
                    <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($user['fullname']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">အီးမေးလ်</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password အသစ် (မပြောင်းလိုပါက အလွတ်ထားပါ)</label>
                    <input type="password" name="new_password" class="form-control" placeholder="Password အသစ်">
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Update သိမ်းမည်</button>
                    <a href="dashboard.php" class="btn btn-light">Dashboard သို့ ပြန်သွားရန်</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>