<?php

// Ind�tjuk a session-t, hogy a felhaszn�l�i adatokat t�rolni tudjuk
session_start();

// Alap�rtelmezett session �rt�kek be�ll�t�sa, ha m�g nincsenek be�ll�tva
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

// Konstans v�ltoz�, amely az alkalmaz�s gy�k�rk�nyvt�r�t t�rolja
define('SERVER_ROOT', __DIR__ . '/');

// A sz�ks�ges f�jlok beilleszt�se
include(SERVER_ROOT . 'includes/database.inc.php');
include(SERVER_ROOT . 'includes/menu.inc.php');
include(SERVER_ROOT . 'reg.php');

// Alap�rtelmezett oldalt �s aloldalt be�ll�tjuk
$page = "nyitolap";
$subpage = "";
$vars = array();

// Az aktu�lis k�r�s (query string) kiolvas�sa
$request = $_SERVER['QUERY_STRING'];
if ($request != "") {
    // A k�r�s param�tereit a '/' karakterek ment�n feldaraboljuk
    $params = explode('/', trim($request, '/'));
    
    // Az oldal nev�nek meghat�roz�sa, ha nem tal�lhat�, akkor alap�rtelmezett: 'nyitolap'
    $page = htmlspecialchars(array_shift($params) ?? 'nyitolap', ENT_QUOTES, 'UTF-8');
    
    // Ellen�rizz�k, hogy az oldal szerepel-e a men�ben, �s van-e aloldal
    if (array_key_exists($page, Menu::$menu) && count($params) > 0) {
        // Az aloldalt is kinyerj�k
        $subpage = htmlspecialchars(array_shift($params), ENT_QUOTES, 'UTF-8');
        
        // Ha az aloldal nem tartozik az adott oldalhoz, akkor nem l�tezik, �s hozz�adjuk a v�ltoz�khoz
        if (!(array_key_exists($subpage, Menu::$menu) && Menu::$menu[$subpage][1] == $page)) {
            $vars[] = $subpage;
            $subpage = "";
        }
    }
    // A v�ltoz�k (GET, POST) egyes�t�se
    $vars = array_merge($vars, $_GET, $_POST);
}

// A vez�rl� f�jl meghat�roz�sa az oldal �s az aloldal alapj�n
$controllerfile = $page . ($subpage != "" ? "_" . $subpage : "");
$target = SERVER_ROOT . 'controllers/' . $controllerfile . '.php';

// Ha a vez�rl� f�jl nem tal�lhat�, akkor az 404-es hib�t t�ltj�k be
if (!file_exists($target)) {
    $controllerfile = "error404";
    $target = SERVER_ROOT . 'controllers/error404.php';
}

// A vez�rl� f�jl bet�lt�se
include_once($target);

// A vez�rl� oszt�ly nev�t gener�ljuk
$class = ucfirst($controllerfile) . '_Controller';

// Ha l�tezik a vez�rl� oszt�ly, akkor p�ld�nyos�tjuk, k�l�nben 404-es hib�t jelen�t�nk meg
if (class_exists($class)) {
    $controller = new $class;
} else {
    include_once(SERVER_ROOT . 'controllers/error404.php');
    die('Class does not exist. Redirecting to error page.');
}

// Az autoload funkci� regisztr�l�sa, amely automatikusan bet�lti a modelleket
spl_autoload_register(function ($className) {
    $file = SERVER_ROOT . 'models/' . strtolower($className) . '.php';
    if (file_exists($file)) {
        include_once($file);
    } else {
        die("File '$file' containing class '$className' not found.");
    }
});

// A vez�rl� f� met�dus�nak megh�v�sa a v�ltoz�kkal
$controller->main($vars);
?>
