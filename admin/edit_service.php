<?php
session_start();
require_once '../config/db.php';
if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
$stmt->execute([$id]);
$service = $stmt->fetch();

if (isset($_POST['update_service'])) {
    $name = $_POST['service_name'];
    $phone = $_POST['phone'];
    $description = $_POST['description'];
    $address = $_POST['address'];
    $category_id = $_POST['category_id'];

    // ပုံဟောင်းတွေကို အခြေခံထားမယ်
    $img1 = $service['image'];
    $img2 = $service['image2'];
    $img3 = $service['image3'];

    $target_dir = "../assets/img/services/";

    // ပုံ (၁) ပြင်ဆင်ခြင်း
    if (isset($_FILES['image1']) && $_FILES['image1']['error'] == 0) {
        $img1 = time() . "_1_" . $_FILES['image1']['name'];
        move_uploaded_file($_FILES['image1']['tmp_name'], $target_dir . $img1);
    }

    // ပုံ (၂) ပြင်ဆင်ခြင်း
    if (isset($_FILES['image2']) && $_FILES['image2']['error'] == 0) {
        $img2 = time() . "_2_" . $_FILES['image2']['name'];
        move_uploaded_file($_FILES['image2']['tmp_name'], $target_dir . $img2);
    }

    // ပုံ (၃) ပြင်ဆင်ခြင်း
    if (isset($_FILES['image3']) && $_FILES['image3']['error'] == 0) {
        $img3 = time() . "_3_" . $_FILES['image3']['name'];
        move_uploaded_file($_FILES['image3']['tmp_name'], $target_dir . $img3);
    }

    // Database Update လုပ်ခြင်း
    $sql = "UPDATE services SET category_id=?, service_name=?, phone=?, description=?, address=?, image=?, image2=?, image3=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$category_id, $name, $phone, $description, $address, $img1, $img2, $img3, $id])) {
        header("Location: services.php?msg=updated");
        exit();
    }
}

// အမျိုးအစားများ ဆွဲထုတ်ရန်
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .preview-img { width: 100px; height: 100px; object-fit: cover; border-radius: 10px; margin-top: 10px; }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5 mb-5">
    <div class="card shadow p-4 border-0" style="border-radius: 20px;">
        <h3 class="fw-bold mb-4">ဝန်ဆောင်မှု ပြင်ဆင်ရန်</h3>
        <form method="POST" enctype="multipart/form-data"> <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">အမျိုးအစား</label>
                    <select name="category_id" class="form-select">
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $service['category_id']) ? 'selected' : '' ?>>
                                <?= $cat['category_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">ဆိုင်အမည်</label>
                    <input type="text" name="service_name" value="<?= $service['service_name'] ?>" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">ဖုန်းနံပါတ်</label>
                <input type="text" name="phone" value="<?= $service['phone'] ?>" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">လိပ်စာ</label>
                <textarea name="address" class="form-control" rows="2"><?= $service['address'] ?></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">အသေးစိတ်ဖော်ပြချက်</label>
                <textarea name="description" class="form-control" rows="3"><?= $service['description'] ?></textarea>
            </div>
            <hr>
            <h5 class="mb-3">ဆိုင်ပုံများ ပြင်ဆင်ရန်</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="small text-muted">ပုံ (၁)</label>
                    <input type="file" name="image1" class="form-control">
                    <?php if($service['image']): ?>
                        <img src="../assets/img/services/<?= $service['image'] ?>" class="preview-img border">
                    <?php endif; ?>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="small text-muted">ပုံ (၂)</label>
                    <input type="file" name="image2" class="form-control">
                    <?php if($service['image2']): ?>
                        <img src="../assets/img/services/<?= $service['image2'] ?>" class="preview-img border">
                    <?php endif; ?>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="small text-muted">ပုံ (၃)</label>
                    <input type="file" name="image3" class="form-control">
                    <?php if($service['image3']): ?>
                        <img src="../assets/img/services/<?= $service['image3'] ?>" class="preview-img border">
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" name="update_service" class="btn btn-primary px-5 py-2 rounded-pill">
                    <i class="fas fa-save me-2"></i>ပြင်ဆင်ချက်များ သိမ်းမည်
                </button>
                <a href="services.php" class="btn btn-light px-5 py-2 rounded-pill border">မလုပ်တော့ပါ</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>