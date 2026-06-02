<?php 
session_start();
require_once 'config/db.php'; 




// --- Weather Live Data Logic ---
$city = "Meiktila";
$api_key = "f2c89110bd7002b17f8c444363dfc7fd"; // သင်ပေးထားတဲ့ Key ကို ထည့်လိုက်ပါပြီ
$url = "https://api.openweathermap.org/data/2.5/weather?q=$city&units=metric&appid=$api_key";

$response = @file_get_contents($url);
$data = json_decode($response, true);

if ($data && $data['cod'] == 200) {
    $temp = round($data['main']['temp']); // မိတ္ထီလာရဲ့ အပြင်က အပူချိန်အစစ်
    $icon = $data['weather'][0]['icon']; // ရာသီဥတုအလိုက် ပြောင်းမည့်ပုံ
} else {
    // API အလုပ်မလုပ်သေးလျှင် (သို့မဟုတ်) Key မပွင့်သေးလျှင် ပြမည့် Default
    $temp = "N/A"; 
    $icon = "01d";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meiktila Local Services - ရှာဖွေပါ၊ ကြိုတင်မှာယူပါ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pyidaungsu:wght@400;700&display=swap');

        :root { 
            --primary-blue: #004e92; 
            --accent-gold: #FFD700;
        }
        
        body { 
            background-color: #f4f7fa; 
            font-family: 'Pyidaungsu', 'Segoe UI', sans-serif; 
        }

        /* Navbar Styling */
        .navbar {
            background: rgba(0, 78, 146, 0.95) !important;
            backdrop-filter: blur(10px);
            transition: 0.3s;
        }
        .nav-link { font-weight: 500; transition: 0.3s; }
        .nav-link:hover { color: var(--accent-gold) !important; }

        /* Hero Section with Meiktila Background */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.3)), 
                        url('assets/img/services/meiktila.jpg'); /* မိထ္ထီလာကန် ပုံရိပ် */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 95vh;
            display: flex;
            align-items: center;
            color: white;
        }

        /* Modern Search Box */
        .search-container {
            background: rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: 20px;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px 20px;
            border: none;
        }
        .btn-search {
            background: linear-gradient(45deg, #004e92, #000428);
            color: white;
            border-radius: 12px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-search:hover {
            transform: scale(1.05);
            color: var(--accent-gold);
        }

        /* Category Card Styling */
        .category-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            transition: 0.4s;
            border: none;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }
        .category-card:hover {
            transform: translateY(-15px);
            background: var(--primary-blue);
            color: white;
        }
        .category-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: var(--primary-blue);
            transition: 0.4s;
        }
        .category-card:hover i { color: var(--accent-gold); }
        <style>
    html {
        scroll-behavior: smooth;
    }
    
    /* Navbar က အပေါ်မှာ ကပ်နေတဲ့အတွက် (Sticky) 
       ရောက်သွားတဲ့အခါ ခေါင်းစဉ်ကွယ်မနေအောင် ပိုပေးတာပါ */
    #categories-section {
        scroll-margin-top: 80px; 
    }
</style>
    </style>
    <link rel="manifest" href="manifest.json">

<script>
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('service-worker.js')
        .then(reg => console.log('Service Worker Registered!'))
        .catch(err => console.log('Registration Failed!', err));
    });
  }
</script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="index.php">
            <i class="fas fa-city me-2 text-warning"></i>Meiktila <span class="text-warning">Hub</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto"> <li class="nav-item px-2">
                    <a class="nav-link active" href="index.php">
                        <i class="fas fa-home me-1"></i> ပင်မစာမျက်နှာ
                    </a>
                </li>
                
                <li class="nav-item px-2 border-md-start">
                    <a class="nav-link" href="all_categories.php">
                        <i class="fas fa-th-large me-1"></i> ဝန်ဆောင်မှုအမျိုးအစားများ
                    </a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link" href="information.php">
                        <i class="fas fa-concierge-bell me-1"></i> အချက်အလက်စုံစမ်းရန်
                    </a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link" href="meiktila.php">
                        <i class="fas fa-info-circle me-1"></i> မြို့အကြောင်း
                    </a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link" href="contact.php">
                        <i class="fas fa-phone-alt me-1"></i> ဆက်သွယ်ရန်
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center mt-3 mt-lg-0">
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="dropdown">
                        <a class="btn btn-warning rounded-pill dropdown-toggle px-4 fw-bold shadow-sm d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
    <?php if(!empty($_SESSION['user_image'])): ?>
        <img src="uploads/profile/<?php echo $_SESSION['user_image']; ?>" class="rounded-circle me-2" style="width: 25px; height: 25px; object-fit: cover; border: 1px solid #fff;">
    <?php else: ?>
        <i class="fas fa-user-circle me-2"></i>
    <?php endif; ?>
    
    <?php echo $_SESSION['user_name']; ?>
</a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3">
                            <li><a class="dropdown-item py-2" href="my_bookings.php"><i class="fas fa-calendar-check me-2 text-primary"></i>My Bookings</a></li>
                            <li><a class="dropdown-item py-2" href="profile.php"><i class="fas fa-user-edit me-2 text-primary"></i>Profile Settings</a></li>
                            <li><a class="dropdown-item py-2" href="my_favorites.php"><i class="fas fa-heart me-2 text-primary"></i>My Favorites</a></li>

                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="text-white text-decoration-none me-4 fw-bold small">LOGIN</a>
                    <a href="register.php" class="btn btn-warning rounded-pill px-4 fw-bold shadow-sm">SIGN UP</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

       
<div class="hero-section">
    
    <div class="container">
        
        <div class="row align-items-center">
            <div class="col-lg-7 mb-5 mb-lg-0">
                <h1 class="display-3 fw-bold mb-3 animateanimated animatefadeInDown">
                    မိတ္ထီလာမြို့ရဲ့ <br><span class="text-warning">အကောင်းဆုံး</span> ဝန်ဆောင်မှုများ
                </h1>
                <p class="lead mb-4 opacity-90">စားသောက်ဆိုင်၊ ဟိုတယ်၊ ကျန်းမာရေးနှင့် လူမှုရေးဝန်ဆောင်မှုများကို အချိန်မရွေး၊ နေရာမရွေး လွယ်ကူစွာ ရှာဖွေကြိုတင်မှာယူလိုက်ပါ။</p>
                <div class="d-flex gap-3">
                    <a href="check_login.php" class="btn btn-warning btn-lg rounded-pill px-4 fw-bold shadow">ခုပဲစတင်မယ်</a>
                    <a href="About.php" class="btn btn-outline-light btn-lg rounded-pill px-4">ပိုမိုလေ့လာရန်</a>
                </div>
            </div>
            
            <div class="col-lg-5">
                
                <div class="search-container animateanimated animatefadeInRight">
                    <div style="
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(5px);
        padding: 4px 12px;
        border-radius: 30px;
        border: 1px solid rgba(255,255,255,0.2);
        color: white;
        display: flex;
        align-items: center;
        gap: 8px;
    ">
        <i class="fas fa-sun text-warning" style="font-size: 14px;"></i>
        <span style="font-size: 13px; font-weight: bold;"><?php echo $temp; ?>°C</span>
    </div>
                    <h4 class="text-white mb-4"><i class="fas fa-search me-2"></i>မြန်မြန်ရှာဖွေပါ</h4>
                    <form action="search_results.php" method="GET">
                        <div class="mb-3">
                            <select name="category" class="form-select">
                                <option value="">အမျိုးအစား ရွေးချယ်ပါ</option>
                                
                                <?php
                                $stmt_cat = $pdo->query("SELECT * FROM categories");
                                while($cat = $stmt_cat->fetch()) {
                                    echo "<option value='".$cat['id']."'>".$cat['category_name']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="query" class="form-control" placeholder="ဝန်ဆောင်မှုအမျိုးအစားအမည်(အတိကျသိလျှင်)">
                        </div>
                        
                        <button type="submit" class="btn btn-search w-100 py-3 mt-2">
                            <i class="fas fa-search me-2"></i>ရှာဖွေပါ
                        </button>
                    </form>
                    
                </div>
                
            </div>
        </div>
        
    </div>
    
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>