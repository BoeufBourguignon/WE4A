<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Readit</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="/PublicAssets/Style/main.css">
</head>
<body>
<div id="main">
    <div class="canvas">
        <div class="post">
            <h1>Une erreur est survenue</h1>
            <?php
            /** @var Exception $e */
            echo "<p>" . $e->getMessage() . "</p>";
            ?>
        </div>
    </div>
</div>
</body>
</html>
