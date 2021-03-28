<!DOCTYPE html>
<html lang="en">
<?php
include(__DIR__ . './head.php');
?>

<body>

    <div class="container mx-auto">
        <?php
        include 'navigation.php'; ?>
        <?php include $vars['templatePath'] ?>
    </div>

    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
   
    <script src="<?= $vars['baseUrl'] ?>public/js/all.js"></script>
</body>

</html>