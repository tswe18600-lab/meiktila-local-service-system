<?php
session_start();
require_once '../config/db.php';

if(!isset($_SESSION['admin_id'])) { 
    header("Location: login.php"); 
    exit(); 
}

// ၁။ စုစုပေါင်း ဝန်ဆောင်မှု
$service_count = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();

// ၂။ ယနေ့အတွက် Booking
$booking_count = $pdo->query("SELECT COUNT(*) FROM bookings WHERE DATE(created_at) = CURDATE()")->fetchColumn();

// ၃။ စုစုပေါင်း Booking အားလုံး
$total_bookings = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();

// ၄။ Chart အတွက် အခြေအနေ
$count_confirmed = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'confirmed'")->fetchColumn();
$count_pending = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'pending'")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root { --sidebar-width: 260px; --sidebar-bg: #2d3748; --accent-color: #4299e1; }
        body { background-color: #9cbed5; font-family: 'Segoe UI', sans-serif; overflow-x: hidden; }
        
        /* Sidebar Styling */
        .sidebar { height: 100vh; background: var(--sidebar-bg); color: white; position: fixed; width: var(--sidebar-width); z-index: 1000; transition: 0.3s; }
        .sidebar-header { padding: 30px 20px; text-align: center; background: rgba(0,0,0,0.1); }
        .nav-link { color: #a0aec0; padding: 15px 25px; display: flex; align-items: center; transition: 0.3s; border-left: 4px solid transparent; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: #4a5568; color: white; border-left-color: var(--accent-color); }
        
        .content { margin-left: var(--sidebar-width); padding: 30px; transition: 0.3s; }

        /* Mobile Sidebar Toggle */
        @media (max-width: 991.98px) {
            .sidebar { margin-left: calc(var(--sidebar-width) * -1); }
            .sidebar.active { margin-left: 0; }
            .content { margin-left: 0; padding: 15px; }
            .mobile-nav { display: flex !important; }
        }

        /* Stats Cards */
        .stat-card { border: none; border-radius: 20px; padding: 25px; color: white; position: relative; overflow: hidden; transition: 0.3s; }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-icon { position: absolute; right: -10px; bottom: -10px; font-size: 70px; opacity: 0.2; }
        .bg-gradient-blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .bg-gradient-green { background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); }
        .bg-gradient-orange { background: linear-gradient(135deg, #ed8936 0%, #ed64a1 100%); }

        .chart-container { background: white; border-radius: 20px; padding: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<nav class="mobile-nav navbar navbar-dark bg-dark d-none p-3 shadow-sm sticky-top">
    <button class="navbar-toggler border-0" type="button" onclick="toggleSidebar()">
        <span class="navbar-toggler-icon"></span>
    </button>
    <span class="navbar-brand mb-0 h1 fs-6">Admin Panel</span>
</nav>

<div class="sidebar shadow" id="sidebar">
    <div class="sidebar-header d-flex justify-content-between align-items-center">
        <h4 class="fw-bold mb-0">Meiktila <span class="text-info">Admin</span></h4>
        <button class="btn text-white d-lg-none" onclick="toggleSidebar()"><i class="fas fa-times"></i></button>
    </div>
    <div class="nav flex-column mt-3">
        <a href="dashboard.php" class="nav-link active"><i class="fas fa-th-large me-2"></i> Dashboard</a>
        <a href="categories.php" class="nav-link"><i class="fas fa-folder me-2"></i> Categories</a>
        <a href="services.php" class="nav-link"><i class="fas fa-store me-2"></i> Services</a>
        <a href="manage_bookings.php" class="nav-link"><i class="fas fa-calendar-alt me-2"></i> Bookings</a>
        <a href="manage_users.php" class="nav-link"><i class="fas fa-user-cog me-2"></i> Manage Users</a>
        <a href="logout.php" class="nav-link text-danger mt-5"><i class="fas fa-power-off me-2"></i> Logout</a>
    </div>
</div>

<div class="content" id="content">
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3">
        <div>
            <h5 class="text-muted mb-1 fs-6">မင်္ဂလာပါ၊ <?= $_SESSION['admin_name']; ?></h5>
            <h2 class="fw-bold mb-0 h4">Dashboard Overview</h2>
        </div>
        <div class="text-md-end">
            <h6 class="fw-bold small"><i class="far fa-calendar-alt me-2"></i><?= date('d M Y'); ?></h6>
        </div>
    </div>
    
    <div class="row g-3">
        <div class="col-12 col-md-4">
            <div class="stat-card bg-gradient-blue shadow">
                <p class="mb-1 opacity-75 small">စုစုပေါင်း ဝန်ဆောင်မှု</p>
                <h2 class="fw-bold mb-0"><?= $service_count; ?> <small class="fs-6 fw-normal">ခု</small></h2>
                <i class="fas fa-briefcase stat-icon"></i>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="stat-card bg-gradient-green shadow">
                <p class="mb-1 opacity-75 small">ယနေ့ Booking</p>
                <h2 class="fw-bold mb-0"><?= $booking_count; ?> <small class="fs-6 fw-normal">ခု</small></h2>
                <i class="fas fa-bolt stat-icon"></i>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="stat-card bg-gradient-orange shadow">
                <p class="mb-1 opacity-75 small">စုစုပေါင်း Booking</p>
                <h2 class="fw-bold mb-0"><?= $total_bookings; ?> <small class="fs-6 fw-normal">ခု</small></h2>
                <i class="fas fa-chart-line stat-icon"></i>
            </div>
        </div>
    </div>

    <div class="row mt-4 g-4">
        <div class="col-12 col-lg-7">
            <div class="chart-container">
                <h6 class="fw-bold mb-4">Booking Analytics</h6>
                <div style="height: 250px;">
                    <canvas id="bookingChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-5">
            <div class="chart-container h-100">
                <h6 class="fw-bold mb-4">Quick Actions</h6>
                <div class="d-grid gap-2">
                    <a href="services.php" class="btn btn-light text-start p-3 border shadow-sm rounded-4 small">
                        <i class="fas fa-plus-circle text-primary me-2"></i> ဝန်ဆောင်မှုအသစ်
                    </a>
                    <a href="manage_bookings.php" class="btn btn-light text-start p-3 border shadow-sm rounded-4 small">
                        <i class="fas fa-clipboard-check text-success me-2"></i> ဘိုကင်များစစ်ဆေးရန်
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
    }

    const ctx = document.getElementById('bookingChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut', 
        data: {
            labels: ['Confirmed', 'Pending'],
            datasets: [{
                data: [<?= $count_confirmed; ?>, <?= $count_pending; ?>],
                backgroundColor: ['#48bb78', '#ecc94b'],
                borderWidth: 2
                }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    position: window.innerWidth < 768 ? 'bottom' : 'right',
                    labels: { usePointStyle: true, boxWidth: 10 }
                }
            },
            cutout: '70%'
        }
    });
</script>

</body>
</html>