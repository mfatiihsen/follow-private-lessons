<?php

require_once '../../../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: slist.php");
    exit();
}

$student_id = $_GET['id'];

try {
    // Önce student tablosundan sil
    $sql_student = "DELETE FROM student WHERE id = ?";
    $stmt_student = $pdo->prepare($sql_student);
    $stmt_student->execute([$student_id]);

    // İlişkili user kaydını da silmek isterseniz:
    $sql_user = "DELETE FROM users WHERE email = (SELECT email FROM student WHERE id = ?)";
    $stmt_user = $pdo->prepare($sql_user);
    $stmt_user->execute([$student_id]);

    $_SESSION['success'] = "✅ Öğrenci başarıyla silindi.";

} catch (PDOException $e) {
    $_SESSION['error'] = "❌ Silme işlemi başarısız: " . $e->getMessage();
}

header("Location: slist.php");
exit();