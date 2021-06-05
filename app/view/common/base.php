<!DOCTYPE html>
<html lang="en">
<?php
include('head.php');
?>

<body>

    <div class="container mx-auto">
        <?php
        include 'navigation.php'; ?>
        <?php
        if (isset($vars["succes"])) { ?>
            <div id="sucess_message" class="w-1/2 ml-auto alert flex flex-row items-center bg-green-200 p-5 rounded border-b-2 border-green-300 mt-2">
                <div class="alert-icon flex items-center bg-green-100 border-2 border-green-500 justify-center h-10 w-10 flex-shrink-0 rounded-full">
                    <span class="text-green-500">
                        <svg fill="currentColor" viewBox="0 0 20 20" class="h-6 w-6">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </span>
                </div>
                <div class="alert-content ml-4">
                    <div class="alert-title font-semibold text-lg text-green-800">
                        Success
                    </div>
                    <div class="alert-description text-sm text-green-600">

                        <?= $vars["succes"] ?>
                    </div>
                </div>
            </div>
        <?php
        } ?>
        <?php include $vars['templatePath'] ?>
    </div>

    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    <script src="<?= $vars['baseUrl'] ?>public/js/all.js"></script>
</body>

</html>