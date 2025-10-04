<?php

require_once '../../../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: list.php");
    exit();
}

$teacher_id = $_GET['id'];

// Öğretmen bilgilerini getir
$sql = "SELECT * FROM teacher WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$teacher_id]);
$teacher = $stmt->fetch();

if (!$teacher) {
    header("Location: list.php");
    exit();
}

// Düzenleme formu burada olacak
$title = "Öğretmen Düzenle";
ob_start();
?>
<div class="form-container">
    <div class="form-header">
        <h1>Öğretmen Düzenle: <?php echo htmlspecialchars($teacher['fullname']); ?></h1>
        <a href="list.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Listeye Dön
        </a>
    </div>

    <form method="POST" action="../../controller/teacherupdate.php" class="teacher-form">
        <input type="hidden" name="id" value="<?php echo $teacher['id']; ?>">

        <div class="form-grid">
            <!-- Kişisel Bilgiler -->
            <div class="form-section">
                <h3><i class="fas fa-user"></i> Kişisel Bilgiler</h3>

                <div class="form-group">
                    <label for="fullname">Ad Soyad *</label>
                    <input type="text" id="fullname" name="fullname"
                        value="<?php echo htmlspecialchars($teacher['fullname']); ?>" required class="form-input">
                </div>

                <div class="form-group">
                    <label for="tc">TC Kimlik No</label>
                    <input type="text" id="tc" name="tc" value="<?php echo htmlspecialchars($teacher['tc']); ?>"
                        class="form-input" maxlength="11">
                </div>
            </div>

            <!-- İletişim Bilgileri -->
            <div class="form-section">
                <h3><i class="fas fa-phone"></i> İletişim Bilgileri</h3>

                <div class="form-group">
                    <label for="telefon">Telefon</label>
                    <input type="tel" id="telefon" name="telefon"
                        value="<?php echo htmlspecialchars($teacher['telefon']); ?>" class="form-input">
                </div>

                <div class="form-group">
                    <label for="email">E-posta</label>
                    <input type="email" id="email" name="email"
                        value="<?php echo htmlspecialchars($teacher['email']); ?>" class="form-input">
                </div>
            </div>

            <!-- Adres Bilgileri -->
            <div class="form-section">
                <h3><i class="fas fa-map-marker-alt"></i> Adres Bilgileri</h3>

                <div class="form-group">
                    <label for="ililce">İl / İlçe</label>
                    <input type="text" id="ililce" name="ililce"
                        value="<?php echo htmlspecialchars($teacher['ililce']); ?>" class="form-input">
                </div>

                <div class="form-group">
                    <label for="adres">Adres</label>
                    <textarea id="adres" name="adres" class="form-textarea"
                        rows="3"><?php echo htmlspecialchars($teacher['adres']); ?></textarea>
                </div>
            </div>

            <!-- Mesleki Bilgiler -->
            <div class="form-section">
                <h3><i class="fas fa-graduation-cap"></i> Mesleki Bilgiler</h3>

                <div class="form-group">
                    <label for="brans">Branş</label>
                    <input type="text" id="brans" name="brans"
                        value="<?php echo htmlspecialchars($teacher['brans']); ?>" class="form-input">
                </div>

                <div class="form-group">
                    <label for="eseviye">Eğitim Seviyesi</label>
                    <select  id="eseviye" name="eseviye" class="form-select">
                        <option value="<?php echo htmlspecialchars($teacher['eseviye']); ?>"></option>
                        <option value="Lisans" <?php echo $teacher['eseviye'] == 'Lisans' ? 'selected' : ''; ?>>Lisans
                        </option>
                        <option value="Yüksek Lisans" <?php echo $teacher['eseviye'] == 'Yüksek Lisans' ? 'selected' : ''; ?>>Yüksek Lisans</option>
                        <option value="Doktora" <?php echo $teacher['eseviye'] == 'Doktora' ? 'selected' : ''; ?>>Doktora
                        </option>
                        <option value="Doçent" <?php echo $teacher['eseviye'] == 'Doçent' ? 'selected' : ''; ?>>Doçent
                        </option>
                        <option value="Profesör" <?php echo $teacher['eseviye'] == 'Profesör' ? 'selected' : ''; ?>>
                            Profesör</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Bilgileri Güncelle
            </button>
            <a href="list.php" class="btn-secondary">
                <i class="fas fa-times"></i> İptal
            </a>
        </div>
    </form>
</div>
<style>
    .form-container {
        max-width: 1200px;
        margin: 0 ;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .form-header {
        background: linear-gradient(135deg, var(--primary-color), #2980b9);
        color: white;
        padding: 25px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .form-header h1 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .back-btn {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .back-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .teacher-form {
        padding: 30px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .form-section {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 8px;
        border-left: 4px solid var(--primary-color);
    }

    .form-section h3 {
        margin: 0 0 20px 0;
        color: var(--text-color);
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-section h3 i {
        color: var(--primary-color);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--text-color);
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 6px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }

    .form-textarea {
        resize: vertical;
        min-height: 80px;
        font-family: inherit;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary:hover {
        background: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-secondary:hover {
        background: #545b62;
        transform: translateY(-2px);
    }

    /* Responsive Tasarım */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }

        .teacher-form {
            padding: 20px;
        }

        .form-actions {
            flex-direction: column;
        }
    }

    /* Özel stiller */
    .form-input[required]+label::after {
        content: " *";
        color: #e74c3c;
    }

    .form-section:hover {
        transform: translateY(-2px);
        transition: transform 0.3s ease;
    }
</style>

<?php
$content = ob_get_clean();
include('../../includes/_layout.php');
?>