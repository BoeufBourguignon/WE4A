<?php
const ROOT = __DIR__;
const VUES = ROOT."/Vues";

require_once ROOT . "/Src/BaseApp.php";

$app = new Src\BaseApp();

$app->launchApp();
