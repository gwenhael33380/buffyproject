<?php
//call function
require dirname(__DIR__) . '/functions.php';

//call connect
require_once PATH_PROJECT . '/connect.php';

$id_comment = intval($_GET['id']);
$id_article = intval($_GET['id_article']);

//request to delete a comment
if($id_comment) {
    $req = $db->prepare("
		DELETE FROM comments WHERE id = :id
	");
    //            bind values
    $req->bindValue(':id', $id_comment, PDO::PARAM_INT);

//    execution of the request
    $result = $req->execute();

    //redirect after data processing with option error or success messages
    if($result) {
        header('Location:' . HOME_URL . 'views/article.php?id=' . $id_article .'&msg=<p id="delete_comment_success">Commentaire supprimé</p>');
    }
    else {
        header('Location:' . HOME_URL .'views/article.php?id=' . $id_article . '&msg=<p id="error_delete_comment">Erreur lors de la suppression</p>');
    }
}