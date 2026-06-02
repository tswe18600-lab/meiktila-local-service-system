<?php
// ... (PHP code အပိုင်းတွေက အတူတူပဲမို့လို့ မပြောင်းလဲပါဘူး)
session_start(); 
$showBack = false;
if(isset($_GET['from']) && $_GET['from'] === 'information') $showBack = true;

$backUrl = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'all_categories.php';
$is_logged_in = isset($_SESSION['user_id']);

require_once 'config/db.php';

if (isset($_GET['id'])) {
    $cat_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT category_name FROM categories WHERE id = ?");
    $stmt->execute([$cat_id]);
    $category = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT * FROM services WHERE category_id = ?");
    $stmt->execute([$cat_id]);
    $services = $stmt->fetchAll();
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $category['category_name']; ?> - Meiktila Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* နောက်ခံကို Gradient ပြောင်းခြင်း */
        body {
            background: linear-gradient(135deg, #96c2f8 0%, #38addc 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Navbar ကို အကြည်ရောင်စပ်ပြီး Glassmorphism လုပ်ခြင်း */
        .navbar {
            background: rgba(13, 110, 253, 0.9) !important;
            backdrop-filter: blur(10px);
        }

        /* Service Card များကို ပိုလှအောင် ပြင်ဆင်ခြင်း */
        .service-card {
            border: none;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
        }

        .btn-wishlist {
            border: none;
            background: #fff;
            color: #ff4757;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .btn-wishlist:hover {
            background: #ff4757;
            color: white;
            transform: scale(1.1);
        }

        .img-service {
            border-radius: 15px;
            object-fit: cover;
            height: 160px;
            width: 100%;
            transition: 0.5s;
        }
        .service-card:hover .img-service {
            transform: scale(1.05);
        }

        .section-title {
            color: #2d3436;
            font-weight: 800;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
        }

        /* ဖုန်းနဲ့ကြည့်ရင် Card တွေကြား ခြားနားမှု */
        @media (max-width: 768px) {
            .img-service { height: 200px; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo $backUrl; ?>">
                <i class="fa fa-arrow-left me-2"></i> နောက်သို့
            </a>
            <span class="navbar-text text-white fw-bold d-none d-md-inline">
                <?php echo $category['category_name']; ?>
            </span>
        </div>
    </nav>

    <div class="container my-5">
        <div class="text-center mb-5">
            <h2 class="section-title mb-2"><?php echo $category['category_name']; ?></h2>
            <div class="mx-auto" style="width: 60px; height: 4px; background: #0d6efd; border-radius: 2px;"></div>
        </div>

        <div class="row g-4">
            <?php if (count($services) > 0): ?>
                <?php foreach($services as $sv): ?>
                <div class="col-lg-6">
                    <div class="card service-card h-100 p-3 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4 position-relative">
                                <?php 
                                    $imgPath = "assets/img/services/" . $sv['image'];
                                    $finalImg = (!empty($sv['image']) && file_exists($imgPath)) ? $imgPath : "https://via.placeholder.com/300x200?text=No+Photo";
                                ?>
                                <img src="<?php echo $finalImg; ?>" class="img-service shadow-sm">
                            </div>
                            
                            <div class="col-md-8 ps-md-4 mt-3 mt-md-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h4 class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($sv['service_name']); ?></h4>
                                    <button class="btn-wishlist rounded-circle" onclick="toggleFavorite(<?php echo $sv['id']; ?>)" style="width: 40px; height: 40px;">
                                        <i class="<?php echo ($is_logged_in) ? 'far' : 'far'; ?> fa-heart" id="heart-<?php echo $sv['id']; ?>"></i>
                                    </button>
                                </div>
                                
                                <p class="text-primary small fw-bold mb-2">
                                    <i class="fa fa-map-marker-alt me-1"></i> <?php echo htmlspecialchars($sv['address']); ?>
                                </p>
                                
                                <p class="text-muted small mb-3 text-truncate-2">
                                    <?php echo htmlspecialchars($sv['description']); ?>
                                </p>

                                <div class="d-flex gap-2">
                                    <a href="tel:<?php echo $sv['phone']; ?>" class="btn btn-outline-success btn-sm rounded-pill px-3">
                                        <i class="fa fa-phone me-1"></i> ဆက်သွယ်ရန်
                                    </a>
                                    <a href="service_view.php?id=<?php echo $sv['id']; ?>" class="btn btn-primary btn-sm rounded-pill px-3 flex-grow-1">
                                        Booking တင်ရန် <i class="fas fa-chevron-right ms-1 small"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <div class="bg-white p-5 rounded-4 shadow-sm border">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">ဤအမျိုးအစားတွင် ဝန်ဆောင်မှုများ မရှိသေးပါ။</h5>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// ... (toggleFavorite JavaScript function အပိုင်းက အတူတူပါပဲ)
function toggleFavorite(serviceId) {
    $.ajax({
        url: 'toggle_favorite.php',
        type: 'POST',
        data: { service_id: serviceId },
        success: function(response) {
            try {
                let data = JSON.parse(response);
                let heartIcon = $('#heart-' + serviceId);
                if (data.status === 'added') {
                    heartIcon.removeClass('far').addClass('fas');
                    alert('Favorite ထဲ ထည့်လိုက်ပါပြီ!');
                } else if (data.status === 'removed') {
                    heartIcon.removeClass('fas').addClass('far');
                    alert('Favorite ထဲက ပြန်ဖြုတ်လိုက်ပါပြီ!');
                } else if (data.status === 'unauthorized') {
                    alert('အရင်ဆုံး Login ဝင်ပေးပါ!');
                }
            } catch(e) { console.error("Error parsing JSON", e); }
        }
    });
}
</script>
</body>
</html>