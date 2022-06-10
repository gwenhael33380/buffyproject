<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';

$text = trim($_POST['text']);
// https://www.php.net/manual/fr/function.intval.php
$id = intval($_POST['id_comment']);
$id_article = intval($_POST['id_article']);

if(in_array('', $_POST)) :
    $msg_error = 'Merci de ne pas laisser un commentaire vide';
    header('Location:' . HOME_URL . 'views/update_comment.php?id=' . $id . '&msg=' . $msg_error);
else :

    $req = $db->prepare("
		UPDATE comments SET comment_content = :content
		WHERE id = :id -- condition pour ne mettre à jour que l'id du commentaire, pas les autres
	");
    // var_dump($db->errorInfo());

    $req->bindValue(':content', $text, PDO::PARAM_STR); // string
    $req->bindValue(':id', $id, PDO::PARAM_INT); // integer

    // $result va stocker le résultat de ma requete UPDATE
    // si TRUE l'insertion s'est bien déroulé
    // si FALSE une erreur s'est produite
    $result = $req->execute();

    if($result) {
        header('Location:' . HOME_URL . 'views/article.php?id=' . $id_article . '&msg=<div class="green">commentaire mis à jour</div>');
    }
    else {
        header('Location:' . HOME_URL . 'views/update_comment.php?id=' . $id . '&msg=<div class="red">Erreur, merci de renouveler votre mise à jour</div>');
    }

endif;
