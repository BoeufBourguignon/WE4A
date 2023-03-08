<?php

namespace Src;

class TestClass
{
    private string $attr;

    public function __construct()
    {
        $this->attr = "je suis un string";
    }

    public function getAttr(): string
    {
        return $this->attr;
    }
}