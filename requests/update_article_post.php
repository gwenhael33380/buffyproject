<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';

$title 		= trim($_POST['title']);
$text 		= trim($_POST['text']);
$text_2 	= trim($_POST['text2']);
$alt        = trim($_POST['alt']);
$id_image   =intval($_POST['id_image']);


$required_field = array($title, $text,$alt); // champs obligatoires


$id = intval($_POST['id_article']);

$fail_upload 		= array(3,6,7,8);
$oversize_file 		= array(1,2);
$default_picture 	= 'no-image.jpg';
$extension 			= array('png', 'jpg', 'jpeg', 'gif');
$size_max 			= 1048576;

if(in_array('', $required_field)) :
    $msg_error = 'Merci de remplir le titre et le contenu de l\'article';
    header('Location:' . HOME_URL . 'views/update_article.php?id=' . $id . '&msg=' . $msg_error);
else :

    $picture 	= $_FILES['picture'];
    $error 		= $picture['error'];
    $curr_img 	= $_POST['current_img'];

    if(in_array($error, $fail_upload)) :
        $msg_error = 'Échec au moment de la transmission de l\'image, merci de renouveler votre envoi';
    elseif(in_array($error, $oversize_file)) :
        $msg_error = 'La taille de votre fichier ne doit pas dépasser 1 Mo';
    else :
        // reste error 0 et 4
        if($error == 4) :
            $request_image = '';
            $set_request = TRUE;
        else : // si error === 0
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

                //var_dump($img_folder);
                $dir = $img_folder . $img_name;
                var_dump($dir);
                var_dump($curr_img);

                // https://www.php.net/manual/fr/function.move-uploaded-file.php
                $move_file = move_uploaded_file($tmp_name, $dir);
                var_dump($tmp_name);
                if($move_file) :
                    if($curr_img != $default_picture)

                        // https://www.php.net/manual/fr/function.unlink.php
//                        unlink($img_folder . $curr_img);


                    $set_request = TRUE;
                    $request_image =  "UPDATE images SET file_name = :file_name, alt = :alt WHERE id = :id_image";
                else :
                    $set_request = FALSE;
                endif;
            endif;
        endif;
        if($set_request) :
            $req = $db->prepare("
                    
					UPDATE articles SET id_user = :id_user, title = :title, content =:content, content_2 = :content_2, created_at = NOW()
					WHERE id = :id;
                    $request_image
				");


            $req->bindValue(':id', $id, PDO::PARAM_INT);
            $req->bindValue(':id_user', intval($_SESSION['id_user']), PDO::PARAM_INT); // integer
            $req->bindValue(':title', $title, PDO::PARAM_STR);
            $req->bindValue(':content', $text, PDO::PARAM_STR);
            $req->bindValue(':content_2', $text_2, PDO::PARAM_STR);
            if(!empty($request_image)) {
            $req->bindValue(':id_image', $id_image, PDO::PARAM_INT);
            $req->bindValue(':file_name', $img_name, PDO::PARAM_STR);
            $req->bindValue(':alt', $alt, PDO::PARAM_STR);
            }



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

if(isset($msg_error)) {
    header('Location:' . HOME_URL . 'views/update_article.php?id=' . $id . '&msg=' . $msg_error . '&title=' . $title . '&content=' . $text);
}
else {
    header('Location:' . HOME_URL . 'views/blog.php?id='.'?msg=<div class="green">' . $msg_success . '</div>');
}