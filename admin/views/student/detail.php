<?php

require_once '../../../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: ogrenciler.php");
    exit();
}

$student_id = $_GET['id'];

// Öğrenci bilgilerini getir
$sql = "SELECT * FROM student WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$student_id]);
$student = $stmt->fetch();

if (!$student) {
    header("Location: ogrenciler.php");
    exit();
}

$title = "Öğrenci Detayı: " . $student['fullname'];
ob_start();
?>

<div class="detail-container">
    <!-- Üst Bilgi ve Aksiyonlar -->
    <div class="detail-header">
        <div class="student-info">
            <h1><?php echo htmlspecialchars($student['fullname']); ?></h1>
            <div class="student-meta">
                <span class="student-id">#<?php echo $student['id']; ?></span>
                <span class="status-badge status-<?php echo $student['durum'] ?? 'aktif'; ?>">
                    <?php
                    $statusText = [
                        'aktif' => 'Aktif',
                        'pasif' => 'Pasif',
                        'yeni_kayit' => 'Yeni Kayıt',
                        'kayit_dondurdu' => 'Kayıt Dondurdu'
                    ];
                    echo $statusText[$student['durum'] ?? 'aktif'];
                    ?>
                </span>
                <span class="registration-date">
                    <i class="fas fa-calendar-alt"></i>
                    Kayıt: <?php echo date('d.m.Y', strtotime($student['kayittarih'])); ?>
                </span>
            </div>
        </div>
        <div class="action-buttons">
            <button onclick="window.location.href='ogrenci_duzenle.php?id=<?php echo $student['id']; ?>'"
                class="btn-edit">
                <i class="fas fa-edit"></i> Düzenle
            </button>
            <button onclick="window.location.href='odeme_ekle.php?ogrenci_id=<?php echo $student['id']; ?>'"
                class="btn-payment">
                <i class="fas fa-lira-sign"></i> Ödeme Ekle
            </button>
            <button onclick="window.history.back()" class="btn-back">
                <i class="fas fa-arrow-left"></i> Geri Dön
            </button>
        </div>
    </div>

    <!-- Detay Kartları -->
    <div class="detail-grid">
        <!-- Öğrenci Bilgileri -->
        <div class="detail-card">
            <div class="card-header">
                <i class="fas fa-user-graduate"></i>
                <h3>Öğrenci Bilgileri</h3>
            </div>
            <div class="card-content">
                <div class="info-item">
                    <label>Ad Soyad:</label>
                    <span><?php echo htmlspecialchars($student['fullname']); ?></span>
                </div>
                <div class="info-item">
                    <label>E-posta:</label>
                    <span><?php echo htmlspecialchars($student['email']); ?></span>
                </div>
                <div class="info-item">
                    <label>Doğum Tarihi:</label>
                    <span>
                        <?php echo !empty($student['dgtarih']) ? date('d.m.Y', strtotime($student['dgtarih'])) : 'Belirtilmemiş'; ?>
                        <?php if (!empty($student['dgtarih'])): ?>
                            <small>(<?php echo calculateAge($student['dgtarih']); ?> yaşında)</small>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-item">
                    <label>Okul:</label>
                    <span><?php echo !empty($student['okuladi']) ? htmlspecialchars($student['okuladi']) : 'Belirtilmemiş'; ?></span>
                </div>
                <div class="info-item">
                    <label>Sınıf:</label>
                    <span>
                        <?php echo !empty($student['sinifseviye']) ? $student['sinifseviye'] . '. Sınıf' : 'Belirtilmemiş'; ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Veli Bilgileri -->
        <div class="detail-card">
            <div class="card-header">
                <i class="fas fa-users"></i>
                <h3>Veli Bilgileri</h3>
            </div>
            <div class="card-content">
                <div class="info-item">
                    <label>Veli Ad Soyad:</label>
                    <span><?php echo htmlspecialchars($student['veliadsoyad']); ?></span>
                </div>
                <div class="info-item">
                    <label>Telefon:</label>
                    <span>
                        <?php echo !empty($student['velitelefon']) ? formatPhone($student['velitelefon']) : 'Belirtilmemiş'; ?>
                        <?php if (!empty($student['velitelefon'])): ?>
                            <a href="tel:<?php echo $student['velitelefon']; ?>" class="contact-link">
                                <i class="fas fa-phone"></i>
                            </a>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="info-item">
                    <label>E-posta:</label>
                    <span>
                        <?php echo !empty($student['veliemail']) ? htmlspecialchars($student['veliemail']) : 'Belirtilmemiş'; ?>
                        <?php if (!empty($student['veliemail'])): ?>
                            <a href="mailto:<?php echo $student['veliemail']; ?>" class="contact-link">
                                <i class="fas fa-envelope"></i>
                            </a>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- İletişim ve Adres -->
        <div class="detail-card">
            <div class="card-header">
                <i class="fas fa-map-marker-alt"></i>
                <h3>İletişim & Adres</h3>
            </div>
            <div class="card-content">
                <div class="info-item full-width">
                    <label>Açık Adres:</label>
                    <span class="address-text">
                        <?php echo !empty($student['adres']) ? nl2br(htmlspecialchars($student['adres'])) : 'Belirtilmemiş'; ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Sistem Bilgileri -->
        <div class="detail-card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i>
                <h3>Sistem Bilgileri</h3>
            </div>
            <div class="card-content">
                <div class="info-item">
                    <label>Öğrenci ID:</label>
                    <span>#<?php echo $student['id']; ?></span>
                </div>
                <div class="info-item">
                    <label>Kayıt Tarihi:</label>
                    <span><?php echo date('d.m.Y H:i', strtotime($student['kayittarih'])); ?></span>
                </div>
                <div class="info-item">
                    <label>Durum:</label>
                    <span class="status-badge status-<?php echo $student['durum'] ?? 'aktif'; ?>">
                        <?php echo $statusText[$student['durum'] ?? 'aktif']; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Hızlı Aksiyonlar -->
    <div class="quick-actions">
        <h3>Hızlı İşlemler</h3>
        <div class="action-buttons-grid">
            <button onclick="window.location.href='odeme_ekle.php?ogrenci_id=<?php echo $student['id']; ?>'"
                class="action-btn payment">
                <i class="fas fa-lira-sign"></i>
                <span>Ödeme Ekle</span>
            </button>
            <button onclick="window.location.href='ders_programi.php?ogrenci_id=<?php echo $student['id']; ?>'"
                class="action-btn schedule">
                <i class="fas fa-calendar-check"></i>
                <span>Ders Programı</span>
            </button>
            <button onclick="window.location.href='rapor.php?ogrenci_id=<?php echo $student['id']; ?>'"
                class="action-btn report">
                <i class="fas fa-chart-bar"></i>
                <span>İlerleme Raporu</span>
            </button>
            <button onclick="sendSMS(<?php echo $student['id']; ?>)" class="action-btn sms">
                <i class="fas fa-sms"></i>
                <span>SMS Gönder</span>
            </button>
        </div>
    </div>
</div>

<?php
// Yardımcı fonksiyonlar
function calculateAge($birthdate)
{
    $birthDate = new DateTime($birthdate);
    $today = new DateTime();
    $age = $today->diff($birthDate);
    return $age->y;
}

function formatPhone($phone)
{
    // Telefon numarasını formatla: 0XXX XXX XX XX
    if (strlen($phone) === 10) {
        return '0' . substr($phone, 0, 3) . ' ' . substr($phone, 3, 3) . ' ' . substr($phone, 6, 2) . ' ' . substr($phone, 8, 2);
    }
    return $phone;
}
?>

<!-- Stil Kodları -->

<style>
    .detail-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Header Styles */
    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
        padding: 25px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
    }

    .student-info h1 {
        margin: 0 0 10px 0;
        color: var(--text-color);
        font-size: 1.8rem;
    }

    .student-meta {
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }

    .student-id {
        background: var(--primary-color);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .registration-date {
        color: var(--light-text-color);
        font-size: 0.9rem;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .action-buttons button {
        padding: 10px 15px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .btn-edit {
        background: #ffc107;
        color: #212529;
    }

    .btn-edit:hover {
        background: #e0a800;
    }

    .btn-payment {
        background: #28a745;
        color: white;
    }

    .btn-payment:hover {
        background: #218838;
    }

    .btn-back {
        background: #6c757d;
        color: white;
    }

    .btn-back:hover {
        background: #545b62;
    }

    /* Detail Grid */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .detail-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary-color), #2980b9);
        color: white;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header h3 {
        margin: 0;
        font-size: 1.2rem;
    }

    .card-content {
        padding: 20px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .info-item.full-width {
        flex-direction: column;
        align-items: flex-start;
    }

    .info-item label {
        font-weight: 600;
        color: var(--text-color);
        min-width: 120px;
    }

    .info-item span {
        color: var(--light-text-color);
        text-align: right;
        flex: 1;
    }

    .info-item.full-width span {
        text-align: left;
        margin-top: 5px;
    }

    .address-text {
        line-height: 1.5;
    }

    .contact-link {
        color: var(--primary-color);
        margin-left: 8px;
        text-decoration: none;
    }

    .contact-link:hover {
        color: #2980b9;
    }

    /* Status Badges */
    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .status-aktif {
        background: #28a745;
        color: #fff;
    }

    .status-pasif {
        background: #6c757d;
        color: white;
    }

    .status-yeni_kayit {
        background: #17a2b8;
        color: white;
    }

    .status-kayit_dondurdu {
        background: #ffc107;
        color: #212529;
    }

    /* Quick Actions */
    .quick-actions {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
    }

    .quick-actions h3 {
        margin: 0 0 20px 0;
        color: var(--text-color);
    }

    .action-buttons-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        padding: 20px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        color: var(--text-color);
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .action-btn.payment {
        border-color: #28a745;
        color: #28a745;
    }

    .action-btn.payment:hover {
        background: #28a745;
        color: white;
    }

    .action-btn.schedule {
        border-color: #17a2b8;
        color: #17a2b8;
    }

    .action-btn.schedule:hover {
        background: #17a2b8;
        color: white;
    }

    .action-btn.report {
        border-color: #ffc107;
        color: #ffc107;
    }

    .action-btn.report:hover {
        background: #ffc107;
        color: #212529;
    }

    .action-btn.sms {
        border-color: #6f42c1;
        color: #6f42c1;
    }

    .action-btn.sms:hover {
        background: #6f42c1;
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .detail-header {
            flex-direction: column;
            gap: 20px;
        }

        .action-buttons {
            width: 100%;
            justify-content: center;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .info-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .info-item span {
            text-align: left;
            margin-top: 5px;
        }

        .action-buttons-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 480px) {
        .action-buttons-grid {
            grid-template-columns: 1fr;
        }

        .student-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
    }
</style>

<!-- JS Kodları -->

<script>
    function sendSMS(studentId) {
        const message = prompt('Göndermek istediğiniz SMS mesajını yazın:');
        if (message) {
            // Burada SMS gönderme API'si entegre edilebilir
            alert('SMS gönderiliyor: ' + message);
            // window.location.href = 'sms_gonder.php?ogrenci_id=' + studentId + '&mesaj=' + encodeURIComponent(message);
        }
    }

    // Sayfa yüklendiğinde animasyon
    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.detail-card');
        cards.forEach((card, index) => {
            card.style.animation = `fadeInUp 0.6s ease-out ${index * 0.1}s both`;
        });
    });

    // CSS animasyonu
    const style = document.createElement('style');
    style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
    document.head.appendChild(style);
</script>

<?php
$content = ob_get_clean();
include('../../includes/_layout.php');