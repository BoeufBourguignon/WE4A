<?php
/**
 * @var $vue
 */
$css = "";
$js = "";
$body = "";

include VUES."/".$vue.".php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Banger</title>
    <meta charset="utf-8"/>

    <?php echo $css ?>

    <?php echo $js ?>
</head>
<body>
<?php echo $body; ?>
</body>
</html>