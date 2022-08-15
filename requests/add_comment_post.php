<?php
//call function
require dirname(__DIR__) . '/functions.php';

//call connect
require_once PATH_PROJECT . '/connect.php';

$text = trim($_POST['text']);
$id_article = intval($_POST['id_article']);

//processing of the data received in the $_POST and processing. start of condition processing with received data
if(in_array('', $_POST)) :
    $msg_error = 'Merci de ne pas laisser un commentaire vide';
    header('Location:' . HOME_URL . 'views/add_comment.php?id=' . $id_article . '&msg=' . '<p class="msg_error">' . $msg_error . '</p>');

else :
    //            insertion of the processed data into the database
    $req = $db->prepare("
		INSERT INTO comment(id_user, id_article, comment_content, created_at)
		VALUES (:id_user, :id_article, :content, NOW())
	");

//            bind values
    $req->bindValue(':id_user', intval($_SESSION['id_user']), PDO::PARAM_INT); // integer
    $req->bindValue(':id_article', $id_article, PDO::PARAM_INT); // integer
    $req->bindValue(':content', $text, PDO::PARAM_STR); // string

    // $result will store the result of my INSERT INTO query
    // if TRUE the insertion was successful
    // if FALSE an error has occurred
    $result = $req->execute();

    //redirect after data processing with option error or success messages
    if($result) {
        header('Location:' . HOME_URL . 'views/article.php?id=' . $id_article . '&msg=<p class="msg_success">Commentaire ajouté</p>');
    }
    else {
        header('Location:' . HOME_URL . 'views/add_comment.php?id=' . $id_article . '&msg=<p class="msg_error"> Erreur lors de l\'ajout du commentaire</p>');
    }

endif;

