<?php
session_start();

// Tüm session değişkenlerini temizle
$_SESSION = array();

// Session cookie'yi sil
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Session'u yok et
session_destroy();

// Önbellek önleyici header'lar
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Login sayfasına yönlendir
header("Location: ../../login/login.php");
exit();
?>