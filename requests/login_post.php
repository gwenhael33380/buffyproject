<?php

require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';

if(in_array('', $_POST)) : // if(empty($_POST['email']) || empty($_POST['password']))
    $msg_error = "<div class=\"red\">Merci de remplir tous les champs</div>";
else :
    // https://www.php.net/manual/fr/function.filter-var.php
    // filter_var avec son filter "FILTER_VALIDATE_EMAIL" va vérifier qu'il s'agit bien d'un email
    // strtolower string to lowercase => va remettre la chaine en minuscule
    // trim va éliminer les espaces en début et fin de chaine
    $email = filter_var(strtolower(trim($_POST['email'])), FILTER_VALIDATE_EMAIL);
    if(!$email) : // $email === FALSE
        $msg_error = "<div class=\"red\">Merci de renseigner un email valide</div>";
    else :
        $req = $db->prepare("
			SELECT u.*, r.role_name, r.role_slug, i.file_name
			FROM users u
			LEFT JOIN roles r
			ON r.id = u.id_role
			LEFT JOIN images i
			ON i.id = u.id_image
			WHERE u.email = :email -- ici je crée une variable SQL avec les :
		");
        $req->execute(array(
            // variable SQL => variable PHP
            'email' => $email
        ));
        // un seul fetch suffit car je n'attends qu'un seul résultat
        $result = $req->fetch(PDO::FETCH_OBJ);

        if(!$result) : // donc l'email n'est pas dans la BDD
            $msg_error = "<div class=\"red\">Le mot de passe ou l'identifiant ne sont pas valides</div>";
        else :
            $password = trim($_POST['password']);
            // https://www.php.net/manual/fr/function.password-verify.php

            // attention cette fonction n'est utilisable que si le password a été hashé avec password_hash
            // var_dump(password_hash($password, PASSWORD_DEFAULT));

            // https://www.php.net/manual/fr/function.password-hash.php
            if (!password_verify($password, $result->password)) :
                $msg_error = "<div class=\"red\">Le mot de passe ou l'identifiant ne sont pas valides</div>";
            else :
                // on a appelé le session_start() dans le functions.php et login_post.php inclus bien ce fichier
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
if(isset($msg_error)) { // isset vérifie si la variable existe et qu'elle n'est pas nulle
    header('Location: ' . HOME_URL . '?msg=' . $msg_error);
}
else {
    header('Location: ' . HOME_URL . '?msg=' . $msg_success);
}