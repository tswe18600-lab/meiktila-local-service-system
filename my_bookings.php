<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$u_id = $_SESSION['user_id'];

try {
    $query = "SELECT b.*, s.service_name, s.image 
              FROM bookings b 
              INNER JOIN services s ON b.service_id = s.id 
              WHERE b.user_id = ? 
              ORDER BY b.created_at DESC";
              
    $stmt = $pdo->prepare($query);
    $stmt->execute([$u_id]);
    $my_bookings = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ကျွန်ုပ်၏ Booking များ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, sans-serif; }
        .page-header { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); color: white; padding: 40px 0; margin-bottom: 30px; border-radius: 0 0 30px 30px; }
        .booking-card { border-radius: 20px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: 0.3s; }
        .booking-card:hover { transform: translateY(-5px); }
        .table thead th { background-color: #f8f9fa; border-top: none; color: #6c757d; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px; }
        .table tbody td { padding: 20px 15px; vertical-align: middle; border-bottom: 1px solid #eee; }
        
        /* Status Badges */
        .status-pill { padding: 6px 16px; border-radius: 50px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
        .status-pending { background-color: #fff8e1; color: #f59e0b; border: 1px solid #ffeebc; }
        .status-confirmed { background-color: #ecfdf5; color: #10b981; border: 1px solid #d1fae5; }
        .status-rejected { background-color: #fef2f2; color: #ef4444; border: 1px solid #fee2e2; }
        
        .service-icon { width: 45px; height: 45px; background: #e7f1ff; color: #0d6efd; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px; }
    </style>
</head>
<body>

<div class="page-header shadow">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-calendar-check me-2"></i>ကျွန်ုပ်၏ Booking များ</h2>
            <p class="mb-0 opacity-75 small">သင်တင်ထားသော ဝန်ဆောင်မှုများကို ဤနေရာတွင် စစ်ဆေးနိုင်ပါသည်။</p>
        </div>
        <a href="index.php" class="btn btn-light rounded-pill px-4 fw-bold text-primary shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>ပင်မစာမျက်နှာ
        </a>
    </div>
</div>

<div class="container mb-5">
    <div class="card booking-card overflow-hidden">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">ဝန်ဆောင်မှု</th>
                        <th>ရက်စွဲ</th>
                        <th>အခြေအနေ</th>
                        <th class="text-end pe-4">မှတ်ချက်</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($my_bookings) > 0): ?>
                        <?php foreach ($my_bookings as $b): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="service-icon">
                                        <i class="fas fa-store"></i>
                                        </div>
                                    <div>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($b['service_name']) ?></div>
                                        <div class="text-muted" style="font-size: 0.7rem;">ID: #<?= $b['id'] ?> | <?= date('d M Y', strtotime($b['created_at'])) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-dark fw-semibold" style="font-size: 0.9rem;">
                                    <i class="far fa-calendar-alt me-2 text-primary"></i>
                                    <?= date('d M Y', strtotime($b['booking_date'])) ?>
                                </div>
                            </td>
                            <td>
                                <span class="status-pill status-<?= strtolower($b['status']) ?>">
                                    <i class="fas fa-circle me-1" style="font-size: 7px;"></i>
                                    <?= ucfirst($b['status']) ?>
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <span class="text-muted small italic"><?= $b['notes'] ? htmlspecialchars($b['notes']) : '-' ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" style="width: 100px; opacity: 0.5;" class="mb-3">
                                <h5 class="text-muted">ဘိုကင်စာရင်း မရှိသေးပါ။</h5>
                                <a href="index.php" class="btn btn-primary btn-sm mt-3 rounded-pill px-4">အခုပဲ ဘိုကင်တင်ပါ</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>