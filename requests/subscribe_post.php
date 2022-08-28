<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';

    // sanitize_html() return htmlspecialchars(trim($var))
    $send_request = false;
    $id_role = 3; // it is fixed, the role "hard"
    $first_name = mb_ucfirst(sanitize_html($_POST['first_name'])); // capitalize only the first letter
    $last_name 	= mb_strtoupper(sanitize_html($_POST['last_name'])); // all caps
    $pseudo 	= sanitize_html($_POST['pseudo']); //user's nickname
    $email 		= filter_var(mb_strtolower(trim($_POST['email'])), FILTER_VALIDATE_EMAIL); // email
    $picture    = $_FILES['picture'];
    $checkbox   = $_POST['checkbox']; // test checkbox legal notice
    $required_fields = array($first_name, $last_name, $pseudo, $email); // required fields

    $error_upload 	= array(3,6,7,8); // error of upload
    $error_size 	= array(1,2); //size error
    $enabled_ext 	= array('jpg', 'jpeg', 'png', 'gif'); // limits data access to targeted extensions

    $default_img_id = 1; // default picture id
    $size_max 		= 1048576; //maximum image size


    $pass1 		= trim($_POST['password']); // password 1
    $pass2 		= trim($_POST['password2']); // password 2
    $match_pass = check_password($pass1); // the checkpassword() function checks if the passwords to the password

    if(in_array('', $required_fields)) :
        $msg_error = '<p class="msg_error">Vous devez remplir le(s) champ(s) obligatoire(s)</p>';
        $empty_field = TRUE;
    else :
        // strlen() test the number of characters in the variable and limit of characters
        if (strlen($first_name) <3 || strlen($first_name) >40):
            $msg_error = '<p class="msg_error">Merci de remplir le contenu du prénom avec le bon nombres de caractères</p>';
        else :
            if(strlen($last_name) <3 || strlen($last_name) >40) :
                $msg_error = '<p class="msg_error">Merci de remplir le contenu du nom avec le bon nombres de caractères</p>';
            else :
                if (strlen($pseudo) <3 || strlen($pseudo) >40):
                    $msg_error = '<p class="msg_error">Merci de remplir le contenu du pseudo avec le bon nombres de caractères</p>';
                endif;
            endif;
        endif;
        if (!$checkbox):
            $msg_error = '<p class="msg_error">Veuillez accepté les mentions légal du site</p>';
        else:
            if($pass1 != $pass2) :
                $msg_error = '<p class="msg_error">Les mots de passe ne correspondent pas</p>';
            elseif(!$match_pass) :
                $msg_error = '<p class="msg_error">Le mot de passe ne correspond pas au format exigé</p>';
            else :
                // on vérifie que le pseudo n'existe pas dans la BDD
                $req = $db->prepare("
			SELECT COUNT(id) count_pseudo
			-- je compte le nombre de pseudo identique
			FROM user
			WHERE pseudo = :pseudo
		");

                $req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);

                $req->execute();
                $result = $req->fetch(PDO::FETCH_OBJ);

                if($result->count_pseudo) :
                    $msg_error = '<p class="msg_error">Ce pseudo existe déjà</p>';
                else :
                    $req = $db->prepare("
				SELECT COUNT(id) count_email
				FROM user
				WHERE email = :email
			");

                    $req->bindValue(':email', $email, PDO::PARAM_STR);

                    $req->execute();

                    $result = $req->fetch(PDO::FETCH_OBJ);

                    if($result->count_email) : // si > 0
                        $msg_error = '<p class="msg_error">Ce compte existe deja avec cet adresse email</p>';
                    endif;
                endif;
            endif;
        endif;

        if(!isset($msg_error)) :
            $error = $picture['error'];
            if(in_array($error, $error_upload)) :
                $msg_error = '<p class="msg_error">Erreur au moment de l\'envoi</p>';
            elseif(in_array($error, $error_size)) :
                $msg_error = '<p class="msg_error">Fichier trop volumineux, ne pas dépasser 1Mo</p>';
            elseif($error == 4) :
                $send_request = TRUE;
                $img_name = FALSE;
            else :
                $recept_img = $picture['name'];
                $image_size = $picture['size'];
                $tmp_name 	= $picture['tmp_name'];
                // Returns information about a system path
                $ext_img = strtolower(pathinfo($recept_img, PATHINFO_EXTENSION));

                //we check if the extension is in the table, otherwise it is not an image
                if(!in_array($ext_img, $enabled_ext)) :
                    $msg_error = '<p class="msg_error">Votre fichier n\'est pas une image png, jpg ou jpeg</p>';
                elseif($image_size > $size_max) :
                    $msg_error = '<p class="msg_error">Fichier trop volumineux, ne pas dépasser 1Mo</p>';
                else :

                    $img_name = uniqid() . '_' . $recept_img;

                    @mkdir(PATH_PROJECT . '/assets/img/src/profil/', 0755);

                    // I create an image storage variable
                    $img_folder = PATH_PROJECT . '/assets/img/src/profil/';
                    $dir = $img_folder . $img_name;
                    $move_file = move_uploaded_file($tmp_name, $dir);

                    if($move_file) :
                        $send_request = TRUE;
                    else :
                        $send_request = FALSE;
                    endif;
                endif;
            endif;

            if($send_request) :
                if($img_name) :
                    $req = $db->prepare("
                        INSERT INTO picture(file_name)
                        VALUES (:file_name);
                        INSERT INTO user(id_role, first_name, last_name, pseudo, email, password, id_image)
                        VALUES (:id_role, :first_name, :last_name, :pseudo, :email, :password, LAST_INSERT_ID())
                    ");
                else :
                    $req = $db->prepare("
                           
                            INSERT INTO user(id_role, first_name, last_name, pseudo, email, password, id_image)
                            VALUES (:id_role, :first_name, :last_name, :pseudo, :email, :password, :id_image)
                            ");
                endif;


                $req->bindValue(':id_role', $id_role, PDO::PARAM_INT);
                $req->bindValue(':first_name', $first_name, PDO::PARAM_STR);
                $req->bindValue(':last_name', $last_name, PDO::PARAM_STR);
                $req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
                $req->bindValue(':email', $email, PDO::PARAM_STR);
                // bind and hash password
                $req->bindValue(':password', password_hash($pass1, PASSWORD_DEFAULT), PDO::PARAM_STR);
                if($img_name) :
                    $req->bindValue(':file_name', $img_name, PDO::PARAM_STR); // string
                else :
                    $req->bindValue(':id_image', $default_img_id, PDO::PARAM_INT); // string
                endif;

                $result = $req->execute();

                if($result) :
                    $msg_success = '<p class="msg_success">Vous êtes bien inscrit</p>';
                else :
                    $msg_error = '<p class="msg_error">une erreur est survenu lors de la création de votre profil</p>';
                endif;
            endif;
        endif;
endif;
if(isset($msg_error)) {
    header('Location:' . HOME_URL . 'views/subscribe.php?msg=' . $msg_error);
}
else {
    header('Location:' . HOME_URL . '?msg=' . $msg_success);
}

