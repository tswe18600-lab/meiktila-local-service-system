<?php
session_start();
require_once '../config/db.php';

if(!isset($_SESSION['admin_id'])) { 
    header("Location: login.php"); 
    exit(); 
}

// Category အသစ်ထည့်ခြင်း Logic
if (isset($_POST['add_category'])) {
    $name = $_POST['category_name'];
    $icon = $_POST['icon']; 
    $desc = $_POST['description'];

    $stmt = $pdo->prepare("INSERT INTO categories (category_name, icon, description) VALUES (?, ?, ?)");
    $stmt->execute([$name, $icon, $desc]);
    header("Location: categories.php");
    exit();
}

$categories = $pdo->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --sidebar-bg: #2d3748; --accent-color: #4299e1; }
        body { background-color: #9cbed5; font-family: 'Segoe UI', sans-serif; overflow-x: hidden; }
        
        /* Sidebar Design */
        .sidebar { height: 100vh; background: var(--sidebar-bg); color: white; position: fixed; width: var(--sidebar-width); z-index: 1000; transition: 0.3s; }
        .sidebar-header { padding: 30px 20px; text-align: center; background: rgba(0,0,0,0.1); }
        .nav-link { color: #a0aec0; padding: 15px 25px; display: flex; align-items: center; transition: 0.3s; border-left: 4px solid transparent; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: #4a5568; color: white; border-left-color: var(--accent-color); }
        
        .content { margin-left: var(--sidebar-width); padding: 40px; transition: 0.3s; }
        
        /* Mobile Layout Adjustments */
        @media (max-width: 991.98px) {
            .sidebar { margin-left: calc(var(--sidebar-width) * -1); }
            .sidebar.active { margin-left: 0; }
            .content { margin-left: 0; padding: 20px; }
            .mobile-nav { display: block !important; }
        }

        .custom-card { border: none; border-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); background: white; }
        .form-control { border-radius: 12px; padding: 12px; border: 1px solid #e2e8f0; font-size: 14px; }
        .icon-circle { width: 45px; height: 45px; background: #ebf8ff; color: #3182ce; display: flex; align-items: center; justify-content: center; border-radius: 12px; }
        
        .btn-primary { border-radius: 12px; padding: 12px; background: var(--accent-color); border: none; font-weight: 600; }
        .btn-danger-soft { background: #fff5f5; color: #e53e3e; border: none; border-radius: 10px; padding: 8px 12px; font-size: 13px; }
    </style>
</head>
<body>

<nav class="mobile-nav navbar navbar-dark bg-dark d-none p-3 shadow-sm sticky-top">
    <div class="container-fluid">
        <button class="navbar-toggler border-0" type="button" onclick="toggleSidebar()">
            <span class="navbar-toggler-icon"></span>
        </button>
        <span class="navbar-brand mb-0 h1 fs-6">Categories Manage</span>
    </div>
</nav>

<div class="sidebar shadow" id="sidebar">
    <div class="sidebar-header d-flex justify-content-between align-items-center">
        <h4 class="fw-bold mb-0 text-white">Meiktila <span class="text-info">Admin</span></h4>
        <button class="btn text-white d-lg-none" onclick="toggleSidebar()"><i class="fas fa-times"></i></button>
    </div>
    <div class="nav flex-column mt-3">
        <a href="dashboard.php" class="nav-link"><i class="fas fa-th-large me-2"></i> Dashboard</a>
        <a href="categories.php" class="nav-link active"><i class="fas fa-folder me-2"></i> Categories</a>
        <a href="services.php" class="nav-link"><i class="fas fa-store me-2"></i> Services</a>
        <a href="manage_bookings.php" class="nav-link"><i class="fas fa-calendar-alt me-2"></i> Manage Bookings</a>
        <a href="manage_users.php" class="nav-link"><i class="fas fa-user-cog me-2"></i> Manage Users</a>
        <a href="logout.php" class="nav-link text-danger mt-5"><i class="fas fa-power-off me-2"></i> Logout</a>
    </div>
</div>

<div class="content" id="content">
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Categories</h2>
        <p class="text-muted small">လုပ်ငန်းအမျိုးအစားများကို စီမံခန့်ခွဲပါ</p>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-4">
            <div class="custom-card p-4">
                <h6 class="fw-bold mb-4 text-primary"><i class="fas fa-plus-circle me-2"></i>Add New Category</h6>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">အမျိုးအစားအမည်</label>
                        <input type="text" name="category_name" class="form-control" placeholder="ဥပမာ - ဟိုတယ်" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Icon (FontAwesome)</label>
                        <input type="text" name="icon" class="form-control" placeholder="fa-hotel">
                        <small class="text-muted mt-1 d-block" style="font-size: 11px;">Ex: fa-hotel, fa-car, fa-cut</small>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">အကျဉ်းချုပ် (Description)</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <button type="submit" name="add_category" class="btn btn-primary w-100 shadow-sm">သိမ်းဆည်းမည်</button>
                </form>
            </div>
        </div>

        <div class="col-12 col-xl-8">
            <div class="custom-card p-0 overflow-hidden">
                <div class="p-4 border-bottom">
                    <h6 class="fw-bold mb-0">လုပ်ငန်းအမျိုးအစားများ စာရင်း</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="small text-muted text-uppercase">
                                <th class="border-0 px-4 py-3">Category</th>
                                <th class="border-0 py-3 d-none d-md-table-cell">Description</th>
                                <th class="border-0 text-end px-4 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($categories as $cat): ?>
                            <tr>
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle me-3">
                                            <i class="<?php echo !empty($cat['icon']) ? 'fas '.$cat['icon'] : 'fas fa-folder'; ?>"></i>
                                        </div>
                                        <div>
                                            <span class="fw-bold text-dark d-block"><?php echo $cat['category_name']; ?></span>
                                            <span class="text-muted d-md-none small" style="font-size: 11px;"><?php echo $cat['description']; ?></span>
                                        </div>
                                        </div>
                                </td>
                                <td class="d-none d-md-table-cell text-muted small">
                                    <?php echo !empty($cat['description']) ? $cat['description'] : '-'; ?>
                                </td>
                                <td class="text-end px-4">
                                    <a href="delete_category.php?id=<?php echo $cat['id']; ?>" 
                                       class="btn btn-danger-soft" 
                                       onclick="return confirm('ဖျက်မှာ သေချာပါသလား?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
    }
</script>

</body>
</html>