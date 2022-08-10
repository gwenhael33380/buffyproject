<?php

define("HOST", 'localhost');
$server_name = $_SERVER['SERVER_NAME'];
define("DB_NAME", $server_name == 'buffyproject' ? 'buffyproject' : 'dgkzpdzg_buffyproject');
define('USER', $server_name == 'buffyproject' ? 'root' : 'dgkzpdzg_lecorre');
define('PASS', $server_name == 'buffyproject' ? '' : 'a1&Tre0r1ERTR10R8e');
// pour se connecter, on va utiliser la classe native PHP PDO
define('UTF','utf8');

try{
    $db = new PDO('mysql:host=' . HOST . ';dbname=' . DB_NAME . ';charset=' . UTF,  USER,   PASS);
}

catch (Exception $e)
{
    die('Erreur : ' .$e->getMessage());
}