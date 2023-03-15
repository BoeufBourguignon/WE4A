<?php
/**
 * @var $vue
 */
include VUES."/".$vue.".php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Banger</title>
    <meta charset="utf-8"/>

    <?php echo $css ?? null; ?>

    <?php echo $js ?? null; ?>
</head>
<body>
<?php echo $body ?? null; ?>
</body>
</html>