<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// ၁။ Dashboard Cards အတွက် အရေအတွက်များ တွက်ချက်ခြင်း
$total_bookings = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$pending_bookings = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'pending'")->fetchColumn();
$confirmed_bookings = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'confirmed'")->fetchColumn();

// ၂။ ဇယားထဲတွင် ပြရန် Booking အချက်အလက်များ ဆွဲထုတ်ခြင်း
$query = "SELECT b.*, s.service_name 
          FROM bookings b 
          JOIN services s ON b.service_id = s.id 
          ORDER BY b.created_at DESC";
$bookings = $pdo->query($query)->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --sidebar-bg: #2d3748; --accent-color: #4299e1; }
        body { background-color: #9cbed5; font-family: 'Segoe UI', sans-serif; }
        
        /* Sidebar Layout */
        .sidebar { height: 100vh; background: var(--sidebar-bg); color: white; position: fixed; width: 260px; z-index: 1000; }
        .sidebar-header { padding: 30px 20px; text-align: center; background: rgba(0,0,0,0.1); }
        .nav-link { color: #a0aec0; padding: 15px 25px; display: flex; align-items: center; transition: 0.3s; border-left: 4px solid transparent; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: #4a5568; color: white; border-left-color: var(--accent-color); }
        
        .content { margin-left: 260px; padding: 40px; }
        
        /* Card & Badge Styles */
        .custom-card { border: none; border-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); background: white; }
        .stat-card { border-radius: 15px; border: none; transition: 0.3s; color: white; }
        
        .status-badge { font-size: 0.75rem; padding: 6px 12px; border-radius: 10px; font-weight: 600; text-transform: uppercase; }
        .badge-pending { background-color: #fef3c7; color: #92400e; }
        .badge-confirmed { background-color: #d1fae5; color: #065f46; }
        .badge-rejected { background-color: #fee2e2; color: #991b1b; }
        
        .btn-action { border-radius: 8px; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; transition: 0.2s; }
    </style>
</head>
<body>

<div class="sidebar shadow">
    <div class="sidebar-header">
        <h4 class="fw-bold mb-0">Meiktila <span class="text-info">Admin</span></h4>
    </div>
    <div class="nav flex-column mt-3">
        <a href="dashboard.php" class="nav-link"><i class="fas fa-th-large me-2"></i> Dashboard</a>
        <a href="categories.php" class="nav-link"><i class="fas fa-folder me-2"></i> Categories</a>
        <a href="services.php" class="nav-link"><i class="fas fa-store me-2"></i> Services</a>
        <a href="manage_bookings.php" class="nav-link active"><i class="fas fa-calendar-alt me-2"></i> Manage Bookings</a>
                 <a href="manage_users.php" class="nav-link"><i class="fas fa-user-cog me-2"></i> Manage Users</a>

        <a href="logout.php" class="nav-link text-danger mt-5"><i class="fas fa-power-off me-2"></i> Logout</a>
    </div>
</div>

<div class="content">
    <div class="mb-5">
        <h2 class="fw-bold mb-1">Bookings Management</h2>
        <p class="text-muted">ဝင်ရောက်လာသော ဘိုကင်များအားလုံးကို စစ်ဆေးအတည်ပြုပါ</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card bg-primary p-4 shadow-sm">
                <h6 class="opacity-75">စုစုပေါင်း Booking</h6>
                <h2 class="fw-bold mb-0"><?php echo $total_bookings; ?> <small class="fs-6 fw-normal">ခု</small></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-warning p-4 shadow-sm text-dark">
                <h6 class="opacity-75">စောင့်ဆိုင်းဆဲ (Pending)</h6>
                <h2 class="fw-bold mb-0"><?php echo $pending_bookings; ?> <small class="fs-6 fw-normal">ခု</small></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-success p-4 shadow-sm">
                <h6 class="opacity-75">အတည်ပြုပြီး (Confirmed)</h6>
                <h2 class="fw-bold mb-0"><?php echo $confirmed_bookings; ?> <small class="fs-6 fw-normal">ခု</small></h2>
            </div>
        </div>
    </div>

    <div class="custom-card p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr class="small text-muted text-uppercase">
                        <th class="border-0 px-4">Booking ID</th>
                        <th class="border-0">Shop / Service</th>
                        <th class="border-0">Customer</th>
                        <th class="border-0">Date</th>
                        <th class="border-0">Status</th>
                        <th class="border-0 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $b): ?>
                    <tr>
                        <td class="px-4 fw-bold text-muted">#<?php echo $b['id']; ?></td>
                        <td><span class="fw-bold text-dark"><?php echo $b['service_name']; ?></span></td>
                        <td>
                            <div class="small fw-bold text-dark"><?php echo $b['user_name']; ?></div>
                            <div class="small text-muted"><i class="fas fa-phone-alt me-1"></i><?php echo $b['user_phone']; ?></div>
                        </td>
                        <td><span class="small text-muted fw-bold"><?php echo date('d M Y', strtotime($b['booking_date'])); ?></span></td>
                        <td>
                            <span class="status-badge badge-<?php echo $b['status']; ?>">
                                <?php echo $b['status']; ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="update_status.php?id=<?php echo $b['id']; ?>&status=confirmed" 
                                   class="btn btn-success btn-action" title="Confirm">
                                    <i class="fas fa-check"></i>
                                </a>
                                <a href="update_status.php?id=<?php echo $b['id']; ?>&status=rejected" 
                                   class="btn btn-danger btn-action" title="Reject">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($bookings)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-calendar-times fa-3x text-light mb-3"></i>
                                <p class="text-muted">ဘိုကင်တင်ထားသူ မရှိသေးပါ။</p>
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