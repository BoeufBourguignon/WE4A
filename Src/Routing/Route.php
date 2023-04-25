<?php

namespace Src\Routing;

use Attribute;

/**
 * Un attribut Route permet d'associer automatiquement une action d'un contrôleur à une URL
 */
#[Attribute]
class Route
{
    private string $path;
    private ?string $name;
    private ?string $title;
    private bool $isAjax;
    private ?\ReflectionMethod $method = null;
    private array $elements;

    /**
     * @param string $path URL associé à la Route
     * @param string|null $name Nom de la route (pas utilisé)
     * @param string|null $title Si renseigné, changera le titre de la page (attribut HTML <title>)
     * @param bool $isAjax Booléen spécifiant si la route ne doit être accessible qu'en AJAX
     */
    public function __construct(string $path, ?string $name = null, ?string $title = null, bool $isAjax = false)
    {
        $this->path = $path;
        $this->name = $name;
        $this->title = $title;
        $this->isAjax = $isAjax;
    }

    /**
     * On considére une route comme étant constituée de plusieurs éléments, chacuns étant spéarés par un "/"
     * Exemple : /test/element, est consituté des éléments "test" et "element"
     *
     * Un élément peut être considéré comme étant un paramètre s'il apparait dans la Route entouré d'accolades
     * Exemple : /test/{param}, est constitué des éléments "test" et "param", ce dernier étant un paramètre
     *
     * La valeur du paramètre est celle apparaissant dans l'URL à sa place
     * Exemple : /test/{param} avec l'URL /test/salut, l'élément "param" a comme valeur "salut"
     *
     * @return array Liste des elements constituants une Route
     */
    public function getAllElements(): array
    {
        if(!isset($this->elements))
        {
            // On récupère la liste des éléments de la route
            $route = explode("/", ltrim($this->path, "/"));
            $this->elements = array();

            // On vérifie pour chaque élement si celui-ci est un paramètre
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

    /**
     * Retourne la liste des paramètres de la route (c'est à dire les éléments qui sont des paramètres)
     *
     * @return array
     */
    public function getAllParams(): array
    {
        $params = array();
        foreach($this->getAllElements() as $element)
            if($element->isParam())
                $params[] = $element;
        return $params;
    }

    /**
     * Récupère les valeurs des paramètres de la Route, selon l'URL de la page
     *
     * @param array $path URL
     *
     * @return void
     *
     * @throws \Exception
     */
    public function loadParams(array $path): void
    {
        // Si le nombre d'éléments dans l'URL est différent du nombre d'éléments de la Route, erreur
        if(count($path) != count($this->elements))
            throw new \Exception("Erreur entre la route de l'URL et son objet");

        // Pour chaque élément, s'il s'agit d'un paramètre, la valeur de celui-ci lui est renseignée
        for($i=0;$i<count($path);++$i)
        {
            if($this->elements[$i]->isParam())
            {
                $this->elements[$i]->setValue($path[$i]);
            }
        }
    }


    // Mutateurs
    /**
     * @return string
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * @param \ReflectionMethod $method
     * @return void
     */
    public function setMethod(\ReflectionMethod $method): void
    {
        $this->method = $method;
    }

    /**
     * @return \ReflectionMethod|null
     */
    public function getMethod(): ?\ReflectionMethod
    {
        return $this->method;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return count(explode("/", ltrim($this->path, "/")));
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return bool
     */
    public function isAjax(): bool
    {
        return $this->isAjax;
    }
}