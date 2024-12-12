<?php

// Indítjuk a session-t, hogy a felhasználói adatokat tárolni tudjuk
session_start();

// Alapértelmezett session értékek beállítása, ha még nincsenek beállítva
if (!isset($_SESSION['userid'])) {
    $_SESSION['userid'] = 0;
}
if (!isset($_SESSION['userfirstname'])) {
    $_SESSION['userfirstname'] = "";
}
if (!isset($_SESSION['userlastname'])) {
    $_SESSION['userlastname'] = "";
}
if (!isset($_SESSION['userlevel'])) {
    $_SESSION['userlevel'] = "1__";
}

// Konstans változó, amely az alkalmazás gyökérkönyvtárát tárolja
define('SERVER_ROOT', __DIR__ . '/');

// A szükséges fájlok beillesztése
include(SERVER_ROOT . 'includes/database.inc.php');
include(SERVER_ROOT . 'includes/menu.inc.php');
include(SERVER_ROOT . 'reg.php');

// Alapértelmezett oldalt és aloldalt beállítjuk
$page = "nyitolap";
$subpage = "";
$vars = array();

// Az aktuális kérés (query string) kiolvasása
$request = $_SERVER['QUERY_STRING'];
if ($request != "") {
    // A kérés paramétereit a '/' karakterek mentén feldaraboljuk
    $params = explode('/', trim($request, '/'));
    
    // Az oldal nevének meghatározása, ha nem található, akkor alapértelmezett: 'nyitolap'
    $page = htmlspecialchars(array_shift($params) ?? 'nyitolap', ENT_QUOTES, 'UTF-8');
    
    // Ellenõrizzük, hogy az oldal szerepel-e a menüben, és van-e aloldal
    if (array_key_exists($page, Menu::$menu) && count($params) > 0) {
        // Az aloldalt is kinyerjük
        $subpage = htmlspecialchars(array_shift($params), ENT_QUOTES, 'UTF-8');
        
        // Ha az aloldal nem tartozik az adott oldalhoz, akkor nem létezik, és hozzáadjuk a változókhoz
        if (!(array_key_exists($subpage, Menu::$menu) && Menu::$menu[$subpage][1] == $page)) {
            $vars[] = $subpage;
            $subpage = "";
        }
    }
    // A változók (GET, POST) egyesítése
    $vars = array_merge($vars, $_GET, $_POST);
}

// A vezérlõ fájl meghatározása az oldal és az aloldal alapján
$controllerfile = $page . ($subpage != "" ? "_" . $subpage : "");
$target = SERVER_ROOT . 'controllers/' . $controllerfile . '.php';

// Ha a vezérlõ fájl nem található, akkor az 404-es hibát töltjük be
if (!file_exists($target)) {
    $controllerfile = "error404";
    $target = SERVER_ROOT . 'controllers/error404.php';
}

// A vezérlõ fájl betöltése
include_once($target);

// A vezérlõ osztály nevét generáljuk
$class = ucfirst($controllerfile) . '_Controller';

// Ha létezik a vezérlõ osztály, akkor példányosítjuk, különben 404-es hibát jelenítünk meg
if (class_exists($class)) {
    $controller = new $class;
} else {
    include_once(SERVER_ROOT . 'controllers/error404.php');
    die('Class does not exist. Redirecting to error page.');
}

// Az autoload funkció regisztrálása, amely automatikusan betölti a modelleket
spl_autoload_register(function ($className) {
    $file = SERVER_ROOT . 'models/' . strtolower($className) . '.php';
    if (file_exists($file)) {
        include_once($file);
    } else {
        die("File '$file' containing class '$className' not found.");
    }
});

// A vezérlõ fõ metódusának meghívása a változókkal
$controller->main($vars);
?>
