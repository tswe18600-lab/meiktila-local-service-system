<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'provider') {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];
$provider_id = $_SESSION['user_id'];

// လက်ရှိဆိုင်အချက်အလက်ကို အရင်ယူမယ်
$stmt = $pdo->prepare("SELECT * FROM services WHERE id = ? AND provider_id = ?");
$stmt->execute([$id, $provider_id]);
$service = $stmt->fetch();

if (!$service) { die("Service not found!"); }

// Category များဆွဲထုတ်ရန် (Dropdown အတွက်)
$cat_stmt = $pdo->query("SELECT * FROM categories ORDER BY category_name ASC");
$categories = $cat_stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['service_name']);
    $cat_id = $_POST['category_id'];
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $desc = trim($_POST['description']);
    
    // ပုံအသစ်တင်မတင် စစ်မယ်
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/img/services/" . $image_name);
    } else {
        $image_name = $service['image']; // ပုံအသစ်မတင်ရင် အဟောင်းအတိုင်းထားမယ်
    }

    try {
        $sql = "UPDATE services SET category_id=?, service_name=?, phone=?, address=?, description=?, image=? WHERE id=? AND provider_id=?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$cat_id, $name, $phone, $address, $desc, $image_name, $id, $provider_id])) {
            header("Location: dashboard.php?msg=Updated");
            exit();
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Service</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card p-4 mx-auto" style="max-width: 600px;">
            <h3>ဆိုင်အချက်အလက် ပြင်ဆင်ရန်</h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label>ဆိုင်အမည်</label>
                    <input type="text" name="service_name" class="form-control" value="<?= $service['service_name'] ?>" required>
                </div>
                <div class="mb-3">
                    <label>အမျိုးအစား</label>
                    <select name="category_id" class="form-select" required>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $service['category_id']) ? 'selected' : '' ?>>
                                <?= $cat['category_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>ဖုန်း</label>
                    <input type="text" name="phone" class="form-control" value="<?= $service['phone'] ?>" required>
                </div>
                <div class="mb-3">
                    <label>လိပ်စာ</label>
                    <textarea name="address" class="form-control"><?= $service['address'] ?></textarea>
                </div>
                <div class="mb-3">
                    <label>လက်ရှိပုံ</label><br>
                    <img src="../assets/img/services/<?= $service['image'] ?>" width="100" class="mb-2 rounded">
                    <input type="file" name="image" class="form-control">
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Update လုပ်မည်</button>
            </form>
        </div>
    </div>
</body>
</html>