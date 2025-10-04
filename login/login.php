<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetim Paneli Giriş</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login-dark.css">
</head>
<style>
    /* Genel Değişkenler (Karanlık Mod) */
    :root {
        --primary-color: #00bcd4;
        /* Turkuaz - Vurgu Rengi */
        --primary-dark: #0097a7;
        --background-color: #121212;
        /* Çok Koyu Arka Plan */
        --login-box-bg: #1e1e1e;
        /* Giriş Kutusu Arka Planı (Arka plandan biraz daha açık) */
        --text-color: #ffffff;
        /* Açık Metin */
        --light-text-color: #a0a0a0;
        /* Soluk Metin */
        --input-bg: #2c2c2c;
        /* Input Arka Planı */
        --input-border: #3a3a3a;
        --shadow-heavy: 0 10px 30px rgba(0, 0, 0, 0.4);
        /* Koyu Arka Planda Belirgin Gölge */
        --radius-none: 4px;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    body {
        background-color: var(--background-color);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: var(--text-color);
    }

    .login-container {
        width: 100%;
        max-width: 400px;
        padding: 20px;
    }

    .login-box {
        background-color: var(--login-box-bg);
        padding: 40px;
        border-radius: var(--radius-none);
        box-shadow: var(--shadow-heavy);
        border: 1px solid var(--input-border);
        text-align: center;
    }

    .logo {
        margin-bottom: 25px;
    }

    .logo i {
        font-size: 2.5rem;
        color: var(--primary-color);
        /* Neon vurgu */
        margin-bottom: 5px;
    }

    .logo h2 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-color);
    }

    .login-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 30px;
        color: var(--text-color);
        border-bottom: 2px solid var(--input-border);
        padding-bottom: 15px;
    }

    .form-group {
        text-align: left;
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--light-text-color);
        margin-bottom: 8px;
    }

    .input-with-icon {
        position: relative;
    }

    .input-with-icon i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--light-text-color);
        font-size: 0.9rem;
        transition: color 0.3s;
    }

    .input-with-icon input {
        width: 100%;
        padding: 12px 12px 12px 45px;
        border: 1px solid var(--input-border);
        border-radius: var(--radius-none);
        font-size: 1rem;
        background-color: var(--input-bg);
        /* Koyu input arka planı */
        color: var(--text-color);
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .input-with-icon input:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 188, 212, 0.4);
        /* Neon box shadow */
    }

    .input-with-icon input:focus+i {
        color: var(--primary-color);
    }

    .login-button {
        width: 100%;
        padding: 15px;
        background-color: var(--primary-color);
        color: var(--text-color);
        /* Koyu tema buton rengi */
        border: none;
        border-radius: var(--radius-none);
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        margin-top: 15px;
        transition: background-color 0.3s, transform 0.1s;
    }

    .login-button:hover {
        background-color: var(--primary-dark);
        transform: translateY(-1px);
    }

    .forgot-password {
        margin-top: 20px;
        font-size: 0.9rem;
    }

    .forgot-password a {
        color: var(--primary-color);
        text-decoration: none;
        transition: color 0.3s;
    }

    .forgot-password a:hover {
        text-decoration: underline;
    }


    @media (max-width: 1024px) {

        /* 1. Ana Kapsayıcıyı Güncelleme */
        .admin-container {
            grid-template-columns: 80px 1fr;
            /* Sidebar'ı ikon odaklı daralt */
        }

        /* 2. Sidebar'ı İkon Odaklı Yapma */
        .sidebar-menu ul li a {
            padding: 15px 0;
            /* Padding'i daralt */
            justify-content: center;
            align-items: center;
            flex-direction: column;
            /* İkon ve metni alt alta getir */
            font-size: 0.7rem;
            /* Yazı fontunu küçült */
        }

        .sidebar-menu ul li a i {
            margin-right: 0;
            /* İkon sağındaki boşluğu kaldır */
            margin-bottom: 5px;
            /* İkon ile metin arasına boşluk koy */
        }

        .sidebar-header .logo-text {
            display: none;
            /* Logo metnini gizle */
        }

        .sidebar-header {
            padding: 15px 0;
        }

        .sidebar-footer-action {
            display: none;
            /* Çıkış butonunu mobil navbar'a taşıyoruz */
        }

        /* 3. İçerik Gridini Düzenleme (4 sütunu 2 sütuna düşürme) */
        .dashboard-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            /* Daha az sütun */
            gap: 15px;
        }
    }

    @media (max-width: 768px) {

        /* 1. Ana Layout: Sidebar'ı Gizle */
        .admin-container {
            grid-template-columns: 1fr;
            /* Sadece tek içerik sütunu */
            grid-template-rows: auto 1fr auto;
        }

        aside#_sidebar {
            position: fixed;
            /* Akıştan çıkar */
            left: -250px;
            /* Ekran dışına kaydır (Gizli) */
            width: 250px;
            height: 100%;
            transition: left 0.3s;
            z-index: 200;
            /* Mobil menü açıldığında ekranı karartmak için overlay kullanılabilir */
        }

        /* Toggle sınıfı ile açılma kontrolü */
        aside#_sidebar.active {
            left: 0;
        }

        /* 2. Navbar: Menü Butonu Ekleme */
        nav#_navbar {
            grid-column: 1 / 2;
            /* Tam genişlik */
            padding: 10px 20px;
            justify-content: space-between;
            /* Sol ve sağ elemanları ayır */
        }

        /* Mobil Menü Butonu (Manuel eklemeniz gerekir) */
        nav#_navbar::before {
            content: "\f0c9";
            /* Font Awesome menü ikonu */
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-color);
            margin-right: 15px;
        }

        .navbar-actions {
            display: none;
            /* Küçük cihazlarda tüm butonları gizleyebiliriz */
        }

        .user-info {
            order: 1;
            /* Sağdaki profil resmini en sağa taşı */
        }

        /* 3. İçerik Alanı */
        section#content {
            grid-column: 1 / 2;
            padding: 20px;
            /* Padding'i azalt */
        }

        /* 4. Blok ve Tablo Düzeni */
        .dashboard-grid {
            grid-template-columns: 1fr;
            /* Tek sütunlu dikey yığın */
        }

        .data-table-container table,
        .data-table-container thead,
        .data-table-container tbody,
        .data-table-container th,
        .data-table-container td,
        .data-table-container tr {
            display: block;
            /* Tabloları mobil görünümde blok yap */
        }

        .data-table-container thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
            /* Başlıkları gizle */
        }

        .data-table-container td {
            border: none;
            border-bottom: 1px solid var(--border-color);
            position: relative;
            padding-left: 50%;
            /* Veri etiketleri için yer aç */
            text-align: right;
        }

        /* ... (Daha fazla tablo responsive stili eklenebilir) */
    }
</style>

<body>

    <div class="login-container">
        <div class="login-box">

            <div class="logo">
                <i class="fas fa-cubes"></i>
                <h2>ÖZEL DERS TAKİP</h2>
            </div>

            <h1 class="login-title">Giriş</h1>

            <form action="login_process.php" method="POST">

                <div class="form-group">
                    <label for="mail"></label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="mail" name="mail" placeholder="E-posta Adınızı Girin" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password"></label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Şifrenizi Girin" required>
                    </div>
                </div>

                <?php if (isset($_GET['error'])): ?>
                    <p style="
        color: #ff4d4d;
        background-color: rgba(255,0,0,0.1);
        padding: 8px;
        border-radius: 4px;
        margin-bottom: 15px;
        font-size: 0.9rem;
        text-align: center;
    ">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </p>
                <?php endif; ?>


                <button type="submit" class="login-button">GİRİŞ YAP</button>

                <div class="forgot-password">
                    <a href="#">Şifremi Unuttum</a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>


<?php



?>