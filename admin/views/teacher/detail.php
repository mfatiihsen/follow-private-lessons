<?php

require_once '../../../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: list.php");
    exit();
}

$teacher_id = $_GET['id'];

$sql = "SELECT * FROM teacher WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$teacher_id]);
$teacher = $stmt->fetch();

if (!$teacher) {
    header("Location: list.php");
    exit();
}

$title = "Öğretmen Detayı: " . $teacher['fullname'];
ob_start();
?>

<div class="detail-container">
    <div class="detail-header">
        <h1><?php echo htmlspecialchars($teacher['fullname']); ?></h1>
        <a href="list.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Listeye Dön
        </a>
    </div>

    <div class="detail-grid">
        <div class="detail-card">
            <h3><i class="fas fa-id-card"></i> Kimlik Bilgileri</h3>
            <div class="detail-item">
                <label>TC Kimlik:</label>
                <span><?php echo !empty($teacher['tc']) ? htmlspecialchars($teacher['tc']) : 'Belirtilmemiş'; ?></span>
            </div>
            <div class="detail-item">
                <label>Ad Soyad:</label>
                <span><?php echo !empty($teacher['fullname']) ? htmlspecialchars($teacher['fullname']) : 'Belirtilmemiş'; ?></span>
            </div>
        </div>

        <div class="detail-card">
            <h3><i class="fas fa-phone"></i> İletişim Bilgileri</h3>
            <div class="detail-item">
                <label>Telefon:</label>
                <span><?php echo !empty($teacher['telefon']) ? htmlspecialchars($teacher['telefon']) : 'Belirtilmemiş'; ?></span>
            </div>
            <div class="detail-item">
                <label>E-posta:</label>
                <span><?php echo !empty($teacher['email']) ? htmlspecialchars($teacher['email']) : 'Belirtilmemiş'; ?></span>
            </div>
        </div>

        <div class="detail-card">
            <h3><i class="fas fa-map-marker-alt"></i> Adres Bilgileri</h3>
            <div class="detail-item">
                <label>İl/İlçe:</label>
                <span><?php echo !empty($teacher['ililce']) ? htmlspecialchars($teacher['ililce']) : 'Belirtilmemiş'; ?></span>
            </div>
            <div class="detail-item">
                <label>Adres:</label>
                <span><?php echo !empty($teacher['adres']) ? htmlspecialchars($teacher['adres']) : 'Belirtilmemiş'; ?></span>
            </div>
        </div>

        <div class="detail-card">
            <h3><i class="fas fa-graduation-cap"></i> Mesleki Bilgiler</h3>
            <div class="detail-item">
                <label>Branş:</label>
                <span
                    class="subject-badge"><?php echo !empty($teacher['brans']) ? htmlspecialchars($teacher['brans']) : 'Belirtilmemiş'; ?></span>
            </div>
            <div class="detail-item">
                <label>Eğitim Seviyesi:</label>
                <span
                    class="education-level"><?php echo !empty($teacher['eseviye']) ? htmlspecialchars($teacher['eseviye']) : 'Belirtilmemiş'; ?></span>
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <button onclick="window.location.href='edit.php?id=<?php echo $teacher['id']; ?>'" class="edit-btn-large">
            <i class="fas fa-edit"></i> Bilgileri Düzenle
        </button>
        <button onclick="confirmDelete(<?php echo $teacher['id']; ?>)" class="delete-btn-large">
            <i class="fas fa-trash"></i> Öğretmeni Sil
        </button>
    </div>
</div>

<style>
    .detail-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .back-btn {
        background: #6c757d;
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        transition: background 0.3s;
    }

    .back-btn:hover {
        background: #545b62;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .detail-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .detail-card h3 {
        margin-bottom: 15px;
        color: var(--text-color);
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 8px;
    }

    .detail-item {
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .detail-item label {
        font-weight: bold;
        color: var(--light-text-color);
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .edit-btn-large,
    .delete-btn-large {
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .edit-btn-large {
        background: #ffc107;
        color: white;
    }

    .edit-btn-large:hover {
        background: #e0a800;
    }

    .delete-btn-large {
        background: #dc3545;
        color: white;
    }

    .delete-btn-large:hover {
        background: #c82333;
    }
</style>

<script>
    function confirmDelete(teacherId) {
        if (confirm('Bu öğretmeni silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
            window.location.href = 'delete.php?id=' + teacherId;
        }
    }
</script>

<?php
$content = ob_get_clean();
include('../../includes/_layout.php');