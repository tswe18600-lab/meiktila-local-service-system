<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// ... (အပေါ်ပိုင်း ကုဒ်များအတိုင်း)

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    
    // ပုံဟောင်းကို အရင်ယူထားမယ်
    $image_name = isset($user['profile_image']) ? $user['profile_image'] : null;

    // ပုံအသစ် တင်မတင် စစ်မယ်
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $target_dir = "uploads/profile/";
        
        // Folder မရှိရင် ဆောက်ခိုင်းမယ်
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_ext = pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION);
        $new_filename = "user_" . $user_id . "_" . time() . "." . $file_ext;
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            $image_name = $new_filename;
        }
    }
    
    // Database မှာ Update လုပ်မယ်
    $update = $pdo->prepare("UPDATE users SET fullname = ?, phone = ?, profile_image = ? WHERE id = ?");
    if($update->execute([$fullname, $phone, $image_name, $user_id])) {
        $_SESSION['user_name'] = $fullname;
        header("Location: profile.php?status=success");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings - Meiktila Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f4f7f6; font-family: 'Pyidaungsu', sans-serif; }
        .card { border: none; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        
        /* Profile Image Styling */
        .profile-img-container {
            position: relative;
            width: 130px;
            height: 130px;
            margin: 0 auto 20px;
        }
        .profile-preview {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .file-upload-btn {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: #004e92;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 3px solid white;
            transition: 0.3s;
        }
        .file-upload-btn:hover { background: #003366; transform: scale(1.1); }
        
        .form-control { border-radius: 12px; padding: 12px 20px; border: 1px solid #e0e0e0; }
        .form-control:focus { box-shadow: 0 0 0 3px rgba(0,78,146,0.1); border-color: #004e92; }
        .btn-save { background: #004e92; border: none; border-radius: 12px; padding: 12px; font-weight: bold; transition: 0.3s; }
        .btn-save:hover { background: #003366; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,78,146,0.3); }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card p-4 p-md-5">
                <form method="POST" enctype="multipart/form-data">
                    <div class="text-center mb-4">
                        <div class="profile-img-container">
                            <?php 
                                $img_path = !empty($user['profile_image']) ? "uploads/profile/" . $user['profile_image'] : "https://cdn-icons-png.flaticon.com/512/149/149071.png";
                                ?>
                            <img src="<?= $img_path ?>" id="preview" class="profile-preview">
                            <label for="imgInput" class="file-upload-btn">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" name="profile_image" id="imgInput" hidden accept="image/*">
                        </div>
                        <h4 class="fw-bold mb-1"><?= htmlspecialchars($user['fullname']) ?></h4>
                        <p class="text-muted small">Profile Settings</p>
                    </div>

                    <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                        <div class="alert alert-success border-0 small py-2 text-center rounded-3">
                            <i class="fas fa-check-circle me-1"></i> အချက်အလက်များ ပြင်ဆင်ပြီးပါပြီ။
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">အမည်အပြည့်အစုံ</label>
                        <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($user['fullname']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">အီးမေးလ်</label>
                        <input type="email" class="form-control bg-light" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary">ဖုန်းနံပါတ်</label>
                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="၀၉ xxxxxxxx">
                    </div>

                    <button type="submit" class="btn btn-primary btn-save w-100 mb-3 text-white">
                        ပြင်ဆင်ချက်များကို သိမ်းဆည်းမည်
                    </button>
                    
                    <div class="text-center">
                        <a href="index.php" class="text-decoration-none text-muted small fw-bold">
                            <i class="fas fa-arrow-left me-1"></i> မူလစာမျက်နှာသို့ ပြန်ရန်
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // ပုံရွေးလိုက်ရင် ချက်ချင်း Preview ပြပေးတဲ့ Script
    document.getElementById('imgInput').onchange = evt => {
        const [file] = document.getElementById('imgInput').files
        if (file) {
            document.getElementById('preview').src = URL.createObjectURL(file)
        }
    }
</script>

</body>
</html>