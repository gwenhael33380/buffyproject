<?php
require dirname(__DIR__) . '/functions.php';
enabled_access(array('administrator'));
require_once PATH_PROJECT . '/connect.php';

$send_request = false;
$initial_img = $_POST['initial_image'];

// a traiter dans le user update
$initial_pseudo = $_POST['initial_pseudo'];
$initial_email = $_POST['initial_email'];

$id_image    = intval($_POST['id_image']);
$first_name  = mb_ucfirst($_POST['first_name']); // seulement la première lettre en majuscule
$last_name   = mb_strtoupper(trim($_POST['last_name'])); // tout en majuscule
$pseudo      = trim($_POST['pseudo']);
$email       = filter_var(mb_strtolower(trim($_POST['email'])), FILTER_VALIDATE_EMAIL);
$picture     = $_FILES['picture'];
$id_role     = intval($_POST['role']);
$id_user     = intval($_POST['id_user']);

$required_fields = array($first_name, $last_name, $pseudo, $email, $id_role);
$error_upload     = array(3, 6, 7, 8);
$error_size     = array(1, 2);
$enabled_ext     = array('jpg', 'jpeg', 'png', 'gif');

$default_img_id = 1;

$size_max         = 1048576;

// same = identique
$same_pseudo = $pseudo == $initial_pseudo ? true : false;
$same_email = $email == $initial_email ? true : false;


if ($picture['name'] == ''){
    $same_picture = true;

}else{
    $same_picture = false;
}
//var_dump($same_picture);die;

$pass1         = trim($_POST['password']);
$pass2         = trim($_POST['password2']);
$empty_pass = empty($pass1) && empty($pass2) ? true : false;
$match_pass = check_password($pass1); // je check pour voir s'il correspond au pat tern




if (in_array('', $required_fields)) :
    $msg_error = '<p class="msg_error">Merci de remplir le(s) champ(s) obligatoire(s)</p>';
    $empty_field = TRUE;
else :

    if ($pass1 != $pass2 && !$empty_pass) :
        $msg_error = '<p class="msg_error">Les mots de passe ne correspondent pas</p>';
    elseif (!$match_pass && !$empty_pass) :
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

        if ($result->count_pseudo && !$same_pseudo) : // si > 0
            $msg_error = '<p class="msg_error">Ce pseudo existe déjà</p>';

        elseif (!$same_email) :
            $req = $db->prepare("
				SELECT COUNT(id) count_email
				FROM user
				WHERE email = :email
			");

            $req->bindValue(':email', $email, PDO::PARAM_STR);

            $req->execute();

            $result = $req->fetch(PDO::FETCH_OBJ);

            if ($result->count_email && !$same_email) : // si > 0
                $msg_error = '<p class="msg_error">Vous avez déjà un compte avec cet email</p>';
            endif;
        endif;
    endif;

    if (!isset($msg_error)) :
        $error = $picture['error'];
        if (in_array($error, $error_upload)) :
            $msg_error = '<p class="msg_error">Erreur au moment de l\'envoi</p>';
        elseif (in_array($error, $error_size)) :
            $msg_error = '<p class="msg_error">Fichier trop volumineux, ne pas dépasser 1Mo</p>';
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
                $msg_error = '<p class="msg_error">Le fichier n\'est pas une image png, jpg ou jpeg</p>';
            elseif ($image_size > $size_max) :
                $msg_error = '<p class="msg_error">Fichier trop volumineux, ne pas dépasser 1Mo</p>';
            else :

                //Creation of a unique and random file name to avoid duplicates in the FTP (on the server in the assets/img folder)
                $img_name = uniqid() . '_' . $recept_img;


//                create the folder if it does not exist
                @mkdir(PATH_PROJECT . '/assets/img/dist/profil/', 0755);

                // initializing a variable to specify where I will store my image
                $img_folder = PATH_PROJECT . '/assets/img/dist/profil/';
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
                    $request =  "UPDATE user SET id_role = :id_role, first_name = :first_name, last_name = :last_name WHERE id = :id_user";

                elseif ($same_email && !$same_pseudo) :
                    $request =  "UPDATE user SET id_role = :id_role, first_name = :first_name, last_name = :last_name, pseudo = :pseudo WHERE id = :id_user";

                elseif (!$same_email && $same_pseudo) :
                    $request =  "UPDATE user SET id_role = :id_role, first_name = :first_name, last_name = :last_name, email = :email WHERE id = :id_user";

                elseif (!$same_email && !$same_pseudo) :
                    $request =  "UPDATE user SET id_role = :id_role, first_name = :first_name, last_name = :last_name, pseudo = :pseudo, email = :email WHERE id = :id_user";
                endif;
            else :
                if ($same_email && $same_pseudo) :
                    $request =  "UPDATE user SET id_role = :id_role, first_name = :first_name, last_name = :last_name, password = :password WHERE id = :id_user";

                elseif ($same_email && !$same_pseudo) :
                    $request =  "UPDATE user SET id_role = :id_role, first_name = :first_name, last_name = :last_name, pseudo = :pseudo, password = :password WHERE id = :id_user";

                elseif (!$same_email && $same_pseudo) :
                    $request =  "UPDATE user SET id_role = :id_role, first_name = :first_name, last_name = :last_name, email = :email, password = :password WHERE id = :id_user";

                elseif (!$same_email && !$same_pseudo) :
                    $request =  "UPDATE user SET id_role = :id_role, first_name = :first_name, last_name = :last_name, pseudo = :pseudo, email = :email, password = :password WHERE id = :id_user";
                endif;
            endif;

            if ($same_picture) {
                $req = $db->prepare("
                        $request;                    
                    ");

                $req->bindValue(':id_role', $id_role, PDO::PARAM_INT);
                $req->bindValue(':first_name', $first_name, PDO::PARAM_STR);
                $req->bindValue(':last_name', $last_name, PDO::PARAM_STR);


                if (!$same_pseudo) {
                    $req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
                }
                if (!$same_email) {
                    $req->bindValue(':email', $email, PDO::PARAM_STR);
                }
                if (!$empty_pass){
                    $req->bindValue(':password', password_hash($pass1, PASSWORD_DEFAULT), PDO::PARAM_STR);
                }
                $req->bindValue(':id_user', $id_user, PDO::PARAM_INT);

                $req = $req->execute();

            } else {

                $sql2 = "INSERT INTO picture (file_name) VALUES (:file_name); ";
                $req2 = $db->prepare($sql2);


                $req2->bindValue(':file_name', $img_name, PDO::PARAM_STR);
                $res2 = $req2->execute();


                $sql3 = "UPDATE user SET id_image = :image WHERE id = :id_user;";
                $req = $db->prepare("$sql3  $request;");
                $image = $db->query('SELECT id FROM picture WHERE id = LAST_INSERT_ID()')->fetch();

                $req->bindValue(':id_role', $id_role, PDO::PARAM_INT);
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
                    $req->bindValue(':password', password_hash($pass1, PASSWORD_DEFAULT), PDO::PARAM_STR);
                endif;
                $req->bindValue(':id_user', $id_user, PDO::PARAM_INT);
                $req->bindValue(':image', $image['id'], PDO::PARAM_INT);
                $result = $req->execute();

            }


            if ($result) :
                $msg_success = '<p class="msg_success">Le profil a bien ete mis à jours</p>';
            else :
                $msg_error = '<p class="msg_error">erreur lors de la mise à jour du profil!</p>';
            endif;
        endif;
    endif;
endif;

if (isset($msg_error)) {
    header('Location:' . HOME_URL . 'views/dashboard.php' .'?msg=' . $msg_error);
} else {
    header('Location:' . HOME_URL . 'views/dashboard.php' . '?msg=' . $msg_success);
}
//Hdfkoqsf@!lf52
//$2y$10$z4K3YxHwANpjYcl3cOnrauzhEDCNCb/3rcMvJr1ZC25RfftErkkVC
//$2y$10$z4K3YxHwANpjYcl3cOnrauzhEDCNCb/3rcMvJr1ZC25RfftErkkVC
//Lecorre@!33