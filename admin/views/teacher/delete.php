<?php
require_once '../../../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: list.php");
    exit();
}

$teacher_id = $_GET['id'];

try {
    // Önce teacher tablosundan sil
    $sql = "DELETE FROM teacher WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$teacher_id]);

    //ilişkili user kaydını da siliyoruz.
    $sql_user = "DELETE FROM users WHERE email = (SELECT email FROM teacher WHERE id = ?)";
    $stmt_user = $pdo->prepare($sql_user);
    $stmt_user->execute([$teacher_id]);

    $_SESSION['success'] = "Öğretmen başarıyla silindi.";

} catch (PDOException $e) {
    $_SESSION['error'] = "Silme işlemi başarısız: " . $e->getMessage();
}

header("Location: list.php");
exit();