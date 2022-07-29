<?php
session_start();

define('HOME_URL', 'http://buffyproject/');
define('PATH_PROJECT', __DIR__);
define('META_DEFAULT', 'When writing a meta description, keep it between 140 and 160 characters so Google can display your entire message. Don’t forget to include your keyword!');


//define URL of site.
//define('URL_HOME','views/home.php');
//define('URL_SUBSCRIBE','views/subscribe.php');
//define('URL_USER_PROFIL','views/user_profil.php');
//define('URL_USER_UPDATE','views/user_update.php');
//define('URL_BLOG','views/blog.php');
//define('URL_ADD_ARTICLE','views/add_article.php');
//define('URL_UPDATE_ARTICLE','views/update_article.php');
//define('URL_DASHBOARD','views/dashboard.php');
//define('URL_DASHBOARD_UPDATE','views/dashboard_update.php');
//define('URL_CONTACT','views/contact.php');



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
