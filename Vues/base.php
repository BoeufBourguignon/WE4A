<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Banger</title>
    <meta charset="utf-8"/>

    <link rel="stylesheet" href="/PublicAssets/Style/navbar.css">
    <link rel="stylesheet" href="/PublicAssets/Style/main.css">
    <?php
    if(isset($css))
    {
        foreach($css as $line)
        {
            ?>
            <link rel="stylesheet" href="/PublicAssets/Style/<?php echo $line ?>">
            <?php
        }
    }
    ?>

    <script src="/PublicAssets/Js/navbar.js"></script>
    <?php
    if(isset($js))
    {
        foreach($js as $line)
        {
            ?>
            <script src="/PublicAssets/Js/<?php echo $line ?>"></script>
            <?php
        }
    }
    ?>
</head>
<body>
<div id="main">
    <?php
    if(!isset($navbar) || $navbar)
        include(VIEWS."/Assets/navbar.php");

    /** @var $view */
    include VIEWS."/".$view;
    ?>
</div>
</body>
</html>
