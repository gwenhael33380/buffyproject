<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
define('TITLE', 'Article');
require __DIR__ . '/header.php';

$id_article = $_GET['id'];
$role_slug = $_SESSION['role_slug'];
//request article
$req = $db->prepare("
    SELECT a.id, a.id_user, a.title, a.content, a.created_at, a.id_image, u.pseudo, i.id as id_tab_img, i.file_name, i.alt
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

//Request preview article

$req = $db->prepare("
    SELECT a.id, a.title, a.id_image, i.file_name, i.alt
    FROM articles a
    LEFT JOIN images i
    ON  i.id = a.id_image 
    WHERE a.id
    ORDER BY a.id DESC
    LIMIT 3
    
    ");

$req->execute();
$articles_previews = $req->fetchAll(PDO::FETCH_OBJ);


$req = $db->prepare("
    SELECT  u.id user_id, i.file_name, i.alt
    FROM users u
    LEFT JOIN images i
    ON  i.id =  u.id
    WHERE u.id
    
    
    ");

$req->execute();
$user_img = $req->fetch(PDO::FETCH_OBJ);



?>

    <!--Popup delete article-->
    <div class="popupDeleteArticle">
        <h3 class="title-popup-delete-article">Etes vous sûre de vouloir supprimer l'article ?</h3>
        <p class="text-popup-delete-article" >Cette action est irreversible et entrainera la perte de toutes les données de l'article !</p>
        <div class="content-button-popup-delete-article">
            <button id="popupBtnDeleteArticle" class="button-delete-article button-delete-article-1" >Annulé</button>
            <a  class="button-delete-user button-delete-article-2" href="<?php echo HOME_URL . 'requests/users_delete_post.php?id=' . $article->id; ?>" > OK</a>
        </div>
    </div>

    <main class="bg-color-page-article" >
        <section>
            <div class="msg-add-comment">
                <?php
                if(isset($_GET['msg'])) {
                    echo $_GET['msg'];
                } ?>
            </div>
            <div class="bg-img-page-article"></div>
            <div class="content-title-page-article">
                <h1 class="title-page-article">Article</h1>
            </div>
            <div class="spacing-content-title-article">
                <div class="content-title-article">
                    <h2 class="title-article"><?php echo sanitize_html($article->title); ?></h2>
                </div>
            </div>
            <div >
                <article class="content-articles">
                    <div>
                        <div class="content-img-and-content">
                            <div class="flex-content-img-article">
                                <div class="content-img-article" >
                                    <div class="content-pseudo-creat-article" >
                                        <img src="" alt="">
                                        <p  >Publier par : <?php echo sanitize_html($article->pseudo); ?></p>
                                    </div>
                                    <img class="img-article-current" src="<?php echo HOME_URL .'assets/img/dist/articles/' . sanitize_html($article->file_name) ; ?>" alt="<?php echo sanitize_html($article->alt) ;?> ">
                                </div>
                            </div>
                            <div class="preview-content-and-article-content">
                                <div class="content-intergal-article">

                                    <div class="content-text-article" >
                                        <div class="content-title-article-2">
                                            <h2 class="title-article-2"><?php echo sanitize_html($article->title); ?></h2>
                                        </div>
                                        <p class="text-content-article" ><?php echo sanitize_html($article->content); ?></p>
                                    </div>
                                </div>
                                <div class="content-prewiew-article-x3">
                                    <h2 class="text-preview">A lire aussi</h2>
                                    <?php foreach ($articles_previews as $article_preview) :?>
                                        <article class="content-article-previews">
                                            <div class="content-title-preview-article">
                                                <h3><a class="link-preview-article" href=""><?php echo sanitize_html($article_preview->title); ?></a></h3>
                                            </div>
                                            <div class="content-img-preview-article">
                                                <img class="img-preview-article" src="<?php echo HOME_URL .'assets/img/dist/articles/' . sanitize_html($article_preview->file_name) ; ?>" alt="<?php echo sanitize_html($article_preview->alt) ;?>">
                                            </div>
                                            <div class="content-border-bottom">
                                                <div class="border-bottom"></div>
                                            </div>
                                        </article>
                                    <?php endforeach ?>
                                </div>

                            </div>
                        </div>
                    </div>
                    <p> Créer et mise à jour le : <?php echo sanitize_html($newDate); ?></p>
                </article>
                <div class="content-button-delete-article">
                    <a class="button-delete_user btnDeleteArticle" >supprimer l'article'</i></a>
                </div>
            </div>
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
                        <div>
                            <p><a href="<?php echo HOME_URL . 'views/add_comment.php?id=' . $id_article; ?>"> Ajouter un commentaire</a><i class="fa-solid fa-circle-plus"></i></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
<?php require __DIR__ . '/footer.php';