<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';


$send_request = false;
$initial_img = $_POST['initial_image'];

// a traiter dans le user update
$initial_pseudo = $_POST['initial_pseudo'];
$initial_email = $_POST['initial_email'];

$id_image = intval($_POST['id_image']);
$first_name = mb_ucfirst($_POST['first_name']); // seulement la première lettre en majuscule
$last_name     = mb_strtoupper(trim($_POST['last_name'])); // tout en majuscule
$pseudo     = trim($_POST['pseudo']);
$email         = filter_var(mb_strtolower(trim($_POST['email'])), FILTER_VALIDATE_EMAIL);
$picture    = $_FILES['picture'];

if ($_SESSION['role_slug'] == 'administrator') {
    $id_user = intval($_POST['id_user']);
} else {
    $id_user = intval($_SESSION['id_user']);
}
$required_fields = array($first_name, $last_name, $pseudo, $email);
$error_upload     = array(3, 6, 7, 8);
$error_size     = array(1, 2);
$enabled_ext     = array('jpg', 'jpeg', 'png', 'gif');

$default_img_id = 1;

$size_max         = 1048576;
// same = identique
$same_pseudo = $pseudo == $initial_pseudo ? true : false;
$same_email = $email == $initial_email ? true : false;

if (empty($picture)){
    $same_picture = true;

}else{
    $same_picture = false;
}
$same_picture = $picture == $id_image ? true : false; // on verifie si l'image est identique à l'initial alors ? c'est vrai sinon : c'est faux
$pass1         = trim($_POST['password']);
$pass2         = trim($_POST['password2']);
$empty_pass = empty($pass1) && empty($pass2) ? true : false;
$match_pass = check_password($pass1); // je check pour voir s'il correspond au pat tern


var_dump($_POST);die;

if (in_array('', $required_fields)) :
    $msg_error = '<div class="red">Vous devez remplir le(s) champ(s) obligatoire(s)</div>';
    $empty_field = TRUE;
else :

    if ($pass1 != $pass2 && !$empty_pass) :
        $msg_error = 'Les mots de passe ne correspondent pas';
    elseif (!$match_pass && !$empty_pass) :
        $msg_error = 'Le mot de passe ne correspond pas au format exigé';
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

        if ($result->count_pseudo && !$same_pseudo) : // si > 0
            $msg_error = 'Ce pseudo existe déjà';
        elseif (!$same_email) :
            $req = $db->prepare("
				SELECT COUNT(id) count_email
				FROM users
				WHERE email = :email
			");

            $req->bindValue(':email', $email, PDO::PARAM_STR);

            $req->execute();

            $result = $req->fetch(PDO::FETCH_OBJ);

            if ($result->count_email && !$same_email) : // si > 0
                $msg_error = 'Vous avez déjà un compte avec cet email';
            endif;
        endif;
    endif;

    if (!isset($msg_error)) :
        $error = $picture['error'];
        if (in_array($error, $error_upload)) :
            $msg_error = '<div class="red">Erreur au moment de l\'envoi</div>';
        elseif (in_array($error, $error_size)) :
            $msg_error = '<div class="red">Fichier trop volumineux, ne pas dépasser 1Mo</div>';
        elseif ($error == 4) :

            $send_request = TRUE;
            $img_name = $initial_img;

        else :
            $recept_img = $picture['name'];
            $image_size = $picture['size'];
            $tmp_name     = $picture['tmp_name'];
            // https://www.php.net/manual/fr/function.pathinfo.php
            $ext_img = strtolower(pathinfo($recept_img, PATHINFO_EXTENSION));

            // on vérifie si l'extension est bien dans le tableau, sinon ce n'est pas une image
            if (!in_array($ext_img, $enabled_ext)) :
                $msg_error = '<div class="red">Votre fichier n\'est pas une image png, jpg ou jpeg</div>';
            elseif ($image_size > $size_max) :
                $msg_error = '<div class="red">Fichier trop volumineux, ne pas dépasser 1Mo</div>';
            else :
                // Création d'un nom de fichier unique et aléatoire pour éviter les doublons dans le FTP (sur le serveur dans le dossier assets/img)


                $img_name = uniqid() . '_' . $recept_img;


                @mkdir(PATH_PROJECT . '/assets/img/src/profil/', 0755);

                // initializing a variable to specify where I will store my image
                $img_folder = PATH_PROJECT . '/assets/img/src/profil/';
                $dir = $img_folder . $img_name;


                $move_file = move_uploaded_file($tmp_name, $dir);

                if ($move_file) :
                    $send_request = TRUE;
                else :
                    $send_request = FALSE;
                endif;
            endif;
        endif;


        if ($send_request) :
            if ($empty_pass) :
                if ($same_email && $same_pseudo) :
                    $request =  "UPDATE users SET first_name = :first_name, last_name = :last_name WHERE id = :id_user";

                elseif ($same_email && !$same_pseudo) :
                    $request =  "UPDATE users SET first_name = :first_name, last_name = :last_name, pseudo = :pseudo WHERE id = :id_user";

                elseif (!$same_email && $same_pseudo) :
                    $request =  "UPDATE users SET first_name = :first_name, last_name = :last_name WHERE id = :id_user";

                elseif (!$same_email && !$same_pseudo) :
                    $request =  "UPDATE users SET first_name = :first_name, last_name = :last_name, pseudo = :pseudo, email = :email WHERE id = :id_user";
                endif;
            else :
                if ($same_email && $same_pseudo) :
                    $request =  "UPDATE users SET first_name = :first_name, last_name = :last_name, password = :password WHERE id = :id_user";

                elseif ($same_email && !$same_pseudo) :
                    $request =  "UPDATE users SET first_name = :first_name, last_name = :last_name, pseudo = :pseudo, password = :password WHERE id = :id_user";

                elseif (!$same_email && $same_pseudo) :
                    $request =  "UPDATE users SET first_name = :first_name, last_name = :last_name, password = :password WHERE id = :id_user";

                elseif (!$same_email && !$same_pseudo) :
                    $request =  "UPDATE users SET first_name = :first_name, last_name = :last_name, pseudo = :pseudo, email = :email, password = :password WHERE id = :id_user";
                endif;
            endif;

            if ($same_picture) {

                $req = $db->prepare("
                        $request;                    
                    ");
                $req->bindValue(':first_name', $first_name, PDO::PARAM_STR);
                $req->bindValue(':last_name', $last_name, PDO::PARAM_STR);
                if (!$same_pseudo) {
                    $req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
                }
                if (!$same_email) {
                    $req->bindValue(':email', $email, PDO::PARAM_STR);
                }

                $req = $req->execute();
            } else {

                $sql2 = "INSERT INTO images (file_name) VALUES (:file_name); ";
                $req2 = $db->prepare($sql2);
                $req2->bindValue(':file_name', $img_name, PDO::PARAM_STR);
                $res2 = $req2->execute();

                $sql3 = "UPDATE users SET id_image = :image WHERE id = :id_user;";
                $req = $db->prepare("$sql3  $request;");
                $image = $db->query('SELECT id FROM images WHERE id = LAST_INSERT_ID()')->fetch();

                $req->bindValue(':first_name', $first_name, PDO::PARAM_STR);
                $req->bindValue(':last_name', $last_name, PDO::PARAM_STR);
                if (!$same_pseudo) {
                    $req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
                }
                if (!$same_email) {
                    $req->bindValue(':email', $email, PDO::PARAM_STR);
                }

                // https://www.php.net/manual/fr/function.password-hash.php
                $req->bindValue(':id_user', $id_user, PDO::PARAM_INT);
                if (!$empty_pass) :
                    $req->bindValue(':pass', password_hash($pass1, PASSWORD_DEFAULT), PDO::PARAM_STR);
                endif;

                $req->bindValue(':id_user', $id_user, PDO::PARAM_INT);
                $req->bindValue(':image', $image['id']);
                $result = $req->execute();
            }


            if ($result) :
                $msg_success = '<p class="red">Votre profil a bien ete mis a jours</p>';
            else :
                $msg_error = '<p class="red">erreur lors de la mise a jour du profil</p>';
            endif;
        endif;
    endif;
endif;

if (isset($msg_error)) {
    header('Location:' . HOME_URL . 'views/user_update.php?id=' . $id_user . '&msg=' . $msg_error);
} else {
    header('Location:' . HOME_URL . 'views/user_update.php?id=' . $id_user . '&msg=' . $msg_success);
}

//Lecorre@!33