<?php

//    setcookie('last_visit', time() - 6000, null, null, false, true);

    $day = date('d'); //the day
    $month = date('m'); //the month
    $years = date('Y'); //the years
//    $h = date('H'); //the years
//    $h1 = date('i'); //the years
//    $h2 = date('s'); //the years


$date = ''. $day .'/'. $month .'/'. $years .''; //date format

setcookie('last_visit', $date, time() + 60*60*24*365, null, null, false, true); //la création du cookie (avec httpOnly activé)







//var_dump($_COOKIE['last_visit']);die;

//call function
require dirname(__DIR__) . '/functions.php';

// session deletion
unset($_SESSION);

// destroy session
session_destroy();

//redirect to home page with logout message
header('Location: ' . HOME_URL . '?msg=<p class="msg_success">Vous êtes bien déconnecté</p>');
