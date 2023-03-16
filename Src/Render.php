<?php

namespace Src;

class Render
{
    private string $view;
    private ?string $extends = null;
    private array $blocks = array();

    public function __construct(string $view)
    {
        if(!file_exists(VUES."/".$view))
            throw new \Exception("La vue ".$view." n'existe pas");
        $this->view = $view;
    }

    public function render()
    {
        include VUES."/".$this->view;

        if(isset($this->extends))
            include VUES."/".$this->extends;
    }

    private function extends(string $view)
    {
        if($this->extends != null)
            throw new \Exception("Une vue ne peut en étendre qu'une seule autre");

        $this->extends = $view;
    }

    private function addBlock(string $block, string $content)
    {
        if(!isset($this->blocks[$block]))
            $this->blocks[$block] = array();

        $this->blocks[$block][] = $content;
    }

    private function drawBlock(string $block)
    {
        if(isset($this->blocks[$block]) && is_array($this->blocks[$block]))
        {
            foreach($this->blocks[$block] as $e)
            {
                echo $e;
            }
        }
    }

    private function getBlock(string $block): string
    {
        $str = "";
        if(isset($this->blocks[$block]) && is_array($this->blocks[$block]))
        {
            $str = implode('\n', $this->blocks[$block]);
        }
        return $str;
    }

    private function include(string $view, string $block)
    {
        if(!file_exists(VUES."/".$view))
            throw new \Exception("La vue ".$view." n'existe pas");
        include VUES."/".$view;
    }
}