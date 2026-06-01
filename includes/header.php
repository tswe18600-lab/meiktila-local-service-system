<?php if(isset($_SESSION['user_id'])): ?>
    
    <?php if($_SESSION['role'] === 'provider'): ?>
        <a href="provider/dashboard.php" class="btn btn-outline-light me-2">ဆိုင်ရှင် Dashboard</a>
    <?php elseif($_SESSION['role'] === 'admin'): ?>
        <a href="admin/dashboard.php" class="btn btn-outline-light me-2">Admin Panel</a>
    <?php endif; ?>
    <a href="logout.php" class="btn btn-danger">ထွက်ရန်</a>
<?php else: ?>
    <a href="login.php" class="btn btn-primary">Login ဝင်ရန်</a>
<?php endif; ?>
