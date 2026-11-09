<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proses Login
if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['user'] = ['name' => 'Administrator Kelurahan', 'role' => 'admin'];
    } elseif ($username === 'warga' && $password === 'warga123') {
        $_SESSION['user'] = ['name' => 'Warga Kelurahan', 'role' => 'user'];
    } else {
        $_SESSION['login_error'] = "Username atau password salah!";
    }
    
    // Arahkan kembali ke index.php di luar folder includes
    header("Location: ../index.php");
    exit;
}

$is_logged_in = isset($_SESSION['user']);
$role = $is_logged_in ? $_SESSION['user']['role'] : 'guest';
?>