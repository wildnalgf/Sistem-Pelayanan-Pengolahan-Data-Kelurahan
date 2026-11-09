<?php
require_once __DIR__ . '/auth.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Pelayanan & Pengolahan Data Kelurahan - TSU</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="header">
    <div class="header-title">
        <!-- Logo Kampus diambil langsung dari folder assets/ -->
        <img src="assets/Logo kampus.jpg" alt="Logo TSU" style="height: 45px; background: white; padding: 2px; border-radius: 4px;">
        <div>
            <h2>Sistem Pelayanan & Pengolahan Data Kelurahan</h2>
            <small>Universitas Tiga Serangkai | Pengembang: Tim Informatika</small>
        </div>
    </div>
    <div>
        <?php if ($is_logged_in): ?>
            <span>Halo, <strong><?= htmlspecialchars($_SESSION['user']['name']) ?></strong> (<?= strtoupper($role) ?>)</span>
            <a href="logout.php" class="btn btn-danger" style="margin-left: 10px;">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-primary">Login Form</a>
        <?php endif; ?>
    </div>
</div>