<?php

include "Test.php";

$action = "test12";


$files = array_diff(scandir("./Tests"), array('..', '.'));

var_dump($files);

foreach($files as $file)
{

}



