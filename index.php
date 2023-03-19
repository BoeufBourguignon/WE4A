<?php
session_start();

const ROOT = __DIR__;
const VIEWS = ROOT."/Vues";

require_once ROOT . "/Src/BaseApp.php";

$app = new Src\BaseApp();

$app->launchApp();
