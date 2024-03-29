<?php

require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';

//increment the number of visits
add_views();

//checks the data entered by the user and checks if he meets the connection conditions
if(in_array('', $_POST)) :
    $msg_error = "<p class=\"msg_error\">Merci de remplir tous les champs</p>";
else :

                                                        //email verification feature
    $email = filter_var(strtolower(trim($_POST['email'])), FILTER_VALIDATE_EMAIL);
    if(!$email) : //if $email is FALSE
        $msg_error = "<p class=\"msg_error\">Merci de renseigner un email valide</p>";
    else :
        $req = $db->prepare("
			SELECT u.*, r.role_name, r.role_slug, p.file_name
			FROM user u
			LEFT JOIN role r
			ON r.id = u.id_role
			LEFT JOIN picture p
			ON p.id = u.id_image
			WHERE u.email = :email 
		");
        $req->execute(array(
            // Transform an SQL variable into a PHP variable
            'email' => $email
        ));

        $result = $req->fetch(PDO::FETCH_OBJ);

        if(!$result) : // if the result is different then the email is not in the database
            $msg_error = "<p class=\"msg_error\">Le mot de passe ou l'identifiant ne sont pas valides</p>";
        else :
//            The trim function removes spaces at the beginning and end of a string.
            $password = trim($_POST['password']);



            if (!password_verify($password, $result->password)) :
                $msg_error = "<p class=\"msg_error\">Le mot de passe ou l'identifiant ne sont pas valides</p>";
            else :
                // now, we create the session from the information retrieved from the database
                $_SESSION['id_user'] 	= $result->id;
                $_SESSION['id_role'] 	= $result->id_role;
                $_SESSION['first_name'] = $result->first_name;
                $_SESSION['last_name'] 	= $result->last_name;
                $_SESSION['email'] 		= $result->email;
                $_SESSION['pseudo'] 	= $result->pseudo;
                $_SESSION['id_image'] 	= $result->id_image;
                $_SESSION['role_name'] 	= $result->role_name;
                $_SESSION['role_slug'] 	= $result->role_slug;

                $msg_success = "<p class=\"msg_success\">Vous êtes bien connecté</p>";
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