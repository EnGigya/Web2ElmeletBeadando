<?php

class Restfulszerver_Controller
{
    // A baseName v�ltoz� tartalmazza a vez�rl�h�z tartoz� alap�rtelmezett n�zet nev�t
    public $baseName = 'restfulszerver';  

    // A main met�dus fogadja a router �ltal tov�bb�tott param�tereket
    public function main(array $vars)
    {
        // A n�zet bet�lt�se a View_Loader oszt�ly seg�ts�g�vel
        // A n�zet neve a baseName alapj�n lesz meghat�rozva, �s a "_main" szuffixummal kieg�sz�tve
        $view = new View_Loader($this->baseName . "_main");
    }
}

?>