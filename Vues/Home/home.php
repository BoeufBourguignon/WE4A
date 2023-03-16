<?php
$this->extends("base.php");

$this->addBlock("css", <<<EOH
    <link rel='stylesheet' href='/PublicAssets/Style/main.css'>
EOH);

$this->include("Assets/navbar.php", "navbar");
$this->addBlock("body", <<<EOH
    {$this->getBlock("navbar")}
    <div id="canvas">
        <h1>Test</h1>
    </div>
EOH);
