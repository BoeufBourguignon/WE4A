<?php
$this->addBlock("css", "
    <link rel='stylesheet' href='/PublicAssets/Style/navbar.css'>
");

$test["test"] = "test";

/** @var $block */
$this->addBlock($block, "
    <nav id='main_nav'>
        <p>Accueil</p>
        <input type='text' id='search' placeholder='Rechercher...'>
        <div>UTILISATEUR</div>
    </nav>
");
