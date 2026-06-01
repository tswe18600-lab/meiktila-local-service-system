<?php
session_start();
require_once '../config/db.php';

// ၁။ Login/Role စစ်ဆေးခြင်း
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'provider') {
    header("Location: ../login.php");
    exit();
}

$provider_id = $_SESSION['user_id'];

// ၂။ Statistics အတွက် အရေအတွက်များ တွက်ချက်ခြင်း
// စုစုပေါင်း ဆိုင်အရေအတွက်
$stmt_count = $pdo->prepare("SELECT COUNT(*) FROM services WHERE provider_id = ?");
$stmt_count->execute([$provider_id]);
$service_count = $stmt_count->fetchColumn();

// စောင့်ဆိုင်းဆဲ Booking အရေအတွက်
$stmt_pending = $pdo->prepare("SELECT COUNT(*) FROM bookings b JOIN services s ON b.service_id = s.id WHERE s.provider_id = ? AND b.status = 'pending'");
$stmt_pending->execute([$provider_id]);
$pending_count = $stmt_pending->fetchColumn();


// ၃။ Booking များ ဆွဲထုတ်ခြင်း (u.user_phone Error ပြင်ပြီးသား)
$query = "SELECT b.*, s.service_name, u.fullname as customer_name, b.user_phone as customer_phone
          FROM bookings b 
          JOIN services s ON b.service_id = s.id 
          JOIN users u ON b.user_id = u.id
          WHERE s.provider_id = ? 
          ORDER BY b.created_at DESC";

$stmt = $pdo->prepare($query);
$stmt->execute([$provider_id]);
$bookings = $stmt->fetchAll();

// ၄။ ဆိုင်ရှင် တင်ထားသော ဆိုင်စာရင်းကို ဆွဲထုတ်ခြင်း
$stmt_services = $pdo->prepare("SELECT * FROM services WHERE provider_id = ?");
$stmt_services->execute([$provider_id]);
$my_services = $stmt_services->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provider Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Pyidaungsu', sans-serif; background: #f0f2f5; }
        .status-badge { font-size: 0.8rem; padding: 5px 12px; }
        .card-custom { border: none; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .stat-card { border: none; border-radius: 15px; color: white; transition: 0.3s; }
        .stat-card:hover { transform: translateY(-5px); }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">ဆိုင်ရှင် Dashboard</h2>
<div>
    <a href="add_service.php" class="btn btn-primary btn-sm me-2">+ ဆိုင်အသစ်တင်ရန်</a>
    <a href="profile.php" class="btn btn-info btn-sm me-2 text-white">Profile ပြင်ရန်</a>
    <a href="../logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
</div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card stat-card bg-primary p-4 shadow-sm">
                    <h5 class="mb-1">ကျွန်ုပ်၏ ဝန်ဆောင်မှုများ</h5>
                    <h2 class="fw-bold mb-0"><?= $service_count ?> ခု</h2>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card stat-card bg-warning text-dark p-4 shadow-sm">
                    <h5 class="mb-1">စောင့်ဆိုင်းဆဲ Booking</h5>
                    <h2 class="fw-bold mb-0"><?= $pending_count ?> ခု</h2>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <h5 class="mb-3 fw-bold">ကျွန်ုပ်၏ ဝန်ဆောင်မှုများ</h5>
            <?php foreach ($my_services as $s): ?>
            <div class="col-md-3 mb-3">
                <div class="card card-custom p-2 text-center h-100">
                    <img src="../assets/img/services/<?= $s['image'] ?>" class="rounded-3" style="height:120px; object-fit:cover;">
                    <p class="mt-2 mb-2 fw-bold"><?= htmlspecialchars($s['service_name']) ?></p>
                    <div class="mt-auto d-flex justify-content-center gap-2">
                        <a href="edit_service.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-warning rounded-pill px-3">ပြင်ရန်</a>
                        <a href="delete_service.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('ဒီဆိုင်ကို ဖျက်မှာ သေချာပါသလား?')">ဖျက်ရန်</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if(empty($my_services)) echo "<div class='col-12'><p class='text-center py-3 bg-white rounded-3'>ဝန်ဆောင်မှု မရှိသေးပါ။</p></div>"; ?>
        </div>

        <div class="card card-custom overflow-hidden">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold text-primary">လာရောက်ထားသော Booking များ</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ဝန်ဆောင်မှု</th>
                            <th>ဝယ်ယူသူ</th>
                            <th>ဖုန်း</th>
                            <th>ရက်စွဲ</th>
                            <th>အခြေအနေ</th>
                            <th>လုပ်ဆောင်ချက်</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $b): ?>
                        <tr class="align-middle">
                            <td class="fw-bold"><?= htmlspecialchars($b['service_name']) ?></td>
                            <td><?= htmlspecialchars($b['customer_name']) ?></td>
                            <td><?= $b['customer_phone'] ?></td>
                            <td><?= date('d-M-Y', strtotime($b['booking_date'])) ?></td>
                            <td>
                                <?php if($b['status'] == 'pending'): ?>
                                    <span class="badge bg-warning text-dark status-badge">စောင့်ဆိုင်းဆဲ</span>
                                <?php elseif($b['status'] == 'confirmed'): ?>
                                    <span class="badge bg-success status-badge">အတည်ပြုပြီး</span>
                                <?php else: ?>
                                    <span class="badge bg-danger status-badge">ငြင်းပယ်ထား</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($b['status'] == 'pending'): ?>
                                    <a href="update_booking.php?id=<?= $b['id'] ?>&status=confirmed" class="btn btn-sm btn-success rounded-pill px-3">Confirm</a>
                                    <a href="update_booking.php?id=<?= $b['id'] ?>&status=rejected" class="btn btn-sm btn-outline-danger rounded-pill px-3">Reject</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($bookings)) echo "<tr><td colspan='6' class='text-center py-4'>Booking မရှိသေးပါ။</td></tr>"; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>