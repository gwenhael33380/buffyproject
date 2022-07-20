<?php
//call function
require dirname(__DIR__) . '/functions.php';

//call connect
require_once PATH_PROJECT . '/connect.php';

$id_user = intval($_GET['id']);

if ($id_user) {

//    request to delete a user
    $req = $db->prepare("
		DELETE FROM users WHERE id = :id;
		DELETE FROM articles WHERE id_user = :id;
		DELETE FROM comments WHERE id_user = :id;
	    DELETE FROM images WHERE file_name = :id;
	
	");

    //            bind values
    $req->bindValue(':id', $id_user, PDO::PARAM_INT);

//    execution of the request
    $result = $req->execute();

//redirect after data processing with option error or success messages
    if ($result) {
        header('Location:' . HOME_URL . 'views/dashboard.php?msg=<div class="green">Utilisateur supprimé</div>');
    } else {
        header('Location:' . HOME_URL . 'views/dashboard.php?msg=<div class="red">Erreur lors de la suppression</div>');
    }
}