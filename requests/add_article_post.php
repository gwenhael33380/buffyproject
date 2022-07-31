<?php
//call function
require dirname(__DIR__) . '/functions.php';

//call connect
require_once PATH_PROJECT . '/connect.php';

//the roles that have access to the page
//the others will be redirected to the HOME page
enabled_access(array('administrator'));

//initialization of variables with error handling, format and size
$fail_upload 		= array(3,6,7,8);
$oversize_file 		= array(1,2);
$default_picture 	= 'no-image.jpg';
$extension 			= array('png', 'jpg', 'jpeg', 'gif');
$size_max 			= 1048576;

//processing of the data received in the $_POST and processing. start of condition processing with received data
if(in_array('', $_POST)) :
    $msg_error = 'Merci de remplir le titre et le contenu de l\'article';
else :

    $title 		= trim($_POST['title']);
    $text 		= $_POST['text'];
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

            // we check if the extension is in the table, otherwise it is not an image
            if(!in_array($ext_img, $extension)) :
                $msg_error = 'Votre fichier n\'est pas une image png, jpg, jpeg ou gif';
            elseif($image_size > $size_max) :
                $msg_error = 'La taille de votre fichier ne doit pas dépasser 1 Mo';

            else :
                //we created a unique and random file name to avoid duplicates in the FTP (on the server in the assets/img folder)
                $img_name = uniqid() . '_' . $recept_img;

                // optional :
                // we create the img folder if it does not exist

                // the @ will not display the error (notice or warning) if the function returns one
                @mkdir(PATH_PROJECT . '/assets/img/dist/articles/', 0755);

                // I create a variable to specify where I will store my image
                $img_folder = PATH_PROJECT . '/assets/img/dist/articles/';
                $dir = $img_folder . $img_name;

                //storage in image variable stored in temp folder
                $move_file = move_uploaded_file($tmp_name, $dir);

                if($move_file) :
                    $set_request = TRUE;
                else :
                    $set_request = FALSE;
                endif;
            endif;
        endif;

        if($set_request) :

//            insertion of the processed data into the database
            $req = $db->prepare("
				  INSERT INTO images(file_name, alt)
                VALUE   (:file_name, :alt);

                INSERT INTO articles(id_user, title, content, id_image, created_at)
				VALUES (:id_user, :title, :content,LAST_INSERT_ID(), NOW())
              
			");


//            bind values
            $req->bindValue(':id_user', intval($_SESSION['id_user']), PDO::PARAM_INT); // integer
            $req->bindValue(':title', $title, PDO::PARAM_STR); // string
            $req->bindValue(':content', $text, PDO::PARAM_STR); // string
            $req->bindValue(':file_name', $img_name, PDO::PARAM_STR); // string
            $req->bindValue(':alt', $alt, PDO::PARAM_STR); // string

            // $result will store the result of my INSERT INTO query
            // if TRUE the insertion was successful
            // if FALSE an error has occurred
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

//redirect after data processing with option error or success messages
if(isset($msg_error)) {
    header('Location:' . HOME_URL . 'views/add_article.php?msg=<p class="msg_success">' . $msg_error . '</p>');
}
else {
    header('Location:' . HOME_URL . 'views/blog.php?msg=<p class="msg_error">' . $msg_success . '</p>');

}


