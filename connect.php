<?php
// pour se connecter, on va utiliser la classe native PHP PDO
try{
    $db = new PDO('mysql:host=localhost;dbname=buffyproject;charset=utf8', 'root', '');
}
catch (Exception $e)
{
    die('Erreur : ' .$e->getMessage());
}