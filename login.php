<?php
session_start();
require_once 'includes/auth.php';

if ($is_logged_in) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Kelurahan TSU</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container" style="max-width: 400px; margin-top: 100px;">
    <div class="card">
        <h3 style="text-align: center; color: var(--tsu-blue);">Login Sistem Kelurahan</h3>
        
        <?php if (isset($_SESSION['login_error'])): ?>
            <p style="color: red; text-align: center;"><?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?></p>
        <?php endif; ?>

        <form method="POST" action="includes/auth.php">
            <input type="hidden" name="action" value="login">
            <div style="margin-bottom: 15px;">
                <label>Username:</label>
                <input type="text" name="username" style="width: 100%; padding: 8px; box-sizing: border-box;" required placeholder="admin / warga">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Password:</label>
                <input type="password" name="password" style="width: 100%; padding: 8px; box-sizing: border-box;" required placeholder="admin123 / warga123">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Masuk</button>
        </form>
    </div>
</div>

</body>
</html>