<?php

require_once '../../config/db.php';

if ($_POST) {
    try {
        $sql = "UPDATE teacher SET 
                fullname = ?, tc = ?, telefon = ?, email = ?, 
                ililce = ?, adres = ?, brans = ?, eseviye = ? 
                WHERE id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_POST['fullname'],
            $_POST['tc'],
            $_POST['telefon'],
            $_POST['email'],
            $_POST['ililce'],
            $_POST['adres'],
            $_POST['brans'],
            $_POST['eseviye'],
            $_POST['id']
        ]);

        $_SESSION['success'] = "Öğretmen bilgileri başarıyla güncellendi.";

    } catch (PDOException $e) {
        $_SESSION['error'] = "Güncelleme başarısız: " . $e->getMessage();
    }
}

header("Location: ../views/teacher/list.php");
exit();
?>