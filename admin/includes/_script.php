<script>
    // Sayfa yüklendiğinde önbelleği temizle
    window.onload = function () {
        if (performance.navigation.type === 2) {
            // Geri butonu ile gelindiğinde
            window.location.reload(true); // Sunucudan yeniden yükle
        }
    };

    // Sayfadan ayrılırken önbelleği temizle
    window.onbeforeunload = function () {
        // Önbellek kontrolü
    };
</script>