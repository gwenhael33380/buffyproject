<?php
//call function
require dirname(__DIR__) . '/functions.php';
enabled_access(array('administrator'));
//call connect
require_once PATH_PROJECT . '/connect.php';

$id_user = intval($_GET['id']);

if ($id_user) {

//    request to delete a user
    $req = $db->prepare("
		DELETE FROM user WHERE id = :id;
		DELETE FROM article WHERE id_user = :id;
		DELETE FROM comment WHERE id_user = :id;
	    DELETE FROM picture WHERE file_name = :id;
	
	");

    //            bind values
    $req->bindValue(':id', $id_user, PDO::PARAM_INT);

//    execution of the request
    $result = $req->execute();

//redirect after data processing with option error or success messages
    if ($result) {
        header('Location:' . HOME_URL . 'views/dashboard.php?msg=<p class="msg_success">Utilisateur supprimé</p>');
    } else {
        header('Location:' . HOME_URL . 'views/dashboard.php?msg=<p class="msg_error">Erreur lors de la suppression</p>');
    }
}