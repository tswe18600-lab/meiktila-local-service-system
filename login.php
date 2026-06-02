<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // ... (အပေါ်က code များ)
if ($user && password_verify($password, $user['password'])) {
    
    // --- ဒီနားမှာ Session တွေ စတင်သတ်မှတ်ရပါမယ် ---
    $_SESSION['user_id'] = $user['id'];         // User ID ကို သိမ်းဆည်းခြင်း
    $_SESSION['user_name'] = $user['fullname']; // အမည်ကို သိမ်းဆည်းခြင်း
    $_SESSION['role'] = $user['role'];         // ရာထူး (admin/user) ကို သိမ်းဆည်းခြင်း
    
    // Role အလိုက် စာမျက်နှာ ခွဲပို့ခြင်း
    if ($user['role'] === 'provider') {
        header("Location: provider/dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit();
}
// ... (အောက်က code များ)else {
        $error = "အီးမေးလ် သို့မဟုတ် စကားဝှက် မှားယွင်းနေပါသည်။";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Meiktila Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            display: flex; 
            align-items: center; 
            min-height: 100vh; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card { 
            width: 100%;
            max-width: 420px; 
            margin: auto; 
            border-radius: 20px; 
            border: none; 
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25);
            border-color: #667eea;
        }
        .btn-login {
            background: linear-gradient(to right, #667eea, #764ba2);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .input-group-text {
            background: transparent;
            border: 1px solid #e9ecef;
            border-right: none;
            border-radius: 10px 0 0 10px;
            color: #6c757d;
        }
        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card login-card shadow-lg p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="bg-primary text-white d-inline-block rounded-circle p-3 mb-3 shadow-sm">
                    <i class="fas fa-lock-open fa-2x"></i>
                </div>
                <h3 class="fw-bold text-dark">အကောင့်ဝင်ရန်</h3>
                <p class="text-muted small">သင်၏ အချက်အလက်များဖြင့် ပြန်လည်ဝင်ရောက်ပါ</p>
            </div>

            <?php if(isset($error)): ?>
                <div class="alert alert-danger border-0 rounded-3 small">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">Email လိပ်စာ</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="example@gmail.com" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="စကားဝှက်ရိုက်ထည့်ပါ" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-login w-100 text-white shadow-sm">
                    Login ဝင်မည်
                </button>
            </form>

            <div class="text-center mt-4 pt-2">
                <p class="mb-0 small text-muted">အကောင့်မရှိသေးပါက <a href="register.php" class="text-decoration-none fw-bold text-primary">ဒီမှာအသစ်ဖွင့်ပါ</a></p>
            </div>
        </div>
    </div>
</body>
</html>