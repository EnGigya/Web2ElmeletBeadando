<?php
require_once 'controllers/FelhasznaloController.php';

$controller = new FelhasznaloController();

if (isset($_GET['felhasznalo'])) {
    $action = $_GET['felhasznalo'];

    switch ($action) {
        case 'regisztracio':
            $controller->regisztracio();
            break;

        case 'regisztral':
            $controller->regisztral();
            break;

        default:
            echo "<h1>Hiba: A k�rt oldal nem tal�lhat�.</h1>";
            break;
    }
} else {
   }
?>
