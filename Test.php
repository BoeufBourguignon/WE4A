<?php

#[Attribute]
class Test
{
    private string $path;
    private ?string $name;

    public function __construct(string $path = null, ?string $name = null)
    {
        $this->path = $path;
        $this->name = $name;
    }

    public function getPath() : string
    {
        return $this->path;
    }

    public function getName() : string
    {
        return $this->name;
    }
}