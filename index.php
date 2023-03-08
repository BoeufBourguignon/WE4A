<?php
const ROOT = __DIR__;

require_once ROOT . "/src/AutoLoader.php";
new Src\AutoLoader();


$actionUrl = "test12";

$controller = null;
$action = null;

$files = array_diff(scandir("./Tests"), array('..', '.'));
foreach($files as $file)
{
    $class = pathinfo($file, PATHINFO_FILENAME);

    // La on fait la reflection sur la fichier
    try
    {
        $r = new ReflectionClass("Controller\\" . $class);
        foreach($r->getMethods() as $method)
        {
            foreach($method->getAttributes(Src\Route\TestAttr::class, ReflectionAttribute::IS_INSTANCEOF) as $attr)
            {
                if($attr->newInstance()->getPath() == $actionUrl)
                {
                    $controller = "Controller\\".$class;
                    $action = $method->getName();
                }
            }
        }
    }
    catch (ReflectionException $e)
    {
        var_dump($e);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Banger</title>
    <meta charset="utf-8"/>
</head>
<body>
<?php
$controllerObj = new $controller;
$controllerObj->$action();
?>
</body>
</html>

