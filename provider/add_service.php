<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'provider') {
    header("Location: ../login.php");
    exit();
}

$cat_stmt = $pdo->query("SELECT * FROM categories ORDER BY category_name ASC");
$categories = $cat_stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $provider_id = $_SESSION['user_id'];
    $service_name = trim($_POST['service_name']);
    $category_id = $_POST['category']; // Form ကပို့လိုက်တဲ့ ID ကို ယူမယ်
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $description = trim($_POST['description']);

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = time() . '_' . $_FILES['image']['name'];
        $target_file = "../assets/img/services/" . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            try {
                // SQL ထဲက ? အစီအစဉ်အတိုင်း execute ထဲမှာ ပြန်ထည့်ရပါမယ်
                $sql = "INSERT INTO services (provider_id, category_id, service_name, phone, address, description, image) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                
                // အစီအစဉ်ကို ဒီအတိုင်း အတိအကျ ပြင်ပါ
                if ($stmt->execute([$provider_id, $category_id, $service_name, $phone, $address, $description, $image_name])) {
                    echo "<script>alert('ဝန်ဆောင်မှုအသစ် တင်ပြီးပါပြီ'); window.location='dashboard.php';</script>";
                }
            } catch (PDOException $e) {
                // Error ဖြစ်ရင် ဘာကြောင့်လဲဆိုတာ သေချာပြခိုင်းမယ်
                die("Database Error: " . $e->getMessage());
            }
        } else {
            echo "<script>alert('ပုံတင်ရတာ မအောင်မြင်ပါဘူး။ assets/img/services/ folder ရှိမရှိ စစ်ပါ။');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ဆိုင်အသစ်တင်ရန်</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { font-family: 'Pyidaungsu', sans-serif; background: #f8f9fa; }
        .form-container { max-width: 600px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h3 class="text-center mb-4">ဆိုင်/ဝန်ဆောင်မှု အသစ်တင်ရန်</h3>
            <form action="" method="POST" enctype="multipart/form-data">
               <div class="mb-3">
    <label>ဝန်ဆောင်မှုအမည်</label>
    <input type="text" name="service_name" class="form-control" required> </div>

<div class="mb-3">
    <label>အမျိုးအစား</label>
    <select name="category" class="form-select" required> <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
        <?php endforeach; ?>
    </select>
</div>
                <div class="mb-3">
                    <label class="form-label">ဆက်သွယ်ရန်ဖုန်း</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">လိပ်စာ</label>
                    <textarea name="address" class="form-control" rows="2" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">ဝန်ဆောင်မှုအကြောင်းအရာ</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">ဆိုင်ပုံတင်ရန်</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">ဆိုင်တင်မည်</button>
                    <a href="dashboard.php" class="btn btn-light">နောက်သို့</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>