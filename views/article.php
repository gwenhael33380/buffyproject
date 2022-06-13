<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
define('TITLE', 'Article');
require __DIR__ . '/header.php';

$id_article = $_GET['id'];
$role_slug = $_SESSION['role_slug'];

$req = $db->prepare("
    SELECT a.id, a.id_user, a.title, a.content, a.content_2, a.created_at, a.id_image, u.first_name, i.id as id_tab_img, i.file_name, i.alt
    FROM articles a
    LEFT JOIN users u
    ON   a.id_user = u.id
    LEFT JOIN images i
    ON  i.id = a.id_image 
    WHERE a.id = ?
    ");

$req->execute(array($id_article));
$article = $req->fetch(PDO::FETCH_OBJ);


//time conversion function
$origin_date_article = $article->created_at;
$timestamp = strtotime($origin_date_article);
$newDate = date("d-m-Y à h:i:s", $timestamp );


?>

    <main>
        <section>
            <div class="content-title-page-article">
                <h1 class="title-page-article">Article</h1>
            </div>
            <div class="content-title-article">
                <h2 class="title-article"><?php echo sanitize_html($article->title); ?></h2>
            </div>

            <artricle>
                <div>
                    <img src="" alt="">
                    <p>Créer par : <?php echo sanitize_html($article->first_name); ?></p>
                </div>
                <div>
                    <div>
                        <img src="<?php echo HOME_URL .'assets/img/dist/articles/' . sanitize_html($article->file_name) ; ?>" alt="<?php echo sanitize_html($article->alt) ;?> ">
                        <p><?php echo sanitize_html($article->content); ?></p>
                    </div>
                    <p><?php echo sanitize_html($article->content_2); ?></p>

                </div>
                <p> Créer et mise à jour le : <?php echo sanitize_html($newDate); ?></p>
            </artricle>


            <?php

            // comme on a besoin d'une variable php pour aliemnter la requête, il faudra faire une requête préparée, pour éviter les injections SQL
            $req = $db->prepare("
				SELECT c.id, c.id_user, c.comment_content, c.created_at, u.pseudo
				FROM comments c
				INNER JOIN users u
				ON u.id = c.id_user
				WHERE c.id_article = ?
			");
            // Ici on exécute la requête préparée en remplaçant la variable "?" en attente par $id_article
            $req->execute(array($id_article));?>

            <div class="comments">
                <?php while($comment = $req->fetch(PDO::FETCH_OBJ)) :;?>
                    <div class="comment">
                        <div>
                            <p><?php echo sanitize_html($comment->comment_content); ?></p>
                            <p>Commenté par : <?php echo sanitize_html($comment->pseudo) ?></p>
                            <p>Date : <?php echo $comment->created_at; ?></p>
                        </div>
                        <div class="comment_action">
                            <?php
                            $enabled_comment = array('editor', 'user',);
                            if(
                                isset($role_slug)
                                &&
                                (
                                    $role_slug == "administrator"
                                    ||
                                    (
                                        // (
                                        // 	$role_slug == 'editor' && $comment->id_user == $_SESSION['id_user']
                                        // )
                                        // ||
                                        // (
                                        // 	$role_slug == 'user' && $comment->id_user == $_SESSION['id_user']
                                        // )
                                        in_array($role_slug,$enabled_comment) && $comment->id_user == $_SESSION['id_user']
                                    )
                                )
                            ) :
                                $id_comment = $comment->id;
                                ?>
                                <!-- bouton éditer -->
                                <a href="<?php echo HOME_URL . 'views/update_comment.php?id=' . $id_comment . '&id_article=' . $id_article; ?>"><i class="fa-solid fa-pencil"></i></a>
                                <!-- bouton supprimer -->
                                <a class="delete_comment" href="<?php echo HOME_URL . 'requests/delete_comment_post.php?id=' . $id_comment; ?>"><i class="fa-solid fa-trash-can"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
                <?php
                if(
                    isset($role_slug) // je vérifie si la variable existe (au cas où je suis déconnecté)
                    &&
                    (
                        (
                            $role_slug == 'administrator'
                            ||
                            $role_slug == 'user'
                        )
                        ||
                        (
                            $role_slug == 'editor'
                            &&
                            $_SESSION['id_user'] != $article->id_user // id_user connecté != id_user de l'article
                        )
                    )

                ) : ?>
                    <div>
                        <div class="msg-add-comment">
                            <?php
                            if(isset($_GET['msg'])) {
                                echo $_GET['msg'];
                            } ?>
                        </div>
                        <div>
                            <p><a href="<?php echo HOME_URL . 'views/add_comment.php?id=' . $id_article; ?>"> Ajouter un commentaire</a><i class="fa-solid fa-circle-plus"></i></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

















    </main>





















<?php require __DIR__ . '/footer.php';