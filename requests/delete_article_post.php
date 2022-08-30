<?php
require dirname(__DIR__) . '/functions.php'; //call function
enabled_access(array('administrator', 'editor'));
require_once PATH_PROJECT . '/connect.php'; //call connect

//the roles that have access to the page
//the others will be redirected to the HOME page
enabled_access(array('administrator', 'editor'));

$id_article = intval($_GET['id']);
$id_user_article = intval($_GET['id_user']);
// restrict access
if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == $id_user_article || $_SESSION['role_slug'] == 'administrator'){


    if ($id_article) {

//    request to delete an article
        $req = $db->prepare("
		DELETE FROM article WHERE id = :id
	");

//    bind value
        $req->bindValue(':id', $id_article, PDO::PARAM_INT);

//    execution of the request
        $result = $req->execute();


//    redirect on success or failure
        if ($result) {
            header('Location:' . HOME_URL . 'views/blog.php' . '?msg=<p class="msg_success">Article supprimé</p>');
        } else {
            header('Location:' . HOME_URL . 'views/blog.php' . '?msg=<p class="msg_error">Erreur lors de la suppression</p>');
        }
    }
}else{
    header('Location:' . HOME_URL .'?msg=<p class="msg_error">Vous n\'avez pas l\'autorisation de supprimer cette article!!</p>');

}