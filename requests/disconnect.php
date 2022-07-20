<?php
//call function
require dirname(__DIR__) . '/functions.php';

// session deletion
unset($_SESSION);

// destroy session
session_destroy();

//redirect to home page with logout message
header('Location: ' . HOME_URL . '?msg=<p id="disconnect_user" class="disconnect_user">Vous êtes bien déconnecté</p>');