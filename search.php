<?php
require_once 'config/db.php';

$search_query = isset($_GET['query']) ? $_GET['query'] : '';

// Database ထဲမှာ ဆိုင်နာမည် (service_name) သို့မဟုတ် အမျိုးအစား (category_name) နဲ့ တိုက်စစ်မယ်
$sql = "SELECT s.*, c.category_name 
        FROM services s 
        JOIN categories c ON s.category_id = c.id 
        WHERE s.service_name LIKE ? OR c.category_name LIKE ? OR s.description LIKE ?";

$stmt = $pdo->prepare($sql);
$search_term = "%$search_query%";
$stmt->execute([$search_term, $search_term, $search_term]);
$results = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ရှာဖွေမှုရလဒ် - <?php echo htmlspecialchars($search_query); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php"><i class="fa fa-arrow-left"></i> နောက်သို့</a>
            <span class="navbar-text text-white">"<?php echo htmlspecialchars($search_query); ?>" အတွက် ရှာဖွေမှုရလဒ်များ</span>
        </div>
    </nav>

    <div class="container my-5">
        <h4 class="mb-4">ရှာဖွေတွေ့ရှိသည့် ရလဒ် (<?php echo count($results); ?>) ခု</h4>

        <div class="row g-4">
            <?php if (count($results) > 0): ?>
                <?php foreach($results as $sv): ?>
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0 p-3" style="border-radius: 15px;">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4">
                                <?php if(!empty($sv['image'])): ?>
                                    <img src="assets/img/services/<?php echo $sv['image']; ?>" class="img-fluid rounded-3" alt="Service Image">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/300x200?text=No+Image" class="img-fluid rounded-3">
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8 ps-3">
                                <span class="badge bg-info text-dark mb-2"><?php echo $sv['category_name']; ?></span>
                                <h4 class="fw-bold text-primary mb-1"><?php echo $sv['service_name']; ?></h4>
                                <p class="text-muted small mb-2"><i class="fa fa-map-marker-alt"></i> <?php echo $sv['address']; ?></p>
                                <a href="tel:<?php echo $sv['phone']; ?>" class="btn btn-outline-success btn-sm mt-2">
                                    <i class="fa fa-phone"></i> <?php echo $sv['phone']; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5 mt-5">
                    <i class="fa-solid fa-magnifying-glass fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">စိတ်မကောင်းပါဘူး၊ သင်ရှာဖွေနေတဲ့အရာ မတွေ့ရှိပါ။</h5>
                    <p>တခြားစကားလုံးဖြင့် ထပ်မံရှာဖွေကြည့်ပါ။</p>
                    <a href="index.php" class="btn btn-primary mt-3">မူလစာမျက်နှာသို့ ပြန်သွားမည်</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>