<?php
require dirname(__DIR__) . '/functions.php'; //call function
enabled_access(array('administrator'));
require_once PATH_PROJECT . '/connect.php'; //call connect
//allow user delete access to authorized role

$id_user = intval($_GET['id']);

if ($id_user) {

    //    request deleting the user, his articles, his comments, and his image
    $req = $db->prepare("
		DELETE FROM user WHERE id = :id;
		DELETE FROM article WHERE id_user = :id;
		DELETE FROM comment WHERE id_user = :id;
	    DELETE FROM picture WHERE file_name = :id;
	
	");

    //    bind value
    $req->bindValue(':id', $id_user, PDO::PARAM_INT);

    //    execution of the request
    $result = $req->execute();

    //    redirect on success or failure
    if ($result) {
        header('Location:' . HOME_URL . 'views/dashboard.php?msg=<p class="msg_success">Utilisateur supprimé</p>');
    } else {
        header('Location:' . HOME_URL . 'views/home.php?msg=<p class="msg_error">Erreur lors de la suppression</p>');
    }
//    Azerty33380@!
}