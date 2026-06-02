<?php
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);
    
    if ($check->rowCount() > 0) {
        $error = "ဤအီးမေးလ်ဖြင့် အကောင့်ဖွင့်ပြီးသား ဖြစ်နေသည်။";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $password])) {
            header("Location: login.php?msg=success");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Meiktila Services</title>
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
        .register-card { 
            width: 100%;
            max-width: 450px; 
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
        .btn-register {
            background: linear-gradient(to right, #667eea, #764ba2);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-register:hover {
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
        <div class="card register-card shadow-lg p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="bg-primary text-white d-inline-block rounded-circle p-3 mb-3">
                    <i class="fas fa-user-plus fa-2x"></i>
                </div>
                <h3 class="fw-bold text-dark">အကောင့်သစ်ဖွင့်ရန်</h3>
                <p class="text-muted small">Meiktila Services မှ ကြိုဆိုပါတယ်</p>
            </div>

            <?php if(isset($error)): ?>
                <div class="alert alert-danger border-0 rounded-3 small">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold">နာမည်အပြည့်အစုံ</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="name" class="form-control" placeholder="အမည်" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Email လိပ်စာ</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="example@gmail.com" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="အနည်းဆုံး ၆ လုံး" required minlength="6">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-register w-100 text-white mt-2">
                    အကောင့်ဖွင့်မည်
                </button>
            </form>

            <div class="text-center mt-4">
                <p class="mb-0 small text-muted">အကောင့်ရှိပြီးသားလား? <a href="login.php" class="text-decoration-none fw-bold text-primary">Login ဝင်ရန်</a></p>
            </div>
        </div>
    </div>
</body>
</html>