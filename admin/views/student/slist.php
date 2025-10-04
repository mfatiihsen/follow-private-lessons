<?php
require_once '../../../config/db.php';

// Öğrencileri veritabanından çek
try {
    $sql = "SELECT * FROM student ORDER BY kayittarih DESC";
    $stmt = $pdo->query($sql);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Veritabanı hatası: " . $e->getMessage());
}

$title = "Öğrenci Kayıtları Yönetimi";
ob_start();
?>

<h1 style="font-weight: 700; font-size: 1.8rem; margin-bottom: 30px; color: var(--text-color);">Öğrenci Kayıtları
    Yönetimi</h1>

<div class="list-container">

    <div class="filter-bar">
        <div class="search-input">
            <i class="fas fa-search"
                style="position: absolute; left: 35px; top: 38px; color: var(--light-text-color);"></i>
            <input type="text" id="searchInput" placeholder="Öğrenci adına, telefonuna veya okuluna göre ara...">
        </div>

        <button onclick="window.location.href='add.php'" class="new-teacher-btn">
            <i class="fas fa-user-plus"></i> Yeni Öğrenci Kaydet
        </button>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Ad Soyad</th>
                <th>İletişim</th>
                <th>Okul / Sınıf</th>
                <th>Veli Bilgisi</th>
                <th>Durum</th>
                <th style="text-align: center;">Aksiyonlar</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($students)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--light-text-color);">
                        <i class="fas fa-users"
                            style="font-size: 48px; margin-bottom: 15px; display: block; opacity: 0.5;"></i>
                        Henüz kayıtlı öğrenci bulunmamaktadır.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($student['fullname']); ?></strong>
                            <br>
                            <small style="color: var(--light-text-color);">
                                <?php echo htmlspecialchars($student['email']); ?>
                            </small>
                        </td>
                        <td>
                            <?php if (!empty($student['velitelefon'])): ?>
                                <div><?php echo htmlspecialchars($student['velitelefon']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($student['veilemail'])): ?>
                                <small style="color: var(--light-text-color);">
                                    <?php echo htmlspecialchars($student['veilemail']); ?>
                                </small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($student['okuladi'])): ?>
                                <div><?php echo htmlspecialchars($student['okuladi']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($student['sinifseviye'])): ?>
                                <small style="color: var(--light-text-color);">
                                    <?php echo $student['sinifseviye']; ?>. Sınıf
                                </small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($student['veliadsoyad'])): ?>
                                <div><?php echo htmlspecialchars($student['veliadsoyad']); ?></div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                            $status_class = 'status-devam';
                            $status_text = 'Aktif';

                            if (isset($student['durum'])) {
                                switch ($student['durum']) {
                                    case 'pasif':
                                        $status_class = 'status-pasif';
                                        $status_text = 'Pasif';
                                        break;
                                    case 'kayit_dondurdu':
                                        $status_class = 'status-dondurdu';
                                        $status_text = 'Kayıt Dondurdu';
                                        break;
                                    case 'yeni_kayit':
                                        $status_class = 'status-yeni';
                                        $status_text = 'Yeni Kayıt';
                                        break;
                                    default:
                                        $status_class = 'status-devam';
                                        $status_text = 'Aktif';
                                }
                            }
                            ?>
                            <span class="<?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                        </td>
                        <td class="action-buttons-cell" style="text-align: center;">
                            <button title="Detay Görüntüle"
                                onclick="window.location.href='detail.php?id=<?php echo $student['id']; ?>'" class="detail-btn">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button title="Düzenle"
                                onclick="window.location.href='ogrenci_duzenle.php?id=<?php echo $student['id']; ?>'"
                                class="edit-btn">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button title="Sil" class="delete-btn" onclick="confirmDelete(<?php echo $student['id']; ?>)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 20px; text-align: right; color: var(--light-text-color);">
        <span>Toplam <?php echo count($students); ?> Öğrenci</span>
    </div>
</div>

<script>
    function confirmDelete(studentId) {
        if (confirm('Bu öğrenciyi silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
            window.location.href = 'delete.php?id=' + studentId;
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
    .status-devam {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .status-pasif {
        background-color: #6c757d;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .status-dondurdu {
        background-color: #ffc107;
        color: #212529;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .status-yeni {
        background-color: #17a2b8;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .action-buttons-cell {
        display: flex;
        justify-content: center;
        gap: 5px;
    }

    .action-buttons-cell button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 8px;
        border-radius: 4px;
        transition: all 0.3s ease;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .detail-btn {
        color: #17a2b8;
        border: 1px solid #17a2b8;
    }

    .detail-btn:hover {
        background-color: #17a2b8;
        color: white;
    }

    .edit-btn {
        color: #ffc107;
        border: 1px solid #ffc107;
    }

    .edit-btn:hover {
        background-color: #ffc107;
        color: white;
    }

    .payment-btn {
        color: #28a745;
        border: 1px solid #28a745;
    }

    .payment-btn:hover {
        background-color: #28a745;
        color: white;
    }

    .delete-btn {
        color: #dc3545;
        border: 1px solid #dc3545;
    }

    .delete-btn:hover {
        background-color: #dc3545;
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .action-buttons-cell {
            flex-direction: column;
            gap: 2px;
        }

        .action-buttons-cell button {
            width: 30px;
            height: 30px;
            font-size: 0.8rem;
        }

        .data-table {
            font-size: 0.9rem;
        }
    }
</style>

<?php
$content = ob_get_clean();
include('../../includes/_layout.php');