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

            }
} else {
    }
?>
