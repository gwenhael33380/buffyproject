<?php

require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';

$id_article = intval($_GET['id']);

if ($id_article) {
    $req = $db->prepare("
		DELETE FROM articles WHERE id = :id
	");
    $req->bindValue(':id', $id_article, PDO::PARAM_INT);

    $result = $req->execute();

    if ($result) {
        header('Location:' . HOME_URL . 'views/blog.php' . '?msg=<div class="green">Article supprimé</div>');
    } else {
        header('Location:' . HOME_URL . 'views/blog.php' . '?msg=<div class="red">Erreur lors de la suppression</div>');
    }
}