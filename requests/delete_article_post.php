<?php
//call function
require dirname(__DIR__) . '/functions.php';

//call connect
require_once PATH_PROJECT . '/connect.php';

//the roles that have access to the page
//the others will be redirected to the HOME page
enabled_access(array('administrator'));

$id_article = intval($_GET['id']);

if ($id_article) {

//    request to delete an article
    $req = $db->prepare("
		DELETE FROM articles WHERE id = :id
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