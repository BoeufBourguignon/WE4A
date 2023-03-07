<?php

include "Test.php";


class Allo {

    #[Test("test", name:"salut")]
    public function test()
    {
        echo "bonjour";
    }
}

$path = "test";


$r = new ReflectionClass(Allo::class);
$methods = $r->getMethods(ReflectionMethod::IS_PUBLIC);
foreach($methods as $method)
{
    $attributes = $method->getAttributes(Test::class);
    foreach($attributes as $attribute)
    {
        if($path === $attribute->newInstance()->getPath())
        {
            $obj = new Allo();
            $obj->test();
        }
    }
}


