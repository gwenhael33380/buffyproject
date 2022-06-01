<?php

require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';

$id_user = intval($_GET['id']);

if ($id_user) {
    $req = $db->prepare("
		DELETE FROM users WHERE id = :id;
		DELETE FROM articles WHERE id_user = :id;
		DELETE FROM comments WHERE id_user = :id;
	    DELETE FROM images WHERE file_name = :id;
	
	");
    $req->bindValue(':id', $id_user, PDO::PARAM_INT);

    $result = $req->execute();

    if ($result) {
        header('Location:' . HOME_URL . 'views/home.php?msg=<div class="green">Utilisateur supprimé</div>');
    } else {
        header('Location:' . HOME_URL . 'views/home.php?msg=<div class="red">Erreur lors de la suppression</div>');
    }
}