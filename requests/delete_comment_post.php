<?php

require dirname(__DIR__) . '/functions.php'; //call function
enabled_access(array('administrator', 'editor', 'user'));
require_once PATH_PROJECT . '/connect.php'; //call connect

$id_comment = intval($_GET['id']);
$id_article = intval($_GET['id_article']);
$id_user_comment = intval($_GET['id_user_comment']);
//condition access
if (isset($_SESSION['id_user']) && ($_SESSION['id_user'] == $id_user_comment || $_SESSION['role_slug'] == 'administrator')){


//request to delete a comment
    if($id_comment) {
        $req = $db->prepare("
		DELETE FROM comment WHERE id = :id
	");
        //            bind values
        $req->bindValue(':id', $id_comment, PDO::PARAM_INT);

//    execution of the request
        $result = $req->execute();

        //redirect after data processing with option error or success messages
        if($result) {
            header('Location:' . HOME_URL . 'views/article.php?id=' . $id_article .'&msg=<p class="msg_success">Commentaire supprimé</p>');
        }
        else {
            header('Location:' . HOME_URL .'views/article.php?id=' . $id_article . '&msg=<p class="msg_error"">Erreur lors de la suppression</p>');
        }
    }
}else{
    header('Location:' . HOME_URL . '?msg=<p class="msg_error"">Vous n\'avez pas l\'autorisation de supprimer ce commentaire</p>');
}