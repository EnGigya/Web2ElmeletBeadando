<?php

//alkalmaz�s gy�k�r k�nyvt�ra a szerveren
define('SERVER_ROOT', $_SERVER['DOCUMENT_ROOT'].'/web2/');

//URL c�m az alkalmaz�s gy�ker�hez
define('SITE_ROOT', 'http://127.0.0.1/web2/');

// a router.php vez�rl� bet�lt�se
require_once(SERVER_ROOT . 'controllers/' . 'router.php');

?>