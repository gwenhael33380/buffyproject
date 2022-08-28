<?php
//call function
require dirname(__DIR__) . '/functions.php';
enabled_access(array('administrator', 'editor', 'user'));

require_once PATH_PROJECT . '/connect.php'; //call connect

$text = trim($_POST['text']); //Remove spaces (or other characters) from the beginning and end of string
$id = intval($_POST['id_comment']); //Get the integer value of a variable
$id_article = intval($_POST['id_article']); //Get the integer value of a variable
$comment_id_user = $_POST['comment_id_user'];
$current_id_user = $_SESSION['id_user'];

$req = $db->prepare("
               	SELECT c.id, c.id_user
                FROM comment c
				LEFT JOIN user u
				ON u.id = c.id_user
				WHERE c.id = :id_comment
				AND id_user = :id_user
                ORDER BY c.id
			");

//Here we execute the prepared statement by replacing the variable "?" pending by $id_article
$req->execute(array(':id_comment' => $id,':id_user' => $comment_id_user,  ));

if (isset($_SESSION['id_user']) && ($_SESSION['id_user'] == $comment_id_user || $_SESSION['role_slug'] == 'administrator')) {


//we process the information received by passing in the conditions
    if (in_array('', $_POST)) :
        $msg_error = 'Merci de ne pas laisser un commentaire vide';

//redirect to update_comment.php page with comment id and error message
        header('Location:' . HOME_URL . 'views/update_comment.php?id=' . $id . '&msg=' . $msg_error);
    else :
//request to update comment
        $req = $db->prepare("
		UPDATE comment SET comment_content = :content
		WHERE id = :id 
	");

        //            bind values
        $req->bindValue(':content', $text, PDO::PARAM_STR); // string
        $req->bindValue(':id', $id, PDO::PARAM_INT); // integer

        // $result will store the result of my UPDATE request
        // if TRUE the insertion was successful
        // if FALSE an error has occurred
        $result = $req->execute();

        //redirection to the article if the comment update is successful or a redirection to the comment update page.
        if ($result) {
            header('Location:' . HOME_URL . 'views/article.php?id=' . $id_article . '&msg=<p class="msg_success">commentaire mis à jour</p>');
        } else {
            header('Location:' . HOME_URL . 'views/article.php?id=' . $id_article . '&msg=<p class="msg_error">Erreur, merci de renouveler votre mise à jour</p>');
        }
    endif;
}else{
    header('Location:' . HOME_URL . '?msg=<p class="msg_error">Vous n\'avez pas l\autorisation de modifié ce commentaire</p>');
}



