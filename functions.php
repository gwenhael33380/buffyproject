<?php
session_start();
define('HOME_URL', 'http://buffyproject/');
define('PATH_PROJECT', __DIR__);


// pour éliminer la faille XSS
function sanitize_html($string) {
    return htmlspecialchars(trim($string));
}

function check_password($pass) {
    preg_match('#^(?=(.*[A-Z])+)(?=(.*[a-z])+)(?=(.*[\d])+)(?=.*\W)(?!.*\s).{8,16}$#', $pass, $match);
    if(empty($match)) {
        return FALSE;
    }
    return TRUE;
}

