<?php

require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';

if(in_array('', $_POST)) :
    $msg_error = "<p id=\"connect_user_falure\" class=\"connect_user_failure\">Merci de remplir tous les champs</p>";
else :

    $email = filter_var(strtolower(trim($_POST['email'])), FILTER_VALIDATE_EMAIL);
    if(!$email) : // Si $email est égale à  FALSE
        $msg_error = "<p id=\"connect_user_falure2\" class=\"connect_user_failure\">Merci de renseigner un email valide</p>";
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
            // Transform an SQL variable into a PHP variable
            'email' => $email
        ));

        $result = $req->fetch(PDO::FETCH_OBJ);

        if(!$result) : // if the result is different then the email is not in the database
            $msg_error = "<p id=\"connect_user_falure3\" class=\"connect_user_failure\">Le mot de passe ou l'identifiant ne sont pas valides</p>";
        else :
//            The trim function removes spaces at the beginning and end of a string.
            $password = trim($_POST['password']);



            if (!password_verify($password, $result->password)) :
                $msg_error = "<p id=\"connect_user_falure4\" class=\"connect_user_failure\">Le mot de passe ou l'identifiant ne sont pas valides</p>";
            else :
                // we called session_start() in functions.php and login_post.php
                $_SESSION['id_user'] 	= $result->id;
                $_SESSION['id_role'] 	= $result->id_role;
                $_SESSION['first_name'] = $result->first_name;
                $_SESSION['last_name'] 	= $result->last_name;
                $_SESSION['email'] 		= $result->email;
                $_SESSION['pseudo'] 	= $result->pseudo;
                $_SESSION['id_image'] 	= $result->id_image;
                $_SESSION['role_name'] 	= $result->role_name;
                $_SESSION['role_slug'] 	= $result->role_slug;

                $msg_success = "<p id=\"connect_user\" class=\"connect_user_success\">Vous êtes bien connecté</p>";
            endif;
        endif;
    endif;
endif;


if(isset($msg_error)) { // isset checks if the variable exists and is not null,
                         //
    //if it is zero an error message is generated or generates a success message if the log went well
    header('Location: ' . HOME_URL . '?msg=' . $msg_error);
}
else {
    header('Location: ' . HOME_URL . '?msg=' . $msg_success);
}