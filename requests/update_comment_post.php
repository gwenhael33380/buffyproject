<?php
//call function
require dirname(__DIR__) . '/functions.php';

//call connect
require_once PATH_PROJECT . '/connect.php';

$text = trim($_POST['text']); //Remove spaces (or other characters) from the beginning and end of string
$id = intval($_POST['id_comment']); //Get the integer value of a variable
$id_article = intval($_POST['id_article']); //Get the integer value of a variable

//we process the information received by passing in the conditions
if(in_array('', $_POST)) :
    $msg_error = 'Merci de ne pas laisser un commentaire vide';

//redirect to update_comment.php page with comment id and error message
    header('Location:' . HOME_URL . 'views/update_comment.php?id=' . $id . '&msg=' . $msg_error);
else :
//request to update comment
    $req = $db->prepare("
		UPDATE comments SET comment_content = :content
		WHERE id = :id -- condition pour ne mettre à jour que l'id du commentaire, pas les autres
	");

    //            bind values
    $req->bindValue(':content', $text, PDO::PARAM_STR); // string
    $req->bindValue(':id', $id, PDO::PARAM_INT); // integer

    // $result will store the result of my UPDATE request
    // if TRUE the insertion was successful
    // if FALSE an error has occurred
    $result = $req->execute();

    //redirection to the article if the comment update is successful or a redirection to the comment update page.
    if($result) {
        header('Location:' . HOME_URL . 'views/article.php?id=' . $id_article . '&msg=<p id="update_comment_success"commentaire mis à jour</p>');
    }
    else {
        header('Location:' . HOME_URL . 'views/update_comment.php?id=' . $id . '&msg=<p id="update_comment_error">Erreur, merci de renouveler votre mise à jour</p>');
    }

endif;
