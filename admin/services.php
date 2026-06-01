<?php
session_start();
require_once '../config/db.php';
if(!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }

// ဆိုင်အချက်အလက် အသစ်ထည့်ခြင်း
if (isset($_POST['add_service'])) {
    $category_id = $_POST['category_id'];
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    
    $images = ["", "", ""]; 
    $input_names = ['service_image', 'service_image2', 'service_image3'];

    foreach ($input_names as $index => $field_name) {
        if (isset($_FILES[$field_name]) && $_FILES[$field_name]['error'] == 0) {
            $new_name = time() . "_" . $index . "_" . $_FILES[$field_name]['name'];
            $target_path = "../assets/img/services/" . $new_name;

            if (!is_dir("../assets/img/services/")) {
                mkdir("../assets/img/services/", 0777, true);
            }
            if (move_uploaded_file($_FILES[$field_name]['tmp_name'], $target_path)) {
                $images[$index] = $new_name; 
            }
        }
    }

    $stmt = $pdo->prepare("INSERT INTO services (category_id, service_name, description, address, phone, image, image2, image3) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$category_id, $service_name, $description, $address, $phone, $images[0], $images[1], $images[2]]);
    
    header("Location: services.php");
    exit();
}
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
$services = $pdo->query("SELECT s.*, c.category_name FROM services s JOIN categories c ON s.category_id = c.id ORDER BY s.id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --sidebar-bg: #2d3748; --accent-color: #4299e1; }
        body { background-color: #9cbed5; font-family: 'Segoe UI', sans-serif; overflow-x: hidden; }
        
        /* Sidebar Design */
        .sidebar { height: 100vh; background: var(--sidebar-bg); color: white; position: fixed; width: var(--sidebar-width); z-index: 1000; transition: 0.3s; }
        .sidebar-header { padding: 30px 20px; text-align: center; background: rgba(0,0,0,0.1); }
        .nav-link { color: #a0aec0; padding: 15px 25px; display: flex; align-items: center; transition: 0.3s; border-left: 4px solid transparent; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: #4a5568; color: white; border-left-color: var(--accent-color); }
        
        .content { margin-left: var(--sidebar-width); padding: 40px; transition: 0.3s; }
        
        /* Mobile Layout */
        @media (max-width: 991.98px) {
            .sidebar { margin-left: calc(var(--sidebar-width) * -1); }
            .sidebar.active { margin-left: 0; }
            .content { margin-left: 0; padding: 20px; }
            .mobile-nav { display: block !important; }
        }

        .custom-card { border: none; border-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); background: white; }
        .form-control, .form-select { border-radius: 12px; padding: 10px; border: 1px solid #e2e8f0; font-size: 14px; }
        .service-img { width: 40px; height: 40px; border-radius: 8px; object-fit: cover; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .badge-cat { background: #ebf8ff; color: #3182ce; padding: 5px 10px; border-radius: 8px; font-size: 12px; font-weight: 600; }
        .btn-action { border-radius: 10px; width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; }
    </style>
</head>
<body>
    <nav class="mobile-nav navbar navbar-dark bg-dark d-none p-3 shadow-sm sticky-top">
    <div class="container-fluid">
        <button class="navbar-toggler border-0" type="button" onclick="toggleSidebar()">
            <span class="navbar-toggler-icon"></span>
        </button>
        <span class="navbar-brand mb-0 h1 fs-6">Services Manage</span>
    </div>
</nav>

<div class="sidebar shadow" id="sidebar">
    <div class="sidebar-header d-flex justify-content-between align-items-center">
        <h4 class="fw-bold mb-0 text-white">Meiktila <span class="text-info">Admin</span></h4>
        <button class="btn text-white d-lg-none" onclick="toggleSidebar()"><i class="fas fa-times"></i></button>
    </div>
    <div class="nav flex-column mt-3">
        <a href="dashboard.php" class="nav-link"><i class="fas fa-th-large me-2"></i> Dashboard</a>
        <a href="categories.php" class="nav-link"><i class="fas fa-folder me-2"></i> Categories</a>
        <a href="services.php" class="nav-link active"><i class="fas fa-store me-2"></i> Services</a>
        <a href="manage_bookings.php" class="nav-link"><i class="fas fa-calendar-alt me-2"></i> Manage Bookings</a>
        <a href="manage_users.php" class="nav-link"><i class="fas fa-user-cog me-2"></i> Manage Users</a>
        <a href="logout.php" class="nav-link text-danger mt-5"><i class="fas fa-power-off me-2"></i> Logout</a>
    </div>
</div>

<div class="content" id="content">
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Services</h2>
        <p class="text-muted small">ဝန်ဆောင်မှုများနှင့် ဆိုင်များကို စီမံခန့်ခွဲပါ</p>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-4">
            <div class="custom-card p-4">
                <h6 class="fw-bold mb-4 text-primary"><i class="fas fa-plus-circle me-2"></i>Add New Service</h6>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">အမျိုးအစား</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- ရွေးချယ်ပါ --</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">ဆိုင်အမည်</label>
                        <input type="text" name="service_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">ဖုန်းနံပါတ်</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <label class="small text-muted fw-bold">ပုံ (၁)</label>
                            <input type="file" name="service_image" class="form-control form-control-sm">
                        </div>
                        <div class="col-4">
                            <label class="small text-muted fw-bold">ပုံ (၂)</label>
                            <input type="file" name="service_image2" class="form-control form-control-sm">
                        </div>
                        <div class="col-4">
                            <label class="small text-muted fw-bold">ပုံ (၃)</label>
                            <input type="file" name="service_image3" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">လိပ်စာ</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">အသေးစိတ်</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                    <button type="submit" name="add_service" class="btn btn-primary w-100 shadow-sm">သိမ်းဆည်းမည်</button>
                </form>
            </div>
        </div>

        <div class="col-12 col-xl-8">
            <div class="custom-card p-0 overflow-hidden">
                <div class="p-4 border-bottom">
                    <h6 class="fw-bold mb-0">ဆိုင်စာရင်းများ</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="small text-muted text-uppercase">
                                <th class="border-0 px-4 py-3">Service / Shop</th>
                                <th class="border-0 py-3 d-none d-md-table-cell">Category</th>
                                <th class="border-0 text-end px-4 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($services as $s): ?>
                            <tr>
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 d-flex overflow-hidden">
                                            <img src="../assets/img/services/<?= !empty($s['image']) ? $s['image'] : 'default.jpg' ?>" class="service-img">
                                        </div>
                                        <div>
                                            <span class="fw-bold text-dark d-block mb-1"><?= $s['service_name'] ?></span>
                                            <div class="d-flex flex-wrap gap-1 align-items-center">
                                                <span class="badge-cat d-md-none"><?= $s['category_name'] ?></span>
                                                <small class="text-muted"><i class="fas fa-phone-alt me-1"></i><?= $s['phone'] ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <span class="badge-cat"><?= $s['category_name'] ?></span>
                                </td>
                                <td class="text-end px-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="edit_service.php?id=<?= $s['id'] ?>" class="btn btn-outline-info btn-action"><i class="fa fa-edit"></i></a>
                                        <a href="delete_service.php?id=<?= $s['id'] ?>" class="btn btn-outline-danger btn-action" onclick="return confirm('ဖျက်မှာ သေချာပါသလား?')"><i class="fa fa-trash"></i></a>
                                    </div>
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