<?php
const ROOT = __DIR__;


require_once ROOT . "/Src/BaseApp.php";
$app = new Src\BaseApp();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Banger</title>
    <meta charset="utf-8"/>
</head>
<body>
<?php
$app->launchApp();
?>
</body>
</html>

