<?php

// A dokumentum gyökere
define('SERVER_ROOT', $_SERVER['DOCUMENT_ROOT']);

// A weboldal gyökér URL-je, dinamikusan beállítva
define('SITE_ROOT', 'http://' . $_SERVER['HTTP_HOST'] . '/');

// Ellenőrizzük, hogy a fájl elérhető, és betöltjük
$filePath = SERVER_ROOT . 'controllers/router.php';
if (file_exists($filePath)) {
    require_once($filePath);
} else {
    echo "A szükséges fájl nem található: " . $filePath;
}
?>
