<?php
// Aktif sayfayı belirle
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside id="_sidebar">
    <div class="sidebar-header">
        <a href="#" class="logo-text">Yönetim | Paneli</a>
    </div>

    <div class="sidebar-menu">
        <ul>
            <li><a href="../home/index.php" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>"><i
                        class="fas fa-chart-pie"></i> Kontrol Paneli</a></li>
            <li><a href="../student/slist.php" class="<?php echo $current_page == 'slist.php' ? 'active' : ''; ?>"><i
                        class="fas fa-user-check"></i> Öğrenci Kayıtları</a></li>
            <li><a href="../teacher/list.php" class="<?php echo $current_page == 'list.php' ? 'active' : ''; ?>"><i
                        class="fas fa-user-shield"></i> Eğitmen Yönetimi</a></li>
            <li><a href="dersler.php" class="<?php echo $current_page == 'dersler.php' ? 'active' : ''; ?>"><i
                        class="fas fa-book-open"></i> Ders & Programlar</a></li>
            <li><a href="odemeler.php" class="<?php echo $current_page == 'odemeler.php' ? 'active' : ''; ?>"><i
                        class="fas fa-hand-holding-usd"></i> Finansal İşlemler</a></li>
            <li><a href="raporlar.php" class="<?php echo $current_page == 'raporlar.php' ? 'active' : ''; ?>"><i
                        class="fas fa-stream"></i> Aktivite Raporları</a></li>
            <li><a href="ayarlar.php" class="<?php echo $current_page == 'ayarlar.php' ? 'active' : ''; ?>"><i
                        class="fas fa-sliders-h"></i> Sistem Ayarları</a></li>
        </ul>
    </div>

    <div class="sidebar-footer-action">
        <button class="sidebar-logout-btn" onclick="window.location.href='../../controller/logout.php'">
            <i class="fas fa-sign-out-alt"></i> ÇIKIŞ YAP
        </button>
    </div>
</aside>