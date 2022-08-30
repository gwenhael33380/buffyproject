<?php
require dirname(__DIR__) . '/functions.php';
enabled_access(array('administrator', 'editor'));
require_once PATH_PROJECT . '/connect.php';

$title 		= sanitize_html($_POST['title']);
$text 		= sanitize_html($_POST['text']);
$alt        = sanitize_html($_POST['alt']);
$id_image   = intval($_POST['id_image']);

$required_field = array($title, $text,$alt); // champs obligatoires

$id = intval($_POST['id_article']);
$article_id_user = intval($_POST['article_id_user']);
$fail_upload 		= array(3,6,7,8);
$oversize_file 		= array(1,2);
$default_picture 	= 'no-image.jpg';
$extension 			= array('png', 'jpg', 'jpeg', 'gif');
$size_max 			= 1048576;
// restrict access
if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == $article_id_user || $_SESSION['role_slug'] == 'administrator'){


    if(in_array('', $required_field)) :
        $msg_error = '<p class="msg_error">Merci de remplir le titre et le contenu de l\'article ainsi que la description</p>';
        header('Location:' . HOME_URL . 'views/update_article.php?id=' . $id . '&msg=' . $msg_error);
    else :
        if (strlen($title) <3 || strlen($title) >40):
            $msg_error = '<p class="msg_error">Merci de remplir le contenu du titre avec le bon nombres de caractères</p>';
        else :
            if(strlen($text) <750 || strlen($text) >3000) :
                $msg_error = '<p class="msg_error">Merci de remplir le contenu de l\'article avec le bon nombres de caractères</p>';
            else :
                if (strlen($alt) <5 || strlen($alt) >40):
                    $msg_error = '<p class="msg_error">Merci de remplir le contenu de la description avec le bon nombres de caractères</p>';
                endif;
            endif;
        endif;
        $picture 	= $_FILES['picture'];
        $error 		= $picture['error'];
        $curr_img 	= $_POST['current_img'];

        if(in_array($error, $fail_upload)) :
            $msg_error = '<p class="msg_error">Échec au moment de la transmission de l\'image, merci de renouveler votre envoi</p>';
        elseif(in_array($error, $oversize_file)) :
            $msg_error = '<p class="msg_error">La taille de votre fichier ne doit pas dépasser 1 Mo</p>';
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
                    $msg_error = '<p class="msg_error">Votre fichier n\'est pas une image png, jpg, jpeg ou gif</p>';
                elseif($image_size > $size_max) :
                    $msg_error = '<p class="msg_error">La taille de votre fichier ne doit pas dépasser 1 Mo</p>';
                else :
                    // on créé un nom de fichier unique et aléatoire pour éviter les doublons dans le FTP (sur le serveur dans le dossier assets/img)


                    $img_name = uniqid() . '_' . $recept_img;

                    // facultatif :
                    // on crée le dossier img s'il n'existe pas
                    // https://www.php.net/manual/fr/function.mkdir.php
                    // https://www.php.net/manual/fr/function.chmod.php

                    // le @ n'affichera pas l'erreur (notice ou warning) si la fonction en retourne une
                    @mkdir(PATH_PROJECT . '/assets/img/dist/articles/', 0755);

                    // je crée une variable pour spécifier l'endroit où je vais stocker mon image
                    $img_folder = PATH_PROJECT . '/assets/img/dist/articles/';

                    //var_dump($img_folder);
                    $dir = $img_folder . $img_name;
                    var_dump($dir);
                    var_dump($curr_img);

                    // https://www.php.net/manual/fr/function.move-uploaded-file.php
                    $move_file = move_uploaded_file($tmp_name, $dir);
                    var_dump($tmp_name);
                    if($move_file) :
                        if($curr_img != $default_picture)

                            unlink($img_folder . $curr_img);


                        $set_request = TRUE;
                        $request_image =  "UPDATE picture SET file_name = :file_name, alt = :alt WHERE id = :id_image";
                    else :
                        $set_request = FALSE;
                    endif;
                endif;
            endif;
            if($set_request) :
                $req = $db->prepare("
                    
					UPDATE article SET id_user = :id_user, title = :title, content =:content, created_at = NOW()
					WHERE id = :id;
                    $request_image
				");

                $req->bindValue(':id', $id, PDO::PARAM_INT);
                $req->bindValue(':id_user', intval($_SESSION['id_user']), PDO::PARAM_INT); // integer
                $req->bindValue(':title', $title, PDO::PARAM_STR);
                $req->bindValue(':content', $text, PDO::PARAM_STR);
                if(!empty($request_image)) {
                    $req->bindValue(':id_image', $id_image, PDO::PARAM_INT);
                    $req->bindValue(':file_name', $img_name, PDO::PARAM_STR);
                    $req->bindValue(':alt', $alt, PDO::PARAM_STR);
                }

                // $result will store the result of my UPDATE request
                // if TRUE the insertion went well
                // if FALSE an error has occurred
                $result = $req->execute();

                if($result) :
                    $msg_success = '<p class="msg_success">Article correctement mis à jour</p>';
                else:
                    $msg_error = '<p class="msg_error">Erreur lors de la soumission du formulaire, merci de retenter dans quelques instants</p>';
                endif;

            else :
                $msg_error = '<p class="msg_error">Erreur lors du transfert, merci de retenter dans quelques instants</p>';
            endif;
        endif;
    endif;

    if(isset($msg_error)) {
        header('Location:' . HOME_URL . 'views/update_article.php?id=' . $id . '&msg=' .$msg_error . '&title=' . $title . '&content=' . $text);
    }
    else {
        header('Location:' . HOME_URL . 'views/blog.php?msg=' . $msg_success);
    }
}else{
    header('Location:' . HOME_URL . '?msg=<p class="msg_error">Vous n\'avez pas l\'autorisation de modifié cette article</p>');
}