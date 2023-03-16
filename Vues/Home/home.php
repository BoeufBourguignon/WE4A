<?php
/**
 * @var $css
 */

$css .= <<<EOH
    <link rel="stylesheet" href="/PublicAssets/Style/main.css">
EOH;

$navbar = include(ROOT."/Vues/Assets/navbar.php");
$body = <<<EOH
    { $navbar }
EOH;
