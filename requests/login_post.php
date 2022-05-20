<?php

require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';

if(in_array('', $_POST)) :
    $msg_error = "<div class=\"red\">Merci de remplir tous les champs</div>";
else :

    $email = filter_var(strtolower(trim($_POST['email'])), FILTER_VALIDATE_EMAIL);
    if(!$email) : // Si $email est égale à  FALSE
        $msg_error = "<div class=\"red\">Merci de renseigner un email valide</div>";
    else :
        $req = $db->prepare("
			SELECT u.*, r.role_name, r.role_slug, i.file_name
			FROM users u
			LEFT JOIN roles r
			ON r.id = u.id_role
			LEFT JOIN images i
			ON i.id = u.id_image
			WHERE u.email = :email 
		");
        $req->execute(array(
            // Transforme une variable SQL en variable PHP
            'email' => $email
        ));

        $result = $req->fetch(PDO::FETCH_OBJ);

        if(!$result) : // si le résultat est différents alorsl'email n'est pas dans la BDD
            $msg_error = "<div class=\"red\">Le mot de passe ou l'identifiant ne sont pas valides</div>";
        else :
//            La fonction trim supprime les espace en début et en fin de chaine de caractères
            $password = trim($_POST['password']);



            if (!password_verify($password, $result->password)) :
                $msg_error = "<div class=\"red\">Le mot de passe ou l'identifiant ne sont pas valides</div>";
            else :
                // on a appelé le session_start() dans le functions.php et login_post.php
                $_SESSION['id_user'] 	= $result->id;
                $_SESSION['id_role'] 	= $result->id_role;
                $_SESSION['first_name'] = $result->first_name;
                $_SESSION['last_name'] 	= $result->last_name;
                $_SESSION['email'] 		= $result->email;
                $_SESSION['pseudo'] 	= $result->pseudo;
                $_SESSION['id_image'] 	= $result->id_image;
                $_SESSION['role_name'] 	= $result->role_name;
                $_SESSION['role_slug'] 	= $result->role_slug;

                $msg_success = "<div class='green'>Vous êtes bien connecté</div>";
            endif;
        endif;
    endif;
endif;

// https://www.php.net/manual/fr/function.isset.php
if(isset($msg_error)) { // isset vérifie si la variable existe et qu'elle n'est pas nulle,
                         // si elle est nulle un message d'erreur est généré ou génère un message de succès en si le log c'est bien passé
    header('Location: ' . HOME_URL . '?msg=' . $msg_error);
}
else {
    header('Location: ' . HOME_URL . '?msg=' . $msg_success);
}