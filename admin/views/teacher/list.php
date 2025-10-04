<?php


require_once '../../../config/db.php';

try {
    // teachers tablosundan verileri çek
    $sql = "SELECT id, fullname, tc, telefon, email, ililce, adres, brans, eseviye 
            FROM teacher 
            ORDER BY fullname";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Veritabanı hatası: " . $e->getMessage());
}

$title = "Eğitmen Yönetimi";
ob_start();
?>

<h1 style="font-weight: 700; font-size: 1.8rem; margin-bottom: 30px; color: var(--text-color);">Eğitmen Kayıtları
    Yönetimi</h1>

<div class="list-container">
    <div class="filter-bar">
        <div class="search-input">
            <i class="fas fa-search"
                style="position: absolute; left: 35px; top: 38px; color: var(--light-text-color);"></i>
            <input type="text" id="searchInput" placeholder="Öğretmen adına veya branşına göre ara...">
        </div>

        <button onclick="window.open('add.php', '_self')" class="new-teacher-btn">
            <i class="fas fa-plus"></i> Yeni Öğretmen Ekle
        </button>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Ad Soyad</th>
                <th>TC Kimlik</th>
                <th>Telefon</th>
                <th>E-posta</th>
                <th>İl/İlçe</th>
                <th>Branş</th>
                <th>Eğitim Seviyesi</th>
                <th style="text-align: center;">Aksiyonlar</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($teachers)): ?>
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">
                        Henüz kayıtlı öğretmen bulunmamaktadır.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($teachers as $teacher): ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($teacher['fullname']); ?></strong>
                        </td>
                        <td>
                            <?php if (!empty($teacher['tc'])): ?>
                                <?php echo htmlspecialchars($teacher['tc']); ?>
                            <?php else: ?>
                                <span style="color: var(--light-text-color);">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($teacher['telefon'])): ?>
                                <?php echo htmlspecialchars($teacher['telefon']); ?>
                            <?php else: ?>
                                <span style="color: var(--light-text-color);">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($teacher['email'])): ?>
                                <?php echo htmlspecialchars($teacher['email']); ?>
                            <?php else: ?>
                                <span style="color: var(--light-text-color);">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($teacher['ililce'])): ?>
                                <?php echo htmlspecialchars($teacher['ililce']); ?>
                            <?php else: ?>
                                <span style="color: var(--light-text-color);">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($teacher['brans'])): ?>
                                <span class="subject-badge"><?php echo htmlspecialchars($teacher['brans']); ?></span>
                            <?php else: ?>
                                <span style="color: var(--light-text-color);">Belirtilmemiş</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($teacher['eseviye'])): ?>
                                <span class="education-level"><?php echo htmlspecialchars($teacher['eseviye']); ?></span>
                            <?php else: ?>
                                <span style="color: var(--light-text-color);">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="action-buttons-cell" style="text-align: center;">
                            <button title="Detay/Düzenle"
                                onclick="window.location.href='edit.php?id=<?php echo $teacher['id']; ?>'">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button title="Sil" class="delete-btn" onclick="confirmDelete(<?php echo $teacher['id']; ?>)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <button title="Detay Görüntüle"
                                onclick="window.location.href='detail.php?id=<?php echo $teacher['id']; ?>'">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 20px; text-align: right; color: var(--light-text-color);">
        <span>Toplam <?php echo count($teachers); ?> öğretmen</span>
    </div>
</div>

<script>
    function confirmDelete(teacherId) {
        if (confirm('Bu öğretmeni silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
            window.location.href = 'delete.php?id=' + teacherId;
        }
    }

    // Arama fonksiyonu
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const searchText = this.value.toLowerCase();
        const rows = document.querySelectorAll('.data-table tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchText)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<style>
    .subject-badge {
        background-color: var(--primary-color);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
    }

    .education-level {
        background-color: #6c757d;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
    }

    .action-buttons-cell button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
        margin: 0 2px;
        color: var(--text-color);
    }

    .action-buttons-cell button:hover {
        color: var(--primary-color);
    }

    .delete-btn:hover {
        color: #dc3545 !important;
    }
</style>

<?php
$content = ob_get_clean();
include('../../includes/_layout.php');