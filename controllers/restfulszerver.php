<?php

class Restfulszerver_Controller
{
    // A baseName változó tartalmazza a vezérlõhöz tartozó alapértelmezett nézet nevét
    public $baseName = 'restfulszerver';  

    // A main metódus fogadja a router által továbbított paramétereket
    public function main(array $vars)
    {
        // A nézet betöltése a View_Loader osztály segítségével
        // A nézet neve a baseName alapján lesz meghatározva, és a "_main" szuffixummal kiegészítve
        $view = new View_Loader($this->baseName . "_main");
    }
}

?>