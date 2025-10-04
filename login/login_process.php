<?php
session_start();
require_once '../config/db.php'; // Veritabanı bağlantısını buraya koyacağız





// Giriş İşlemleri


// Formdan gelen verileri al
$mail = trim($_POST['mail'] ?? '');
$password = trim($_POST['password'] ?? '');

// Boşluk kontrolü
if (empty($mail) || empty($password)) {
    echo "<script>alert('Lütfen tüm alanları doldurun!'); window.location.href='login.php';</script>";
    exit;
}


// Kullanıcıyı veritabanından çek
$sql = "SELECT * FROM users WHERE email = :email AND password = :password LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'email' => $mail,
    'password' => $password   // hashleme yok
]);

$user = $stmt->fetch();

if ($user) {
    // Giriş başarılı → oturum değişkenlerini ayarla
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['name'] = $user['fullname'];

    // Rolüne göre yönlendir
    switch ($user['role']) {
        case 'admin':
            header("Location: ../admin/views/home/index.php");
            break;
        case 'teacher':
            header("Location: ../teacher/views/home/index.php");
            break;
        case 'student':
            header("Location: student/dashboard.php");
            break;
        default:
            session_destroy();
            echo "<script>alert('Geçersiz kullanıcı rolü!'); window.location.href='login.php';</script>";
            break;
    }
    exit;
} else {
    // Hatalı giriş
    header("Location: login.php?error=" . urlencode("E-Posta veya şifre yanlış!"));
    exit;
}