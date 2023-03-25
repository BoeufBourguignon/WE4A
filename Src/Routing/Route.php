<?php

namespace Src\Routing;

use Attribute;

#[Attribute]
class Route
{
    private string $path;
    private ?string $name;
    private ?string $title;
    private ?\ReflectionMethod $method = null;
    private array $elements;

    public function __construct(string $path, ?string $name = null, ?string $title = null)
    {
        $this->path = $path;
        $this->name = $name;
        $this->title = $title;
    }

    public function getAllElements(): array
    {
        if(!isset($this->elements))
        {
            $route = explode("/", ltrim($this->path, "/"));
            $this->elements = array();

            foreach($route as $element)
            {
                $e = new RouteElement();
                $e->setName(trim($element, "{}"));
                $e->setIsParam(preg_match("/{.*}/", $element));

                $this->elements[] = $e;
            }
        }
        return $this->elements;
    }

    public function getAllParams(): array
    {
        $params = array();
        foreach($this->getAllElements() as $element)
            if($element->isParam())
                $params[] = $element;
        return $params;
    }

    /**
     * @throws \Exception
     */
    public function loadParams(array $path): void
    {
        if(count($path) != count($this->elements))
            throw new \Exception("Erreur entre la route de l'URL et son objet");

        for($i=0;$i<count($path);++$i)
        {
            if($this->elements[$i]->isParam())
            {
                $this->elements[$i]->setValue($path[$i]);
            }
        }
    }

    public function getPath() : string
    {
        return $this->path;
    }

    public function setMethod(\ReflectionMethod $method): void
    {
        $this->method = $method;
    }

    public function getMethod(): ?\ReflectionMethod
    {
        return $this->method;
    }

    public function getSize(): int
    {
        return count(explode("/", ltrim($this->path, "/")));
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
}