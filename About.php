<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discover Meiktila - Meiktila Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary-color: #2c3e50; --accent-color: #f39c12; }
        body { font-family: 'Pyidaungsu', sans-serif; background-color: #f8f9fa; }
        
        /* Hero Section */
        .about-hero {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('assets/img/services/htla1.jpg');
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }

        /* Section Styling */
        .content-section { padding: 80px 0; }
        .section-title { font-weight: 800; color: var(--primary-color); margin-bottom: 40px; position: relative; }
        .section-title::after { content: ''; width: 60px; height: 4px; background: var(--accent-color); position: absolute; bottom: -10px; left: 0; }
        
        /* City Icon Grid */
        .city-feature { background: white; padding: 30px; border-radius: 15px; border-bottom: 5px solid var(--accent-color); height: 100%; transition: 0.3s; }
        .city-feature:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
        .city-feature i { font-size: 2.5rem; color: var(--accent-color); margin-bottom: 20px; }

        /* Statistics Section */
        .stat-box { background: var(--primary-color); color: white; padding: 50px 0; }
        .stat-number { font-size: 2.5rem; font-weight: bold; color: var(--accent-color); }
    </style>
</head>
<body>

    <header class="about-hero">
        <div class="container">
            <h1 class="display-2 fw-bold">Discover Meiktila Service</h1>
        </div>
    </header>

    <section class="content-section container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                   <h2 class="fw-bold mb-4">ကျွန်ုပ်တို့၏ ရည်ရွယ်ချက်</h2>
                <p class="text-muted" style="line-height: 1.8;">
                    Meiktila Hub ကို မိတ္ထီလာမြို့သူ/သားများနှင့် ဧည့်သည်တော်များအတွက် မြို့တွင်းရှိ အဓိကဝန်ဆောင်မှုများကို လွယ်ကူလျင်မြန်စွာ ရှာဖွေနိုင်ရန် ရည်ရွယ်တည်ဆောက်ထားခြင်း ဖြစ်ပါသည်။ ဆေးရုံ၊ ဆေးခန်းများမှစ၍ ခရီးသွားလာရေးအတွက် အဝေးပြေးကားဂိတ်များ၊ စားသောက်ဆိုင်များနှင့် အထင်ကရနေရာများကို စနစ်တကျ အမျိုးအစားခွဲခြား ပြသပေးထားပါသည်။
                </p>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6"><img src="assets/img/services/htla2.jpg" class="img-fluid rounded shadow" alt="Landmark"></div>
                    <div class="col-6"><img src="assets/img/services/meiktilabackground.jpg" class="img-fluid rounded shadow" alt="City"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white content-section">
        <div class="container">
            <h2 class="section-title text-center mx-auto" style="left: 0; right: 0; display: table;">မြို့ပြ၏ အဓိက ကဏ္ဍများ</h2>
            <div class="row g-4 mt-4">
                <div class="col-md-4">
                    <div class="city-feature">
                        <i class="fas fa-water"></i>
                        <h4>မိတ္ထီလာကန်</h4>
                        <p>မြို့၏ အသက်သွေးကြောဖြစ်သော မိတ္ထီလာကန်သည် လည်ပတ်စရာ နေရာကောင်းတစ်ခုဖြစ်ပြီး ကန်သာယာနှင့် ကရဝိတ်ဖောင်တော်ဦးတို့မှာ အထူးထင်ရှားသည်။</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="city-feature">
                        <i class="fas fa-university"></i>
                        <h4>ပညာရေးအချက်အခြာ</h4>
                        <p>မိတ္ထီလာသည် ကွန်ပျူတာတက္ကသိုလ်၊ နည်းပညာတက္ကသိုလ်နှင့် လေကြောင်းပညာရပ်ဆိုင်ရာ တက္ကသိုလ်များ တည်ရှိရာ ပညာရေးဗဟိုချက်ဖြစ်သည်။</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="city-feature">
                        <i class="fas fa-map-marked-alt"></i>
                        <h4>လမ်းဆုံလမ်းခွ</h4>
                        <p>ရန်ကုန်-မန္တလေး လမ်းမကြီးပေါ်တွင် တည်ရှိပြီး ရှမ်းပြည်နယ်နှင့် အောက်မြန်မာပြည်ကို ဆက်သွယ်ပေးသော အဓိက လမ်းဆုံမြို့ဖြစ်သည်။</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stat-box">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-number">၅၀+</div>
                    <p>ဝန်ဆောင်မှု လုပ်ငန်းများ</p>
                </div>
                <div class="col-md-3">
                    <div class="stat-number">၁၀၀၀+</div>
                    <p>နေ့စဉ် အသုံးပြုသူများ</p>
                </div>

                <div class="col-md-3">
                    <div class="stat-number">၁၀+</div>
                    <p>အမျိုးအစား ကဏ္ဍများ</p>
                </div>
                
        </div>
    </section>

    <section class="content-section container">
        <div class="row">
            <div class="col-md-12 text-center mb-5">
                <h2 class="fw-bold">ဘာကြောင့် Meiktila Hub ကို သုံးသင့်သလဲ?</h2>
            </div>
            <div class="col-md-4 text-center">
                <i class="fas fa-search fa-3x mb-3 text-warning"></i>
                <h5>လျင်မြန်စွာ ရှာဖွေနိုင်ခြင်း</h5>
                <p class="text-muted">သင်လိုချင်သော ဝန်ဆောင်မှုကို စက္ကန့်ပိုင်းအတွင်း ရှာတွေ့နိုင်သည်။</p>
            </div>
            <div class="col-md-4 text-center">
                <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                <h5>မှန်ကန်သော အချက်အလက်</h5>
                <p class="text-muted">အတည်ပြုပြီးသား ဝန်ဆောင်မှုပေးသူများ၏ အချက်အလက်ကိုသာ ဖော်ပြသည်။</p>
            </div>
            <div class="col-md-4 text-center">
                <i class="fas fa-mobile-alt fa-3x mb-3 text-info"></i>
                <h5>လွယ်ကူသော အသုံးပြုမှု</h5>
                <p class="text-muted">မည်သည့် Device ဖြင့်မဆို အလွယ်တကူ အသုံးပြုနိုင်သော UI Design ဖြစ်သည်။</p>
            </div>
        </div>
        <div class="text-center mt-5">
            <a href="index.php" class="btn btn-dark btn-lg px-5 shadow">အခုပဲ စတင်အသုံးပြုပါ</a>
        </div>
    </section>

    
<section class="content-section" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); padding: 60px 0;">
    <div class="container text-center text-white">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="mb-4">
                    <i class="fas fa-users-cog fa-3x text-warning mb-3"></i>
                    <h2 class="fw-bold mb-3">ကျွန်ုပ်တို့၏ တီထွင်ဖန်တီးသူများကို သိရှိလိုပါသလား?</h2>
                    <p class="lead opacity-75">Meiktila Hub ကို အကောင်းဆုံးဖြစ်အောင် ဖန်တီးခဲ့ကြတဲ့ ကျွန်ုပ်တို့ရဲ့ Developer Team အဖွဲ့ဝင် ၁၅ ဦးလုံးကို တစ်နေရာတည်းမှာ ကြည့်ရှုနိုင်ပါတယ်။</p>
                </div>
                
                <a href="team.php" class="btn btn-warning btn-lg rounded-pill px-5 py-3 shadow-lg fw-bold transition-link">
                    <i class="fas fa-eye me-2"></i> အဖွဲ့ဝင်များအားလုံးကို ကြည့်ရန်
                </a>
            </div>
        </div>
    </div>
</section>

<style>
    .transition-link {
        transition: all 0.3s ease;
    }
    .transition-link:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(243, 156, 18, 0.4) !important;
        background-color: #e67e22 !important;
    }
</style>
    <footer class="py-4 text-center bg-dark text-white-50">
        <p>&copy; 2026 Meiktila Hub - မြို့ပြဝန်ဆောင်မှု လမ်းညွှန်။</p>
    </footer>
</body>
</html>