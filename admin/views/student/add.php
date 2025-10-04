<?php
require_once '../../../config/db.php';

$errors = [];
$form_data = [];

// FORM GÖNDERİLDİYSE İŞLEM YAP
if ($_POST) {
    // Form verilerini sakla (hata durumunda kullanmak için)
    $form_data = $_POST;

    // Validasyon
    if (empty($_POST['fullname'])) {
        $errors['fullname'] = "Ad soyad alanı zorunludur";
    }

    if (empty($_POST['email'])) {
        $errors['email'] = "E-posta alanı zorunludur";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Geçerli bir e-posta adresi giriniz";
    }

    if (empty($_POST['password'])) {
        $errors['password'] = "Şifre alanı zorunludur";
    } elseif (strlen($_POST['password']) < 6) {
        $errors['password'] = "Şifre en az 6 karakter olmalıdır";
    }

    if (empty($_POST['veliadsoyad'])) {
        $errors['veliadsoyad'] = "Veli ad soyad alanı zorunludur";
    }

    if (empty($_POST['velitelefon'])) {
        $errors['velitelefon'] = "Veli telefon alanı zorunludur";
    } elseif (!preg_match('/^[0-9]{10}$/', $_POST['velitelefon'])) {
        $errors['velitelefon'] = "Geçerli bir telefon numarası giriniz (10 haneli)";
    }

    // Eğer hata yoksa kayıt işlemini yap
    if (empty($errors)) {
        try {
            // Transaction başlat
            $pdo->beginTransaction();

            // 1. Önce users tablosuna ekle (öğrenci için)
            $username = $_POST['email'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // E-posta zaten var mı kontrol et
            $sql_check = "SELECT id FROM users WHERE email = ?";
            $stmt_check = $pdo->prepare($sql_check);
            $stmt_check->execute([$email]);

            if ($stmt_check->fetch()) {
                throw new Exception("Bu e-posta adresi zaten kullanılıyor!");
            }

            $sql_user = "INSERT INTO users (fullname, email, password, role) 
                         VALUES (?, ?, ?, 'student')";
            $stmt_user = $pdo->prepare($sql_user);
            $stmt_user->execute([$_POST['fullname'], $email, $password]);

            $user_id = $pdo->lastInsertId();

            // 2. Sonra students tablosuna ekle
            $sql_student = "INSERT INTO student
                           (fullname, email, password, okuladi, sinifseviye, dgtarih, 
                            veliadsoyad, velitelefon, veliemail, adres, durum) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'aktif')";

            $stmt_student = $pdo->prepare($sql_student);
            $stmt_student->execute([
                $_POST['fullname'],
                $_POST['email'],
                $password, // students tablosunda da şifre saklanıyor
                !empty($_POST['okuladi']) ? $_POST['okuladi'] : null,
                !empty($_POST['sinifseviye']) ? $_POST['sinifseviye'] : null,
                !empty($_POST['dgtarih']) ? $_POST['dgtarih'] : null,
                $_POST['veliadsoyad'],
                $_POST['velitelefon'],
                !empty($_POST['veliemail']) ? $_POST['veliemail'] : null,
                !empty($_POST['adres']) ? $_POST['adres'] : null
            ]);

            // Transaction'ı onayla
            $pdo->commit();

            $_SESSION['success'] = "✅ Öğrenci başarıyla kaydedildi!";
            header("Location: slist.php");
            exit();

        } catch (Exception $e) {
            // Hata durumunda geri al
            $pdo->rollBack();
            $errors['general'] = "❌ Kayıt işlemi başarısız: " . $e->getMessage();
        }
    }
}

$title = "Yeni Öğrenci Kaydı";
ob_start();
?>

<h1 style="font-weight: 700; font-size: 1.8rem; margin-bottom: 30px; color: var(--text-color);">Yeni Öğrenci Kaydı</h1>

<!-- Genel Hata Mesajı -->
<?php if (isset($errors['general'])): ?>
    <div class="alert alert-error">
        <?php echo $errors['general']; ?>
    </div>
<?php endif; ?>

<!-- Success Mesajı -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['success'];
        unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<div class="form-card">
    <form action="" method="POST" id="ogrenciForm">

        <div class="form-grid">

            <div class="section-heading">Öğrenci Kişisel Bilgileri</div>

            <div class="form-group">
                <label for="fullname">Adı Soyadı *</label>
                <input type="text" id="fullname" name="fullname" required
                    value="<?php echo isset($form_data['fullname']) ? htmlspecialchars($form_data['fullname']) : ''; ?>"
                    class="<?php echo isset($errors['fullname']) ? 'error' : ''; ?>">
                <?php if (isset($errors['fullname'])): ?>
                    <div class="error-message"><?php echo $errors['fullname']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="dgtarih">Doğum Tarihi</label>
                <input type="date" id="dgtarih" name="dgtarih"
                    value="<?php echo isset($form_data['dgtarih']) ? $form_data['dgtarih'] : ''; ?>">
            </div>

            <div class="form-group">
                <label for="okuladi">Okul Adı</label>
                <input type="text" id="okuladi" name="okuladi"
                    value="<?php echo isset($form_data['okuladi']) ? htmlspecialchars($form_data['okuladi']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="sinifseviye">Sınıf Seviyesi</label>
                <input type="number" id="sinifseviye" name="sinifseviye" min="1" max="12"
                    value="<?php echo isset($form_data['sinifseviye']) ? $form_data['sinifseviye'] : ''; ?>">
            </div>

            <div class="section-heading">Öğrenci Erişim Bilgileri</div>

            <div class="form-group">
                <label for="email">Öğrenci E-Posta *</label>
                <input type="email" id="email" name="email" required
                    value="<?php echo isset($form_data['email']) ? htmlspecialchars($form_data['email']) : ''; ?>"
                    class="<?php echo isset($errors['email']) ? 'error' : ''; ?>">
                <?php if (isset($errors['email'])): ?>
                    <div class="error-message"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">İlk Şifre *</label>
                <input type="password" id="password" name="password" required
                    class="<?php echo isset($errors['password']) ? 'error' : ''; ?>">
                <?php if (isset($errors['password'])): ?>
                    <div class="error-message"><?php echo $errors['password']; ?></div>
                <?php endif; ?>
            </div>

            <div class="section-heading">Veli İletişim Bilgileri</div>

            <div class="form-group">
                <label for="veliadsoyad">Veli Adı Soyadı *</label>
                <input type="text" id="veliadsoyad" name="veliadsoyad" required
                    value="<?php echo isset($form_data['veliadsoyad']) ? htmlspecialchars($form_data['veliadsoyad']) : ''; ?>"
                    class="<?php echo isset($errors['veliadsoyad']) ? 'error' : ''; ?>">
                <?php if (isset($errors['veliadsoyad'])): ?>
                    <div class="error-message"><?php echo $errors['veliadsoyad']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="velitelefon">Veli Telefon *</label>
                <input type="tel" id="velitelefon" name="velitelefon" required
                    value="<?php echo isset($form_data['velitelefon']) ? htmlspecialchars($form_data['velitelefon']) : ''; ?>"
                    class="<?php echo isset($errors['velitelefon']) ? 'error' : ''; ?>">
                <?php if (isset($errors['velitelefon'])): ?>
                    <div class="error-message"><?php echo $errors['velitelefon']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="veliemail">Veli E-Posta</label>
                <input type="email" id="veliemail" name="veliemail"
                    value="<?php echo isset($form_data['veliemail']) ? htmlspecialchars($form_data['veliemail']) : ''; ?>">
            </div>

            <div class="form-group full-width">
                <label for="adres">Açık Adres</label>
                <textarea id="adres"
                    name="adres"><?php echo isset($form_data['adres']) ? htmlspecialchars($form_data['adres']) : ''; ?></textarea>
            </div>

        </div>

        <div class="form-notice">
            <i class="fas fa-info-circle"></i>
            * İşaretli alanlar zorunludur. Öğrenci hem users hem students tablosuna kaydedilecektir.
        </div>

        <div class="button-group">
            <button type="button" class="cancel-btn" onclick="window.history.back()">
                <i class="fas fa-times"></i> İPTAL
            </button>
            <button type="submit" class="save-btn">
                <i class="fas fa-save"></i> KAYDET VE SİSTEME EKLE
            </button>
        </div>
    </form>
</div>

<style>
    .form-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .section-heading {
        grid-column: 1 / -1;
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary-color);
        margin: 20px 0 10px 0;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--primary-color);
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--text-color);
    }

    .form-group input,
    .form-group textarea {
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }

    .form-group input.error,
    .form-group textarea.error {
        border-color: #dc3545;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 5px;
        padding: 5px;
        background: #f8f9fa;
        border-radius: 4px;
        border-left: 3px solid #dc3545;
    }

    .button-group {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }

    .cancel-btn,
    .save-btn {
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .cancel-btn {
        background: #6c757d;
        color: white;
    }

    .cancel-btn:hover {
        background: #545b62;
    }

    .save-btn {
        background: var(--primary-color);
        color: white;
    }

    .save-btn:hover {
        background: #2980b9;
        transform: translateY(-2px);
    }

    .form-notice {
        background: #e3f2fd;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid var(--primary-color);
        color: var(--text-color);
        margin-bottom: 20px;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .button-group {
            flex-direction: column;
        }
    }
</style>

<script>
    // Client-side validasyon
    document.getElementById('ogrenciForm').addEventListener('submit', function (e) {
        let isValid = true;

        // Fullname kontrolü
        const fullname = document.getElementById('fullname').value.trim();
        if (!fullname) {
            showError('fullname', 'Ad soyad alanı zorunludur');
            isValid = false;
        } else {
            clearError('fullname');
        }

        // E-posta kontrolü
        const email = document.getElementById('email').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            showError('email', 'E-posta alanı zorunludur');
            isValid = false;
        } else if (!emailRegex.test(email)) {
            showError('email', 'Geçerli bir e-posta adresi giriniz');
            isValid = false;
        } else {
            clearError('email');
        }

        // Şifre kontrolü
        const password = document.getElementById('password').value;
        if (!password) {
            showError('password', 'Şifre alanı zorunludur');
            isValid = false;
        } else if (password.length < 6) {
            showError('password', 'Şifre en az 6 karakter olmalıdır');
            isValid = false;
        } else {
            clearError('password');
        }

        // Veli ad soyad kontrolü
        const veliadsoyad = document.getElementById('veliadsoyad').value.trim();
        if (!veliadsoyad) {
            showError('veliadsoyad', 'Veli ad soyad alanı zorunludur');
            isValid = false;
        } else {
            clearError('veliadsoyad');
        }

        // Telefon kontrolü
        const telefon = document.getElementById('velitelefon').value.trim();
        const telRegex = /^[0-9]{10}$/;
        if (!telefon) {
            showError('velitelefon', 'Telefon alanı zorunludur');
            isValid = false;
        } else if (!telRegex.test(telefon)) {
            showError('velitelefon', 'Geçerli bir telefon numarası giriniz (10 haneli)');
            isValid = false;
        } else {
            clearError('velitelefon');
        }

        if (!isValid) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });

    function showError(fieldName, message) {
        const field = document.getElementById(fieldName);
        field.classList.add('error');

        let errorDiv = field.parentNode.querySelector('.error-message');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            field.parentNode.appendChild(errorDiv);
        }
        errorDiv.textContent = message;
    }

    function clearError(fieldName) {
        const field = document.getElementById(fieldName);
        field.classList.remove('error');

        const errorDiv = field.parentNode.querySelector('.error-message');
        if (errorDiv) {
            errorDiv.remove();
        }
    }
</script>

<?php
$content = ob_get_clean();
include('../../includes/_layout.php');