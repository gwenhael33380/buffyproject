<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';

$id_comment = intval($_GET['id']);
$id_article = intval($_GET['id_article']);

if($id_comment) {
    $req = $db->prepare("
		DELETE FROM comments WHERE id = :id
	");
    $req->bindValue(':id', $id_comment, PDO::PARAM_INT);

    $result = $req->execute();

    if($result) {
        header('Location:' . HOME_URL . 'views/article.php?id=' . $id_article .'&msg=<div class="green">Commentaire supprimé</div>');
    }
    else {
        header('Location:' . HOME_URL . '?msg=<div class="red">Erreur lors de la suppression</div>');
    }
}