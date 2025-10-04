<h1 style="font-weight: 700; font-size: 1.8rem; margin-bottom: 30px; color: var(--text-color);">Programım ve Özet</h1>

<div class="dashboard-layout">

    <div class="main-program-area">

        <div class="content-block">
            <div class="block-title"><i class="fas fa-calendar-day" style="margin-right: 10px;"></i> Bugünün Dersleri
                (25 Eylül)</div>

            <ul class="lesson-list">
                <li>
                    <span class="lesson-time">10:00 - 11:30</span>
                    <span class="lesson-subject">İngilizce A2</span>
                    <span class="lesson-student">Öğrenci: Ayşe Y.</span>
                    <a href="#" style="color: var(--primary-color); text-decoration: none;">Başlat <i
                            class="fas fa-play"></i></a>
                </li>
                <li>
                    <span class="lesson-time">14:00 - 15:30</span>
                    <span class="lesson-subject">Matematik LGS</span>
                    <span class="lesson-student">Öğrenci: Mehmet A.</span>
                    <a href="#" style="color: var(--primary-color); text-decoration: none;">Başlat <i
                            class="fas fa-play"></i></a>
                </li>
                <li>
                    <span class="lesson-time">17:00 - 18:00</span>
                    <span class="lesson-subject">Kimya TYT</span>
                    <span class="lesson-student">Öğrenci: Veli S.</span>
                    <span style="color: #c0392b;">Bitti</span>
                </li>
            </ul>
        </div>

        <div class="content-block" style="flex-grow: 1;">
            <div class="block-title"><i class="fas fa-calendar-week" style="margin-right: 10px;"></i> Haftalık Takvim
                Önizlemesi</div>
            <div style="min-height: 200px; color: var(--light-text-color);">
                Burada tam haftalık takvim (Chart.js veya basit bir HTML tablosu) gösterilebilir.
            </div>
        </div>

    </div>

    <div class="quick-action-area">

        <div class="content-block">
            <div class="block-title"><i class="fas fa-chart-bar" style="margin-right: 10px;"></i> Performans Özeti</div>

            <div class="metric-grid">
                <div class="metric-item">
                    <div class="metric-value">68</div>
                    <div class="metric-label">Toplam Ders Saati (Bu Ay)</div>
                </div>
                <div class="metric-item">
                    <div class="metric-value">12</div>
                    <div class="metric-label">Aktif Öğrenci Sayısı</div>
                </div>
                <div class="metric-item" style="border-color: #f39c12;">
                    <div class="metric-value" style="color: #f39c12;">2</div>
                    <div class="metric-label">Bekleyen Rapor (Son Dersler)</div>
                </div>
            </div>
        </div>

        <div class="content-block action-buttons">
            <div class="block-title"><i class="fas fa-bolt" style="margin-right: 10px;"></i> Hızlı Aksiyonlar</div>

            <button onclick="window.location.href='t_reports.php?new=true'">
                <i class="fas fa-clipboard-list"></i> Yeni Ders Raporu Oluştur
            </button>
            <button onclick="window.location.href='t_students.php'">
                <i class="fas fa-user-plus"></i> Yeni Öğrenci Ata
            </button>
            <button style="background-color: var(--light-text-color);" onclick="window.location.href='t_material.php'">
                <i class="fas fa-upload"></i> Yeni Materyal Yükle
            </button>
        </div>

    </div>

</div>