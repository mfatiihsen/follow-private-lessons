<!DOCTYPE html>
<html lang="tr">
<?php include("_head.php"); ?>
<?php include("_auth.php"); ?>

<body>

    <div class="admin-container">

        <?php include('_navbar.php'); ?>

        <?php include('_sidebar.php'); ?>

        <section id="content">
            <?php echo $content; ?>
        </section>

        <?php include('_footer.php'); ?>

    </div>


</body>

</html>