<?php

require dirname(__DIR__) . '/functions.php'; //call function
enabled_access(array('administrator','editor','user')); // enabled acces

require_once PATH_PROJECT . '/connect.php'; //call connect

//allow user delete access to authorized role
$id_user = intval($_GET['id']);
// restrict access
if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == $id_user ){


    if ($id_user) {

        //    request deleting the user, his articles, his comments, and his image
        $req = $db->prepare("
		DELETE FROM user    WHERE id = :id;
		DELETE FROM article WHERE id_user = :id;
		DELETE FROM comment WHERE id_user = :id;
	    DELETE FROM picture WHERE file_name = :id;
	
	");


        $req->bindValue(':id', $id_user, PDO::PARAM_INT);  //    bind value


        $result = $req->execute(); //    execution of the request

        // destroy session
        session_destroy();
//
            //redirect on success or failure
        if ($result) {
            header('Location:' . HOME_URL . 'views/home.php?msg=<p class="msg_success">Utilisateur supprimé</p>');
        } else {
            header('Location:' . HOME_URL . 'views/home.php?msg=<p class="msg_error">Erreur lors de la suppression</p>');
        }
    }
}else{
    header('Location:' . HOME_URL . '?msg=<p class="msg_error">Vous n\'avez pas l\autorisation de supprimer cette utilisateur</p>');
}