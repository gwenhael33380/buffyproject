<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';

$text = trim($_POST['text']);
$id_article = intval($_POST['id_article']);


if(in_array('', $_POST)) :
    $msg_error = 'Merci de ne pas laisser un commentaire vide';
    header('Location:' . HOME_URL . 'views/add_comment.php?id=' . $id_article . '&msg=' . $msg_error);

else :
    $req = $db->prepare("
		INSERT INTO comments(id_user, id_article, comment_content, created_at)
		VALUES (:id_user, :id_article, :content, NOW())
	");

    // https://www.php.net/manual/fr/function.intval.php
    $req->bindValue(':id_user', intval($_SESSION['id_user']), PDO::PARAM_INT); // integer
    $req->bindValue(':id_article', $id_article, PDO::PARAM_INT); // integer
    $req->bindValue(':content', $text, PDO::PARAM_STR); // string

    // $result va stocker le résultat de ma requete INSERT INTO
    // si TRUE l'insertion s'est bien déroulé
    // si FALSE une erreur s'est produite
    $result = $req->execute();

    if($result) {
        header('Location:' . HOME_URL . 'views/article.php?id=' . $id_article . '&msg=<div class="green">Commentaire ajouté</div>');
    }
    else {
        header('Location:' . HOME_URL . 'views/add_comment.php?id=' . $id_article . '&msg=Erreur lors de l\'ajout du commentaire');
    }

endif;

