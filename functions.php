<?php
session_start();
define('HOME_URL', 'http://buffyproject/');
define('PATH_PROJECT', __DIR__);
define('IMG_URL', HOME_URL . 'assets/img/');

// function pour rediriger vers la homePage si $enable_access existe et n'est pas nul
function enabled_access(Array $enabled_access) {
	// if($_SERVER['REQUEST_URI'] != '/') : // je verifie que je ne suis pas dans la page home sinon boucle infinie
		if(
			!isset($_SESSION['id_user'])  // si je ne suis pas connecté
			|| // OR
			(
				isset($enable_access)
				&& // ET
				isset($_SESSION['id_user'])
				&&
				// si le rôle n'est pas dans le tableau
				!in_array($_SESSION['role_slug'], $enable_access)
			)
		) :
			header('Location: ' . HOME_URL);
		endif;
	// endif;
}


// pour éliminer la faille XSS
function sanitize_html($string) {
	// https://www.php.net/manual/fr/function.htmlspecialchars.php
	return htmlspecialchars(trim($string));
}

// pour ne mettre que la première lettre en majuscule
function mb_ucfirst($string) {
	// je mets la chaine de caractère en minuscule
	$string = mb_strtolower(trim($string));
	// je récupère la première lettre de la chaîne
    $firstChar = mb_substr($string, 0, 1);
    // je récupère le reste de la chaîne (sans le premier caractère)
    $then = mb_substr($string, 1);
    return mb_strtoupper($firstChar) . $then;
}

// function pour checker le password
function check_password($pass) {
	preg_match('#^(?=(.*[A-Z])+)(?=(.*[a-z])+)(?=(.*[\d])+)(?=.*\W)(?!.*\s).{8,16}$#', $pass, $match);
	if(empty($match)) {
		return FALSE;
	}
	return TRUE;
}

// pour mettre au pluriel
function plural($count) {
	return $count > 1 ? 's' : '';
}

