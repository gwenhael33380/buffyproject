<?php
session_start();
$server_name = $_SERVER['SERVER_NAME'];
define('HOME_URL', $server_name == 'buffyproject' ? 'http://buffyproject/' : 'https://dev-events.fr/');
define('PATH_PROJECT', __DIR__);
define('META_DEFAULT', 'When writing a meta description, keep it between 140 and 160 characters so Google can display your entire message. Don’t forget to include your keyword!');



//function vardump die
if (!function_exists('dd')) {
    function dd(...$args)
    {
        echo '<pre>';
        var_dump(...$args);
        echo '</pre>';
        die;
    }
}

// function pour vérifier si l'url courant correspond à celle du lien
function current_url($url) {
    $request_uri = substr($_SERVER['REQUEST_URI'], 1); // pour enlever le slash
    if($request_uri == $url) {
        return TRUE;
    }
    return FALSE;
}

// function to redirect to homePage if $enable_access exists and is not null
function enabled_access(Array $enabled_access) {
		if(
			!isset($_SESSION['id_user'])  // if i am not logged in
			|| // OR
			(
				isset($enable_access)
				&& // ET
				isset($_SESSION['id_user'])
				&&
				// if the role is not in the table
				!in_array($_SESSION['role_slug'], $enable_access)
			)
		) :
			header('Location: ' . HOME_URL);
		endif;
}


//eliminate the XSS flaw
function sanitize_html($string) {

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

//function to check the password
function check_password($pass) {
	preg_match('#^(?=(.*[A-Z])+)(?=(.*[a-z])+)(?=(.*[\d])+)(?=.*\W)(?!.*\s).{8,16}$#', $pass, $match);
	if(empty($match)) {
		return FALSE;
	}
	return TRUE;
}

//plural function
function plural($count) {
	return $count > 1 ? '<span class="plural_function">s</span>' : '';
}

//counter views site
function add_views ()
{
    $file = PATH_PROJECT .'/data/compteur';
    $daily_file = $file . '-' . date('Y-m-d');
    incrementer_compteur($file);
    incrementer_compteur($daily_file);
}

function incrementer_compteur (string $file)
{
    $counter = 1;
    if (file_exists($file)) {
        $counter = (int)file_get_contents($file);
        $counter++;
    }
    file_put_contents($file, $counter);
}

function number_views (): string {
    $file =  PATH_PROJECT  . '/data/compteur';
    return file_get_contents($file);
}
