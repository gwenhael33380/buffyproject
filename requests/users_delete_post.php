<?php
//call function
require dirname(__DIR__) . '/functions.php';

//call connect
require_once PATH_PROJECT . '/connect.php';

//allow user delete access to authorized role
enabled_access(array('administrator','editor','user'));


$id_user = intval($_GET['id']);

if ($id_user) {

    //    request deleting the user, his articles, his comments, and his image
    $req = $db->prepare("
		DELETE FROM users WHERE id = :id;
		DELETE FROM articles WHERE id_user = :id;
		DELETE FROM comments WHERE id_user = :id;
	    DELETE FROM images WHERE file_name = :id;
	
	");

    //    bind value
    $req->bindValue(':id', $id_user, PDO::PARAM_INT);

    //    execution of the request
    $result = $req->execute();

    //    redirect on success or failure
    if ($result) {
        header('Location:' . HOME_URL . 'views/home.php?msg=<div class="green">Utilisateur supprimé</div>');
    } else {
        header('Location:' . HOME_URL . 'views/home.php?msg=<div class="red">Erreur lors de la suppression</div>');
    }
}