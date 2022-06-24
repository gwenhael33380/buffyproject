<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';




$fail_upload 		= array(3,6,7,8);
$oversize_file 		= array(1,2);
$default_picture 	= 'no-image.jpg';
$extension 			= array('png', 'jpg', 'jpeg', 'gif');
$size_max 			= 1048576;

if(in_array('', $_POST)) :
    $msg_error = 'Merci de remplir le titre et le contenu de l\'article';
// header('Location:' . HOME_URL . 'views/add_article.php?msg=' . $msg_error);
else :

    $title 		= trim($_POST['title']);
    $text 		= trim($_POST['text']);
    $picture 	= $_FILES['images'];
    $error 		= $picture['error'];
    $alt        = trim($_POST['alt']);


    if(in_array($error, $fail_upload)) :
        $msg_error = 'Échec au moment de la transmission de l\'image, merci de renouveler votre envoi';
    elseif(in_array($error, $oversize_file)) :
        $msg_error = 'La taille de votre fichier ne doit pas dépasser 1 Mo';
    else :
        // il me reste donc que 0 ou 4 comme "error"
        if($error == 4) :
            $img_name = $default_picture;
            $set_request = TRUE;
        else :
            $recept_img = $picture['name'];
            $image_size = $picture['size'];
            $tmp_name 	= $picture['tmp_name'];
            // https://www.php.net/manual/fr/function.pathinfo.php
            $ext_img = strtolower(pathinfo($recept_img, PATHINFO_EXTENSION));

            // on vérifie si l'extension est bien dans le tableau, sinon ce n'est pas une image
            if(!in_array($ext_img, $extension)) :
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
                @mkdir(PATH_PROJECT . '/assets/img/src/articles/', 0755);

                // je crée une variable pour spécifier l'endroit où je vais stocker mon image
                $img_folder = PATH_PROJECT . '/assets/img/src/articles/';
                // var_dump($img_folder);
                $dir = $img_folder . $img_name;
                // var_dump($dir);

                // https://www.php.net/manual/fr/function.move-uploaded-file.php
                $move_file = move_uploaded_file($tmp_name, $dir);

                if($move_file) :
                    $set_request = TRUE;
                else :
                    $set_request = FALSE;
                endif;

            endif;


        endif;

        if($set_request) :
            $req = $db->prepare("
				  INSERT INTO images(file_name, alt)
                VALUE   (:file_name, :alt);

                INSERT INTO articles(id_user, title, content, id_image, created_at)
				VALUES (:id_user, :title, :content,LAST_INSERT_ID(), NOW())
              
			");

            // https://www.php.net/manual/fr/function.intval.php
            $req->bindValue(':id_user', intval($_SESSION['id_user']), PDO::PARAM_INT); // integer
            $req->bindValue(':title', $title, PDO::PARAM_STR); // string
            $req->bindValue(':content', $text, PDO::PARAM_STR); // string
            $req->bindValue(':file_name', $img_name, PDO::PARAM_STR); // string

            $req->bindValue(':alt', $alt, PDO::PARAM_STR); // string

            // $result va stocker le résultat de ma requete INSERT INTO
            // si TRUE l'insertion s'est bien déroulé
            // si FALSE une erreur s'est produite
            $result = $req->execute();

            if($result) :
                $msg_success = 'Article correctement créé';
            else:
                $msg_error = 'Erreur lors de la soumission du formulaire, merci de retenter dans quelques instants';
            endif;

        else :
            $msg_error = 'Erreur lors du transfert, merci de retenter dans quelques instants';
        endif;

    endif;


endif;

if(isset($msg_error)) {
    header('Location:' . HOME_URL . 'views/add_article.php?msg=' . $msg_error . '&title=' . $title . '&content=' . $text);
}
else {
    header('Location:' . HOME_URL . '?msg=<div class="green">' . $msg_success . '</div>');
}