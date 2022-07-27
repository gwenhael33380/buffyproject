<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
$send_request = false;

$id_role = 3; // il est fixe, le role en "dur"
$first_name = mb_ucfirst($_POST['first_name']); // seulement la première lettre en majuscule
$last_name 	= mb_strtoupper(trim($_POST['last_name'])); // tout en majuscule
$pseudo 	= trim($_POST['pseudo']);
$email 		= filter_var(mb_strtolower(trim($_POST['email'])), FILTER_VALIDATE_EMAIL);
$picture    = $_FILES['picture'];

$required_fields = array($first_name, $last_name, $pseudo, $email);

$error_upload 	= array(3,6,7,8);
$error_size 	= array(1,2);
$enabled_ext 	= array('jpg', 'jpeg', 'png', 'gif');

$default_img_id = 1;
$size_max 		= 1048576;


$pass1 		= trim($_POST['password']);
$pass2 		= trim($_POST['password2']);
$match_pass = check_password($pass1); // je check pour voir s'il correspond au pat tern



if(in_array('', $required_fields)) :
    $msg_error = '<p class="msg_error">Vous devez remplir le(s) champ(s) obligatoire(s)</p>';
    $empty_field = TRUE;
else :

    if($pass1 != $pass2) :
        $msg_error = '<p class="msg_error">Les mots de passe ne correspondent pas</p>';
    elseif(!$match_pass) :
        $msg_error = '<p class="msg_error">Le mot de passe ne correspond pas au format exigé</p>';
    else :
        // on vérifie que le pseudo n'existe pas dans la BDD
        $req = $db->prepare("
			SELECT COUNT(id) count_pseudo
			-- je compte le nombre de pseudo identique
			FROM users
			WHERE pseudo = :pseudo
		");

        $req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);

        $req->execute();
        $result = $req->fetch(PDO::FETCH_OBJ);

        if($result->count_pseudo) :
            $msg_error = '<p>Ce pseudo existe déjà</p>';
        else :
            $req = $db->prepare("
				SELECT COUNT(id) count_email
				FROM users
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
            // https://www.php.net/manual/fr/function.pathinfo.php
            $ext_img = strtolower(pathinfo($recept_img, PATHINFO_EXTENSION));

            // on vérifie si l'extension est bien dans le tableau, sinon ce n'est pas une image
            if(!in_array($ext_img, $enabled_ext)) :
                $msg_error = '<p class="msg_error">Votre fichier n\'est pas une image png, jpg ou jpeg</p>';
            elseif($image_size > $size_max) :
                $msg_error = '<p class="msg_error">Fichier trop volumineux, ne pas dépasser 1Mo</p>';
            else :



                $img_name = uniqid() . '_' . $recept_img;




                @mkdir(PATH_PROJECT . '/assets/img/src/profil/', 0755);

                // je crée une variable de stockage de l'image
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
                        INSERT INTO images(file_name)
                        VALUES (:file_name);
                        INSERT INTO users(id_role, first_name, last_name, pseudo, email, password, id_image)
                        VALUES (:id_role, :first_name, :last_name, :pseudo, :email, :password, LAST_INSERT_ID())
                    ");
            else :
                $req = $db->prepare("
                           
                            INSERT INTO users(id_role, first_name, last_name, pseudo, email, password, id_image)
                            VALUES (:id_role, :first_name, :last_name, :pseudo, :email, :password, :id_image)
                            ");
            endif;


            $req->bindValue(':id_role', $id_role, PDO::PARAM_INT);
            $req->bindValue(':first_name', $first_name, PDO::PARAM_STR);
            $req->bindValue(':last_name', $last_name, PDO::PARAM_STR);
            $req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
            $req->bindValue(':email', $email, PDO::PARAM_STR);
            // https://www.php.net/manual/fr/function.password-hash.php
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
                $msg_error = '<p class="msg_error">Oups !! erreur lors de la création du profil</p>';
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

//Lecorre@!33