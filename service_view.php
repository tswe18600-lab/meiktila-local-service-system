<?php 
session_start();
require_once 'config/db.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // ဆိုင်အချက်အလက်ကို ဆွဲထုတ်မယ်
    $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
    $stmt->execute([$id]);
    $sv = $stmt->fetch();

    if(!$sv) {
        die("ဝန်ဆောင်မှု ရှာမတွေ့ပါ။");
    }

    // ၁။ ပျမ်းမျှ Rating ကို တွက်ချက်ခြင်း (သင်၏ ရှိရင်းစွဲကုဒ်)
    $stmt_avg = $pdo->prepare("SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM reviews WHERE service_id = ?");
    $stmt_avg->execute([$id]);
    $rating_data = $stmt_avg->fetch();
    $average = round($rating_data['avg_rating'], 1);
    $total_reviews = $rating_data['total_reviews'];

    // --- ဤနေရာမှစ၍ ကူးယူထည့်သွင်းပါ (ဘိုကင်တင်သည့် Logic) ---
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_now'])) {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $booking_date = $_POST['booking_date'];
        $user_phone = trim($_POST['user_phone']);
        $notes = trim($_POST['notes']);

        // လူဦးရေ ကန့်သတ်ချက် စစ်ဆေးခြင်း
        $check_sql = "SELECT COUNT(*) FROM bookings WHERE service_id = ? AND booking_date = ? AND status = 'confirmed'";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute([$id, $booking_date]);
        $confirmed_count = $check_stmt->fetchColumn();

        // အရင်က ပုံသေရေးထားတဲ့ $max_limit = 5; အစား
// $sv ဆိုတာ သင်ဆွဲထုတ်ထားတဲ့ ဆိုင်အချက်အလက် variable ဖြစ်ပါတယ်
$max_limit = $sv['max_bookings_per_day']; 

if ($confirmed_count >= $max_limit) {
    echo "<script>alert('စိတ်မရှိပါနဲ့၊ ဒီဆိုင်က တစ်ရက်ကို " . $max_limit . " ယောက်ပဲ လက်ခံပါတယ်။ ဒီရက်မှာ လူပြည့်သွားပါပြီ။'); window.history.back();</script>";
    exit();
}

        try {
            $sql = "INSERT INTO bookings (user_id, service_id, booking_date, user_phone, notes, status) VALUES (?, ?, ?, ?, ?, 'pending')";
            $stmt_book = $pdo->prepare($sql);
            if ($stmt_book->execute([$user_id, $id, $booking_date, $user_phone, $notes])) {
                echo "<script>alert('ဘိုကင်တင်ခြင်း အောင်မြင်ပါသည်။'); window.location='my_bookings.php';</script>";
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
    // --- ဤနေရာအထိသာ ကူးပါ ---

} else {
    header("Location: index.php");
    exit();
}

// Review များကို ဆွဲထုတ်ခြင်း
$rev_stmt = $pdo->prepare("SELECT r.*, u.fullname FROM reviews r 
                           JOIN users u ON r.user_id = u.id 
                           WHERE r.service_id = ? 
                           ORDER BY r.created_at DESC");
$rev_stmt->execute([$id]);
$reviews = $rev_stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $sv['service_name']; ?> - မိတ္ထီလာဝန်ဆောင်မှု</title>
    
    <link href="https://mmwebfonts.comquas.com/fonts/pyidaungsu.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { 
            background-color: #f4f7f6; 
            font-family: 'Pyidaungsu', sans-serif !important; 
        }
        .detail-card { border-radius: 25px; border: none; overflow: hidden; background: #fff; }
        .service-img { height: 450px; object-fit: cover; width: 100%; }
        .booking-form { background: white; border-radius: 25px; padding: 30px; position: sticky; top: 20px; border: 1px solid #eee; }
        .review-card { border-radius: 15px; border: none; background: #fff; transition: 0.3s; margin-bottom: 15px; }
        .star-rating { color: #ffc107; font-size: 1.2rem; }
        .avg-box { background: #fff8e1; padding: 15px; border-radius: 15px; display: inline-flex; align-items: center; }
        .btn-primary { border-radius: 12px; padding: 12px; font-weight: bold; }
        .form-control, .form-select { border-radius: 12px; padding: 10px 15px; border: 1px solid #ddd; }
    </style>
</head>
<body>

<div class="container my-5">
    <a href="javascript:history.back()" class="btn btn-light mb-4 rounded-pill px-4 shadow-sm">
        <i class="fas fa-arrow-left me-2 text-primary"></i>နောက်သို့
    </a>

    <div class="row g-4">
        <div class="col-lg-7">
<div id="serviceCarousel" class="carousel slide" data-bs-ride="carousel">
    
    <?php if (!empty($sv['image2'])): ?>
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#serviceCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#serviceCarousel" data-bs-slide-to="1"></button>
        <?php if (!empty($sv['image3'])): ?>
            <button type="button" data-bs-target="#serviceCarousel" data-bs-slide-to="2"></button>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="assets/img/services/<?= htmlspecialchars($sv['image']) ?>" class="d-block w-100" style="height: 450px; object-fit: cover;">
        </div>

        <?php if (!empty($sv['image2'])): ?>
        <div class="carousel-item">
            <img src="assets/img/services/<?= htmlspecialchars($sv['image2']) ?>" class="d-block w-100" style="height: 450px; object-fit: cover;">
        </div>
        <?php endif; ?>

        <?php if (!empty($sv['image3'])): ?>
        <div class="carousel-item">
            <img src="assets/img/services/<?= htmlspecialchars($sv['image3']) ?>" class="d-block w-100" style="height: 450px; object-fit: cover;">
        </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($sv['image2'])): ?>
    <button class="carousel-control-prev" type="button" data-bs-target="#serviceCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#serviceCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
    <?php endif; ?>

                <div class="card-body p-4">
                    <h1 class="fw-bold text-dark mb-2"><?php echo $sv['service_name']; ?></h1>
                    
                    <?php if($total_reviews > 0): ?>
                    <div class="avg-box mb-3 border border-warning">
                        <span class="fw-bold fs-3 text-warning me-2"><?= $average ?></span>
                        <div>
                            <div class="star-rating">
                                <?php 
                                for($i=1; $i<=5; $i++) {
                                    if($i <= $average) echo '★';
                                    elseif($i-0.5 <= $average) echo '½';
                                    else echo '☆';
                                }
                                ?>
                            </div>
                            <small class="text-muted">(စုစုပေါင်းမှတ်ချက် <?= $total_reviews ?> ခု)</small>
                        </div>
                    </div>
                    <?php endif; ?>

                    <p class="text-muted"><i class="fas fa-map-marker-alt me-2 text-danger"></i><?php echo $sv['address']; ?></p>
                    <hr>
                    <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-info"></i>ဝန်ဆောင်မှုအကြောင်း</h5>
                    <p class="text-secondary" style="line-height: 1.8;"><?php echo nl2br($sv['description']); ?></p>
                    
                    <div class="mt-4">
                        <a href="tel:<?php echo $sv['phone']; ?>" class="btn btn-success rounded-pill px-4 py-2 shadow-sm">
                            <i class="fas fa-phone-alt me-2"></i>ဖုန်းဆက်ရန်: <?php echo $sv['phone']; ?>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h4 class="fw-bold mb-4">သုံးစွဲသူများ၏ မှတ်ချက်များ</h4>
                
                <div class="card shadow-sm p-4 mb-4 border-0" style="border-radius: 20px; background: #eef2f3;">
                    <h6 class="fw-bold mb-3">သင့်ရဲ့ အတွေ့အကြုံကို ဝေမျှပါ</h6>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <form action="post_review.php" method="POST">
                            <input type="hidden" name="service_id" value="<?= $sv['id'] ?>">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold">အမှတ်ပေးပါ</label>
                                    <select name="rating" class="form-select" required>
                                        <option value="5">⭐️⭐️⭐️⭐️⭐️ (အလွန်ကောင်း)</option>
                                        <option value="4">⭐️⭐️⭐️⭐️ (ကောင်း)</option>
                                        <option value="3">⭐️⭐️⭐️ (သင့်တင့်)</option>
                                        <option value="2">⭐️⭐️ (ညံ့)</option>
                                        <option value="1">⭐️ (အလွန်ညံ့)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <textarea name="comment" class="form-control" rows="3" placeholder="ဒီဆိုင်ရဲ့ ဝန်ဆောင်မှုအပေါ် သင့်အမြင်ကို ရေးပေးပါ..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Review တင်မည်</button>
                        </form>
                    <?php else: ?>
                        <div class="text-center py-3 bg-white rounded-3 border">
                            <p class="text-muted mb-0 small">Review ရေးရန် <a href="login.php" class="fw-bold text-primary">Login</a> အရင်ဝင်ပါ။</p>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (count($reviews) > 0): ?>
                    <?php foreach ($reviews as $rev): ?>
                        <div class="card review-card shadow-sm p-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold"><i class="fas fa-user-circle me-2 text-primary"></i><?= htmlspecialchars($rev['fullname']) ?></span>
                                <span class="star-rating">
                                    <?php for($i=1; $i<=5; $i++) echo ($i <= $rev['rating']) ? '★' : '☆'; ?>
                                </span>
                            </div>
                            <p class="mb-2 text-dark"><?= htmlspecialchars($rev['comment']) ?></p>
                            <small class="text-muted" style="font-size: 11px;">
                                <i class="far fa-clock me-1"></i><?= date('d M Y, h:i A', strtotime($rev['created_at'])) ?>
                            </small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-5 bg-white rounded-4 shadow-sm border border-dashed">
                        <p class="text-muted mb-0">မှတ်ချက် မရှိသေးပါ။ ပထမဆုံးမှတ်ချက်ပေးသူ ဖြစ်လာပါ!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="booking-form shadow-sm border-0">
                <h4 class="fw-bold mb-4 text-center text-primary">ဒီဆိုင်ကို Booking တင်မည်</h4>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <form action="includes/booking_process.php" method="POST">
                        <input type="hidden" name="service_id" value="<?php echo $sv['id']; ?>">
                        
                         <div class="mb-3">
                            <label class="form-label small fw-bold">သင့်အမည်</label>
                            <input type="text" name="customer_name" class="form-control rounded-pill" 
                                   value="<?php echo $_SESSION['user_name']; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">ဆက်သွယ်ရန် ဖုန်းနံပါတ်</label>
                            <input type="tel" name="phone" class="form-control" placeholder="၀၉xxxxxxxxx" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">လာရောက်မည့် ရက်စွဲ</label>
                            <input type="date" name="booking_date" class="form-control" min="<?= date('Y-m-d') ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">အခြားဖြည့်စွက်ချက် (ရှိလျှင်)</label>
                            <textarea name="note" class="form-control" rows="3" placeholder="ဘာတွေပြုပြင်ချင်လဲ ပြောပြပေးပါ..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 shadow">
                            Booking တင်ရန် အတည်ပြုပါ
                        </button>
                    </form>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-user-lock fa-4x text-muted mb-4 opacity-50"></i>
                        <h5 class="fw-bold">Login လိုအပ်ပါသည်</h5>
                        <p class="text-muted px-4 small mb-4">Booking တင်ရန်အတွက် သင်၏ အကောင့်သို့ အရင်ဝင်ပေးပါ။</p>
                        <a href="login.php" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">Login ဝင်ရန်</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: 'ကျေးဇူးတင်ပါသည်!',
                text: 'သင်၏ မှတ်ချက်ကို မှတ်တမ်းတင်လိုက်ပါပြီ။',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                // URL ထဲက success=1 ကို ပြန်ဖြုတ်ပစ်ဖို့
                let url = new URL(window.location.href);
                url.searchParams.delete('success');
                window.history.replaceState({}, document.title, url.pathname + url.search);
            });
        </script>
    <?php endif; ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>