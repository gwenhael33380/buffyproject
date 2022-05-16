<?php

require dirname(__DIR__) . '/functions.php';
// on efface le session
unset($_SESSION);
// on détruit la session
session_destroy();

header('Location: ' . HOME_URL . '?msg=<div class="green">Vous êtes bien déconnecté</div>');