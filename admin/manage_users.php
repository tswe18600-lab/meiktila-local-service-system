<?php
session_start();
require_once '../config/db.php';

// Admin Security Check - Admin မဟုတ်ရင် ဝင်ခွင့်မပြုပါ


// User စာရင်းဆွဲထုတ်မယ် (Admin ကို ချန်လှပ်ထားမယ်)
$stmt = $pdo->query("SELECT id, fullname, email, role FROM users WHERE role != 'admin' ORDER BY id DESC");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #9cbed5; font-family: 'Pyidaungsu', sans-serif; }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .table thead { background-color: #2c3e50; color: white; }
        .badge { padding: 8px 12px; border-radius: 50px; }
        .btn-action { border-radius: 50px; padding: 5px 15px; font-size: 13px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark"><i class="fas fa-users-cog me-2"></i>အသုံးပြုသူများ စီမံခန့်ခွဲမှု</h2>
            <a href="dashboard.php" class="btn btn-outline-secondary rounded-pill btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Dashboard သို့
            </a>
        </div>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> <strong>အောင်မြင်ပါသည်!</strong> Role ပြောင်းလဲမှု ပြီးမြောက်ပါပြီ။
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">အမည်</th>
                            <th>Email လိပ်စာ</th>
                            <th class="text-center">လက်ရှိ Role</th>
                            <th class="text-end pe-3">လုပ်ဆောင်ချက်</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="ps-3">
                                <div class="fw-bold"><?= htmlspecialchars($user['fullname']) ?></div>
                            </td>
                            <td><span class="text-muted"><?= htmlspecialchars($user['email']) ?></span></td>
                            <td class="text-center">
                                <?php if($user['role'] == 'provider'): ?>
                                    <span class="badge bg-success-subtle text-success border border-success">
                                        <i class="fas fa-store me-1"></i> ဆိုင်ရှင် (Provider)
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-primary-subtle text-primary border border-primary">
                                        <i class="fas fa-user me-1"></i> အသုံးပြုသူ (User)
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-3">
                                <?php if ($user['role'] == 'user'): ?>
                                    <a href="update_role.php?id=<?= $user['id'] ?>&to=provider" 
                                       class="btn btn-warning btn-action shadow-sm text-dark" 
                                       onclick="return confirm('ဒီလူကို ဆိုင်ရှင်အဖြစ် ပြောင်းမှာ သေချာပါသလား?')">
                                       <i class="fas fa-user-edit me-1"></i> Provider သို့ ပြောင်းမည်
                                    </a>
                                <?php else: ?>
                                    <a href="update_role.php?id=<?= $user['id'] ?>&to=user" 
                                       class="btn btn-secondary btn-action shadow-sm"
                                       onclick="return confirm('ဒီလူကို ပုံမှန် User အဖြစ် ပြန်ပြောင်းမှာ သေချာပါသလား?')">
                                       <i class="fas fa-user-minus me-1"></i> User သို့ ပြန်ပြောင်းမည်
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>