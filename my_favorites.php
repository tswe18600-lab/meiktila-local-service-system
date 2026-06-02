<?php
session_start();

// Database Connection - အမြဲတမ်း Connection ကို သေချာစစ်ပါ
$conn = mysqli_connect("localhost", "root", "", "meiktila_service_db"); 

if (!$conn) {
    die("<div class='alert alert-danger'>Database ချိတ်ဆက်မှု မအောင်မြင်ပါ: " . mysqli_connect_error() . "</div>");
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Favorites နဲ့ Services ကို Join ပြီး ပိုမိုမြန်ဆန်အောင် ဆွဲထုတ်ခြင်း
$query = "SELECT services.* FROM services 
          JOIN favorites ON services.id = favorites.service_id 
          WHERE favorites.user_id = '$user_id' 
          ORDER BY favorites.id DESC"; // နောက်ဆုံးသိမ်းတာ အရင်ပြမယ်
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ကျွန်ုပ်၏ စိတ်ကြိုက်စာရင်း - Meiktila Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #007bff;
            --heart-color: #ff4757;
        }
        body { font-family: 'Pyidaungsu', sans-serif; background-color: #f8f9fa; }
        
        .back-home-btn {
            display: inline-flex;
            align-items: center;
            margin: 20px 0;
            padding: 10px 20px;
            background: #fff;
            color: var(--primary-color);
            text-decoration: none;
            border-radius: 50px;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: 0.3s;
            border: 1px solid #eee;
        }
        .back-home-btn:hover {
            background: var(--primary-color);
            color: #fff;
            transform: translateX(-5px);
        }

        /* Service Card Styling */
        .service-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(.25,.8,.25,1);
            background: #fff;
        }
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }
        .card-img-wrapper {
            position: relative;
            height: 200px;
            overflow: hidden;
        }
        .card-img-top {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }
        .service-card:hover .card-img-top {
            transform: scale(1.1);
        }

        /* Badge for Price or Category */
        .category-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(0, 123, 255, 0.9);
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 12px;
            backdrop-filter: blur(5px);
        }

        .btn-view {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
            padding: 10px;
            font-weight: 500;
        }
        
        h2.title {
            font-weight: 800;
            color: #2d3436;
            position: relative;
            display: inline-block;
        }
        h2.title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 4px;
            background: var(--heart-color);
            border-radius: 10px;
        }
        
.btn-remove-fav {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    color: #ff4757; /* အနီရောင် */
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.3s;
    cursor: pointer;
    z-index: 10;
}
.btn-remove-fav:hover {
    background: #ff4757;
    color: white;
    transform: scale(1.1) rotate(10deg);
}

    </style>
</head>
<body>

<div class="container py-4">
    <a href="index.php" class="back-home-btn">
        <i class="fa-solid fa-arrow-left me-2"></i> ပင်မသို့ ပြန်သွားမည်
    </a>
    <div class="row align-items-center mb-5 mt-3">
        <div class="col-12 text-center text-md-start">
            <h2 class="title"><i class="fas fa-heart text-danger me-2"></i>ကျွန်ုပ်၏ စိတ်ကြိုက်များ</h2>
            <p class="text-muted mt-2">မိတ္ထီလာမြို့ရှိ သင်နှစ်သက်သော ဝန်ဆောင်မှုများကို ဤနေရာတွင် စုစည်းပေးထားပါသည်။</p>
        </div>
    </div>

    <div class="row">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while($sv = mysqli_fetch_assoc($result)): ?>
                <div class="col-lg-4 col-md-6 mb-4 animateanimated animatefadeInUp">
                    <div class="card h-100 shadow-sm service-card">
                       <div class="card-img-wrapper">
    <img src="assets/img/services/<?php echo $sv['image'] ?: 'default.jpg'; ?>" class="card-img-top">
    <span class="category-badge"><i class="fa-solid fa-star me-1"></i> Saved</span>
    
    <button onclick="removeFromFavorite(<?php echo $sv['id']; ?>)" 
            class="btn-remove-fav shadow-sm" 
            title="စာရင်းမှ ပယ်ဖျက်မည်">
        <i class="fa-solid fa-heart"></i>
    </button>
</div>
                        
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-2"><?php echo htmlspecialchars($sv['service_name']); ?></h5>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i> 
                                <?php echo htmlspecialchars($sv['address']); ?>
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="service_view.php?id=<?php echo $sv['id']; ?>" class="btn btn-primary btn-view w-100 rounded-pill shadow-sm">
                                    အသေးစိတ်ကြည့်ရှုမည် <i class="fa-solid fa-chevron-right ms-2 small"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="empty-state shadow-sm bg-white p-5 rounded-4 border">
                    <i class="fa-solid fa-heart-circle-xmark fa-4x text-light mb-3" style="color: #dee2e6 !important;"></i>
                    <h4 class="fw-bold text-muted">စာရင်းမရှိသေးပါ</h4>
                    <p class="text-secondary mb-4">သင်နှစ်သက်သော ဝန်ဆောင်မှုများကို Bookmark လုပ်ထားခြင်း မရှိသေးပါ။</p>
                    <a href="all_categories.php" class="btn btn-primary px-4 py-2 rounded-pill">
                        ဝန်ဆောင်မှုများ သွားရှာမည်
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function removeFromFavorite(serviceId) {
    if(confirm('ဤဝန်ဆောင်မှုကို စိတ်ကြိုက်စာရင်းမှ ဖျက်မှာ သေချာပါသလား?')) {
        $.ajax({
            url: 'toggle_favorite.php', // အရင်က သုံးခဲ့တဲ့ဖိုင်ကိုပဲ ပြန်သုံးလို့ရပါတယ်
            type: 'POST',
            data: { service_id: serviceId },
            success: function(response) {
                location.reload(); // ဒေတာဖျက်ပြီးတာနဲ့ Page ကို refresh လုပ်ပြီး စာရင်းပြန်စစ်မယ်
            }
        });
    }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>