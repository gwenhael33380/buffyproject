<?php

require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
$send_request = false;

$id_role = 3;
$first_name = mb_ucfirst($_POST['first_name']); // seulement la première lettre en majuscule
$last_name = mb_strtoupper(trim($_POST['last_name'])); // tout en majuscule
$pseudo = trim($_POST['pseudo']);
$email = filter_var(mb_strtolower(trim($_POST['email'])), FILTER_VALIDATE_EMAIL);
$picture = $_FILES['picture'];


$required_fields = array($first_name, $last_name, $pseudo, $email);

$error_upload = array(3, 6, 7, 8);
$error_size = array(1, 2);
$enabled_ext = array('jpg', 'jpeg', 'png', 'gif');

$default_img_id = 1;
$size_max = 1048576;

if(in_array('', $required_fields)) :
    $msg_error = 'Merci de remplir le titre et le contenu de l\'article';
    header('Location:' . HOME_URL . 'views/dashboard_update_post.php?id=' . $id . '&msg=' . $msg_error);
else :

    $picture 	= $_FILES['picture'];
    $error 		= $picture['error'];
    $curr_img 	= $_POST['current_img'];

    if(in_array($error, $error_upload)) :
        $msg_error = 'Échec au moment de la transmission de l\'image, merci de renouveler votre envoi';
    elseif(in_array($error, $error_size)) :
        $msg_error = 'La taille de votre fichier ne doit pas dépasser 1 Mo';
    else :
        // reste error 0 et 4
        if($error == 4) :
            $img_name = empty($curr_img) ? $default_img_id: $curr_img;
            $set_request = TRUE;
        else : // si error === 0
            $recept_img = $picture['name'];
            $image_size = $picture['size'];
            $tmp_name 	= $picture['tmp_name'];
            // https://www.php.net/manual/fr/function.pathinfo.php
            $ext_img = strtolower(pathinfo($recept_img, PATHINFO_EXTENSION));

            // on vérifie si l'extension est bien dans le tableau, sinon ce n'est pas une image
            if(!in_array($ext_img, $enabled_ext)) :
                $msg_error = 'Votre fichier n\'est pas une image png, jpg, jpeg ou gif';
            elseif($image_size > $size_max) :
                $msg_error = 'La taille de votre fichier ne doit pas dépasser 1 Mo';
            else :
                // on créé un nom de fichier unique et aléatoire pour éviter les doublons dans le FTP (sur le serveur dans le dossier assets/img)

                // https://www.php.net/manual/fr/function.uniqid.php
                $img_name = uniqid() . '_' . $recept_img;

                // facultatif :
                // on crée le dossier img s'il n'existe pas
                // https://www.php.net/manual/fr/function.mkdir.php
                // https://www.php.net/manual/fr/function.chmod.php

                // le @ n'affichera pas l'erreur (notice ou warning) si la fonction en retourne une
                @mkdir(PATH_PROJECT . '/assets/img/src/profil/', 0755);

                // je crée une variable pour spécifier l'endroit où je vais stocker mon image
                $img_folder = PATH_PROJECT . '/assets/img/src/profil/';
                // var_dump($img_folder);
                $dir = $img_folder . $img_name;
                // var_dump($dir);

                // https://www.php.net/manual/fr/function.move-uploaded-file.php
                $move_file = move_uploaded_file($tmp_name, $dir);

                if($move_file) :
                    if($curr_img != $default_img_id)
                        // https://www.php.net/manual/fr/function.unlink.php
                        unlink($img_folder . $curr_img);

                    $set_request = TRUE;
                else :
                    $set_request = FALSE;
                endif;

            endif;


        endif;

        if($set_request) :
            $req = $db->prepare("
					UPDATE users SET id_role = :id_role, first_name = :first_name, last_name = :last_name, pseudo = :pseudo, email = :email, id_image = :id_image
					WHERE id = :id; -- condition pour ne mettre à jour que l'id de l'article, pas les autre
			        UPDATE images SET file_name = :file_name
                    WHERE ic = :id
				");
            // var_dump($db->errorInfo());

            $req->bindValue(':id_role', $id_role, PDO::PARAM_INT);
            $req->bindValue(':first_name', $first_name, PDO::PARAM_STR);
            $req->bindValue(':last_name', $last_name, PDO::PARAM_STR);
            $req->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
            $req->bindValue(':email', $email, PDO::PARAM_STR);
            $req->bindValue(':id_image', $id_image, PDO::PARAM_STR);
            $req->bindValue(':file_name', $file_name, PDO::PARAM_STR);

            // $result va stocker le résultat de ma requete UPDATE
            // si TRUE l'insertion s'est bien déroulé
            // si FALSE une erreur s'est produite
            $result = $req->execute();
            if($result) :
                $msg_success = 'Article correctement mis à jour';
            else:
                $msg_error = 'Erreur lors de la soumission du formulaire, merci de retenter dans quelques instants';
            endif;

        else :
            $msg_error = 'Erreur lors du transfert, merci de retenter dans quelques instants';
        endif;

    endif;


endif;

    if (isset($msg_error)) {
        header('Location:' . HOME_URL . 'views/dashboard_update?msg_error=' . $msg_error);
    } else {
        header('Location:' . HOME_URL . '?msg=' . $msg_success);
    }


//Lecorre@!33