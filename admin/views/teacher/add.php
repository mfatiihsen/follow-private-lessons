<?php
$title = "Eğitmen Ekle";
ob_start();
?>



<h1 style="font-weight: 700; font-size: 1.8rem; margin-bottom: 30px; color: var(--text-color);">Yeni Eğitmen Kaydı</h1>

<div class="form-card">
    <form action="../../controller/teacheradd.php" method="POST">

        <div class="form-grid">

            <div class="section-heading">Kişisel Bilgiler</div>

            <div class="form-group">
                <label for="ad_soyad">Adı Soyadı *</label>
                <input type="text" id="ad_soyad" name="ad_soyad" required>
            </div>

            <div class="form-group">
                <label for="tc_kimlik">TC Kimlik No</label>
                <input maxlength="11" type="text" id="tc_kimlik" name="tc_kimlik"
                    placeholder="Sözleşme için gereklidir">
            </div>

            <div class="form-group">
                <label for="telefon">Telefon *</label>
                <input type="tel" id="telefon" name="telefon" required>
            </div>

            <div class="form-group">
                <label for="dogum_tarihi">Doğum Tarihi</label>
                <input type="date" id="dogum_tarihi" name="dogum_tarihi">
            </div>

            <div class="section-heading">İletişim ve Adres</div>

            <div class="form-group">
                <label for="email">E-Posta * (Kullanıcı Adı)</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="adres_ilce">İlçe / Şehir</label>
                <input type="text" id="adres_ilce" name="adres_ilce">
            </div>

            <div class="form-group full-width">
                <label for="adres_detay">Açık Adres</label>
                <textarea id="adres_detay" name="adres_detay"></textarea>
            </div>


            <div class="section-heading">Giriş ve Yetkilendirme Bilgileri</div>

            <div class="form-group">
                <label for="password">Şifre *</label>
                <input type="password" id="password" name="password" required placeholder="Giriş için ilk şifre">
            </div>



            <div class="section-heading">Görev ve Uzmanlık Alanı</div>

            <div class="form-group">
                <label for="brans">Branş *</label>
                <select id="brans" name="brans" required>
                    <option value="">Seçiniz</option>
                    <option value="Matematik">Matematik</option>
                    <option value="Fizik">Fizik</option>
                    <option value="Ingilizce">İngilizce</option>
                    <option value="Kimya">Kimya</option>
                </select>
            </div>

            <div class="form-group">
                <label for="egitim_seviyesi">Eğitim Seviyesi</label>
                <input type="text" id="egitim_seviyesi" name="egitim_seviyesi"
                    placeholder="Örn: Yüksek Lisans, Doktora">
            </div>


        </div>

        <div class="button-group">
            <button type="button" class="cancel-btn" onclick="window.history.back()">İPTAL</button>
            <button type="submit" class="save-btn"><i class="fas fa-save"></i> KAYDET VE EKLE</button>
        </div>
    </form>
</div>


<?php
$content = ob_get_clean();
include('../../includes/_layout.php');