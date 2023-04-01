<!DOCTYPE html>
<html lang="fr">
<head>
    <title><?php echo $this->route->getTitle() ?? "Projet WE4A" ?></title>
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
</head>
<body>
<div id="main" <?php if(!isset($navbar) || $navbar) echo "class=\"has-navbar\""; ?>>
    <?php
    if(!isset($navbar) || $navbar)
        include(VIEWS."/Assets/navbar.php");

    /** @var $view */
    include VIEWS."/".$view;
    ?>
</div>

<script src="/PublicAssets/Js/navbar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="/PublicAssets/Js/axios-config.js"></script>
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
</body>
</html>
