<!DOCTYPE html>
<html lang="tr">
<?php include("_head.php"); ?>

<body>

    <div class="teacher-container">

        <?php include('_navbar.php'); ?>

        <?php include('_sidebar.php'); ?>

        <section id="content">
            <?php echo $content; // Burası öğretmenin göreceği içerik (Ders Takvimi, Öğrenci Listesi vb.) ?>
        </section>

        <?php include('_footer.php'); ?>

    </div>


</body>

</html>