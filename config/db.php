<?php
$host = 'localhost';
$db = 'ozelders';
$user = 'root';      // kendi kullanıcı adını yaz
$pass = '';          // kendi şifreni yaz
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // hata modu
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // fetch modu
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    //echo "Veritabanı bağlantısı başarılı.";
} catch (\PDOException $e) {
    die('Veritabanı bağlantı hatası: ' . $e->getMessage());
}
