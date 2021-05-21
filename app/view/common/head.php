<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- tailwind import -->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <!------ Include the above in your HEAD tag ---------->
    <link rel="stylesheet" href="<?= $vars['baseUrl'] ?>public/css/style.css">
    <link rel="stylesheet" href="<?= $vars['baseUrl'] ?>public/fontawesome-free-5.15.1-web/css/all.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <?php
    if (isset($vars['stylesheet'])) {
        echo ' <link rel="stylesheet" href="' . $vars['baseUrl'] . 'public/css/' . $vars['stylesheet'] . '.css">';
    } ?>

    <style>
        div.dataTables_wrapper {
            width: 100%;
            margin: 0 auto;
        }
        div.dataTables_scrollHead{
            width: 100%;
            margin: 0 auto;
        }
        div.dataTables_scrollHeadInner{
            width: 100% !important;
        }
        table.tab_datatable{
            width: 100% !important;
        }

        @media (min-width: 640px) {
            table {
                display: inline-table !important;
            }

            thead tr:not(:first-child) {
                display: none;
            }
        }

    </style>

    <link href="https://fonts.googleapis.com/css?family=Source+Code+Pro|Roboto&display=swap" rel="stylesheet">
    <script>
        let vars = <?= json_encode($vars['jsVars'] ?? []) ?>;
    </script>
</head>