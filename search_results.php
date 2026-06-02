<?php
include 'config/db.php';

// Header ဖိုင်မရှိရင် အခြေခံ setup ကို အောက်ပါအတိုင်း သုံးပါ
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results - Meiktila Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --main-bg: #f0f2f5;
            --glass: rgba(255, 255, 255, 0.8);
            --accent: #0062ff;
        }

        body { 
            background-color: var(--main-bg); 
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #1c1e21;
        }

        /* ပုံကို ပိုမြင်သာစေရန် Full Width Card Style */
        .result-item {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            height: 100%;
        }

        .result-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.12);
        }

        /* ပုံကို ပိုကြီးကြီးပြသခြင်း */
        .image-wrapper {
            position: relative;
            width: 100%;
            padding-top: 65%; /* Aspect Ratio 16:10 ခန့် */
            overflow: hidden;
        }

        .image-wrapper img {
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* ပုံမရှုံ့အောင် အပြည့်ဖြည့်ခြင်း */
            transition: transform 0.6s ease;
        }

        .result-item:hover img {
            transform: scale(1.08);
        }

        .category-pill {
            position: absolute;
            bottom: 12px;
            left: 12px;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            color: white;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .info-content {
            padding: 20px;
        }

        .service-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #050505;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .location-text {
            color: #65676b;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 12px;
        }

        .btn-action {
            background: #e7f3ff;
            color: var(--accent);
            border: none;
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.2s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-action:hover {
            background: var(--accent);
            color: white;
        }

        .section-header {
            padding: 40px 0;
            background: white;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
        }

        /* No Result Section */
        .no-data {
            text-align: center;
            padding: 80px 20px;
        }
    </style>
</head>
<body>

<div class="section-header shadow-sm">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">ရှာဖွေမှု ရလဒ်များ</h4>
                <p class="text-muted mb-0 small">မိထ္ထီလာမြို့ရှိ အကောင်းဆုံး ဝန်ဆောင်မှုများကို တွေ့ရှိရပါသည်</p>
            </div>
            <a href="index.php" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                <i class="fas fa-search me-1"></i> ပြန်ရှာမည်
            </a>
        </div>
    </div>
</div>

<div class="container mb-5">
    <?php
    $query = isset($_GET['query']) ? trim($_GET['query']) : '';
    $category = isset($_GET['category']) ? $_GET['category'] : '';

    $sql = "SELECT s.*, c.category_name 
            FROM services s 
            JOIN categories c ON s.category_id = c.id 
            WHERE (s.service_name LIKE ? OR s.description LIKE ?)";
    $params = ["%$query%", "%$query%"];
    if (!empty($category)) { $sql .= " AND s.category_id = ?"; $params[] = $category; }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $results = $stmt->fetchAll();

    if (count($results) > 0): ?>
        <div class="row g-4">
            <?php foreach ($results as $row): ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="result-item">
                        <div class="image-wrapper">
                            <img src="assets/img/services/<?= !empty($row['image']) ? $row['image'] : 'default.jpg' ?>" alt="">
                            <div class="category-pill shadow-sm">
                                <?= htmlspecialchars($row['category_name']) ?>
                            </div>
                        </div>
                        <div class="info-content">
                            <h3 class="service-title"><?= htmlspecialchars($row['service_name']) ?></h3>
                            <div class="location-text">
                                <i class="fas fa-map-marker-alt text-danger"></i>
                                <?= htmlspecialchars($row['address'] ?? 'မိထ္ထီလာမြို့') ?>
                            </div>
                            <p class="text-muted small mb-4" style="height: 40px; overflow: hidden;">
                                <?= mb_strimwidth(strip_tags($row['description']), 0, 80, "...") ?>
                            </p>
                            <a href="service_view.php?id=<?= $row['id'] ?>" class="btn btn-action">
                                အသေးစိတ်ကြည့်မည်
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="no-data">
            <i class="far fa-frown fa-4x mb-3 text-muted"></i>
            <h3>ရှာဖွေမှု မတွေ့ရှိပါ</h3>
            <p class="text-muted">စာလုံးပေါင်း ပြန်စစ်ကြည့်ပါ သို့မဟုတ် အခြားစကားလုံး သုံးကြည့်ပါ။</p>
            <a href="index.php" class="btn btn-primary mt-3">ပြန်လည်ရှာဖွေရန်</a>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>