<?php 
session_start();
require_once 'config/db.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Meiktila Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');

        :root { 
            --primary: #004e92; 
            --secondary: #000428;
            --accent: #FFD700;
            --text-main: #2d3436;
        }

        body { 
            background: #f8fbff;
            font-family: 'Pyidaungsu', sans-serif; 
            color: var(--text-main);
        }

        /* Hero Header Section */
        .hero-section {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
            padding: 80px 0 120px;
            clip-path: ellipse(150% 100% at 50% 0%);
            color: white;
            position: relative;
        }

.home-icon {
            color: white;
            font-size: 24px;
            text-decoration: none;
            transition: 0.3s;
        }
        .home-icon:hover {
            color: #ffcc00; /* Mouse တင်ရင် အရောင်ပြောင်းမယ် */
        }

        /* Content ပိုင်း */
        .container {
            padding: 40px;
            text-align: center;
        }

        /* ၂။ အောက်က ခလုတ် (သူဖြစ်ချင်တဲ့နေရာ) */
        .back-home-btn {
            display: inline-block;
            margin-top: 40px;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-size: 14px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }        /* Modern Category Card */
        .cat-card {
            background: white;
            border-radius: 24px;
            padding: 35px 20px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            border: 1px solid #f0f0f0;
            position: relative;
            z-index: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .cat-card::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 24px;
            opacity: 0;
            z-index: -1;
            transition: opacity 0.4s ease;
        }

        .cat-card:hover {
            transform: translateY(-10px);
            border-color: transparent;
        }

        .cat-card:hover::before {
            opacity: 1;
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: #f0f7ff;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            transition: 0.4s;
            color: var(--primary);
        }

        .cat-card:hover .icon-box {
            background: rgba(255, 255, 255, 0.2);
            color: var(--accent);
            transform: rotate(-10deg);
        }

        .cat-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 5px;
            transition: 0.3s;
        }

        .cat-card:hover .cat-title {
            color: white;
        }

        .cat-count {
            font-size: 0.85rem;
            color: #636e72;
            transition: 0.3s;
        }

        .cat-card:hover .cat-count {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Layout Grid */
        .category-grid {
            margin-top: -60px; /* Header ထဲကို Card လေးတွေ နည်းနည်း ဝင်နေအောင် */
        }
    </style>
</head>
<body>
    <header class="hero-section text-center">
        <div class="container">
            <a href="index.php" class="home-icon" title="ပင်မစာမျက်နှာ">
            <i class="fa-solid fa-house"></i> </a>
            <h1 class="fw-bold display-4 mb-2">ဝန်ဆောင်မှု အမျိုးအစားများ</h1>
            <p class="opacity-75 lead">သင်ရှာဖွေနေသည့် လုပ်ငန်းများကို အမျိုးအစားအလိုက် အလွယ်တကူကြည့်ရှုပါ</p>
        </div>
        
    </header>

    <div class="container mb-5 category-grid">
        
        <div class="row g-4">
            <?php
            try {
                // Category တစ်ခုချင်းစီမှာရှိတဲ့ Service အရေအတွက်ကိုပါ တစ်ခါတည်း တွက်ထုတ်ထားပါတယ်
                $query = "SELECT c.*, COUNT(s.id) as total_services 
                          FROM categories c 
                          LEFT JOIN services s ON c.id = s.category_id 
                          GROUP BY c.id 
                          ORDER BY c.category_name ASC";
                $stmt = $pdo->query($query);
                
                while($cat = $stmt->fetch()): 
            ?>
            <div class="col-6 col-md-4 col-lg-3">
                
                <a href="category_details.php?id=<?= $cat['id'] ?>" class="text-decoration-none d-block h-100">
                    <div class="cat-card shadow-sm text-center">
                        <div class="icon-box shadow-sm">
                            <i class="fa-solid <?= htmlspecialchars($cat['icon']) ?> fa-2x"></i>
                        </div>
                        <h6 class="cat-title mb-1"><?= htmlspecialchars($cat['category_name']) ?></h6>
                        <span class="cat-count"><?= $cat['total_services'] ?> ဝန်ဆောင်မှု</span>
                    </div>
                </a>
            </div>
            
            <?php 
                endwhile; 
            } catch (PDOException $e) {
                echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
            }
            ?>
        </div>
        <a href="index.php" class="back-home-btn">
            <i class="fa-solid fa-arrow-left"></i> ပင်မစာမျက်နှာသို့ ပြန်သွားမည်
        </a>
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>