<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <!------ Include the above in your HEAD tag ---------->
    <link rel="stylesheet" href="<?= $vars['baseUrl'] ?>public/css/style.css">

    <link rel="stylesheet" href="<?= $vars['baseUrl'] ?>public/fontawesome-free-5.15.1-web/css/all.css">
    <?php
    if (isset($vars['stylesheet'])) {
        echo ' <link rel="stylesheet" href="' . $vars['baseUrl'] . 'public/css/' . $vars['stylesheet'] . '.css">';
    } ?>

    <!-- tailwind import -->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css?family=Source+Code+Pro|Roboto&display=swap" rel="stylesheet">

</head>