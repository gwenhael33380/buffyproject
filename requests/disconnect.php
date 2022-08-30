<?php

    $h = new DateTime('now', new DateTimeZone('EUROPE/Paris'));
    $connect_date = $h->format('d/m/Y à H\hi');
    $h->add(new DateInterval('P1Y'));
    $end_time = $h->getTimestamp();
    setcookie('last_visit', $connect_date, $end_time, '/');


//call function
require dirname(__DIR__) . '/functions.php';

// session deletion
unset($_SESSION);

// destroy session
session_destroy();

//redirect to home page with logout message
header('Location: ' . HOME_URL . '?msg=<p class="msg_success">Vous êtes bien déconnecté</p>');
