<?php

require dirname(__DIR__) . '/functions.php';
// on efface le session
unset($_SESSION);
// on détruit la session
session_destroy();

header('Location: ' . HOME_URL . '?msg=<p id="disconnect_user" class="disconnect_user">Vous êtes bien déconnecté</p>');