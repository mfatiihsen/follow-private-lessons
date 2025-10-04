<?php
require_once '../../config/db.php';
session_start();
// Admin kontrolü burada olacak

if ($_POST) {

    // 1. Önce users tablosuna ekle
    $fullname = $_POST['ad_soyad'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'teacher';

    $sql_user = "INSERT INTO users (fullname, email, password, role) 
                 VALUES (?, ?, ?, ?)";
    $stmt_user = $pdo->prepare($sql_user);
    $stmt_user->execute([$fullname, $email, $password, $role]);

    // db ye son eklenen kaydın ID sini almak için kullanılır.
    $id = $pdo->lastInsertId();

    // 2. Sonra teachers tablosuna ekle
    $sql_teacher = "INSERT INTO teacher (id, fullname, tc, telefon, email, ililce, adres, password,brans,eseviye) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_teacher = $pdo->prepare($sql_teacher);
    $stmt_teacher->execute([
        $id,
        $fullname,
        $_POST['tc_kimlik'],
        $_POST['telefon'],
        $email,
        $_POST['adres_ilce'],
        $_POST['adres_detay'],
        $password,
        $_POST['brans'],
        $_POST['egitim_seviyesi']
    ]);

    header("Location: ../views/teacher/list.php?success=1");
    exit;
}


// aynı mail de kullanıcı var ise hata ver (kontrol eklenebilir)  !!!