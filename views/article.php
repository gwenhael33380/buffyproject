<?php


require dirname(__DIR__) . '/functions.php'; //call function.php
require_once PATH_PROJECT . '/connect.php'; //call connect.php

define('TITLE', 'Article'); //title tag definition
define('META_DESCRIPTION', 'la page article permet de visualiser l\'article sélectionné depuis la page blog. Tout le contenu y est affiché ainsi que les commentaires associés à ce dernier. Vous pouvez aussi visualiser une prévisualisation des trois derniers articles créer où l\'article dernièrement mise à jour.'); // Define meta description

require __DIR__ . '/header.php'; //call header.php

$id_article = $_GET['id'];
$role_slug = isset($_SESSION['role_slug']);

//request article
$req = $db->prepare("
    SELECT a.id, a.id_user, a.title, a.content, a.created_at, a.id_image, u.pseudo, p.id as id_tab_img, p.file_name, p.alt
    FROM article a
    LEFT JOIN user u
    ON   a.id_user = u.id
    LEFT JOIN picture p
    ON  p.id = a.id_image 
    WHERE a.id = ?
    ");

$req->execute(array($id_article));
$article = $req->fetch(PDO::FETCH_OBJ);

$name_article = $article->title;



//time conversion function
$origin_date_article = $article->created_at;
$timestamp = strtotime($origin_date_article);
$newDate = date("d-m-Y à H:i:s", $timestamp );

//Request preview article

$req = $db->prepare("
    SELECT a.id,  a.title, a.id_image, p.file_name, p.alt
    FROM article a
    LEFT JOIN picture p
    ON  p.id = a.id_image 
    WHERE a.id
    ORDER BY a.id DESC
    LIMIT 3
    
    ");

$req->execute();
$articles_previews = $req->fetchAll(PDO::FETCH_OBJ);


?>

    <!--Popup delete article-->
    <div class="popupDeleteArticle">
        <h3 class="title-popup-delete-article">Etes vous sûre de vouloir supprimer l'article ?</h3>
        <p class="text-popup-delete-article" >Cette action est irreversible et entrainera la perte de toutes les données de l'article !</p>
        <div class="content-button-popup-delete-article">
            <button id="popupBtnDeleteArticle" class="button-delete-article button-delete-article-1" >Annuler</button>
            <a  class="button-delete-user button-delete-article-2" href="<?php echo HOME_URL . 'requests/delete_article_post.php?id=' . $article->id . '&id_user=' . $article->id_user; ?>" > OK</a>
        </div>
    </div>

    <!--        Article-->
    <main class="bg-color-page-article" >

        <!--        section 1 content article-->
        <section>
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
                                    <div class="content-pseudo-creat-article">
                                        <p  class="pseudo-created-by">Par : <span class="pseudo-created-by-span"><?php echo sanitize_html($article->pseudo); ?></span></p>
                                        <p class="creation-date-article" >Publié le : <span class="creation-date-article-span"><?php echo sanitize_html($newDate); ?></span> </p>
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

<!--                                    foreach loop-->
                                    <?php foreach ($articles_previews as $article_preview) :?>
                                        <article class="content-article-previews">
                                            <div class="content-title-preview-article">
                                                <h3><a class="link-preview-article" href="<?php echo HOME_URL . 'views/article.php?id=' . sanitize_html($article_preview->id) ; ?>"><?php echo sanitize_html($article_preview->title); ?></a></h3>
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
                </article>
<!--                if rol_slug exists and it is equal to administrator, then we display the update and delete article buttons-->
                <?php if(isset($_SESSION['id_user']) && $_SESSION['role_slug'] == "administrator" || isset($_SESSION['id_user']) && $_SESSION['id_user'] == $article->id_user) : ?>
                    <div class="content-button-article">
                        <!-- Button update article -->
                        <div class="content-button-update-article">
                            <a class="button-update-article" href="<?php echo HOME_URL . 'views/update_article.php?id=' . $id_article . '&article_id_user=' . $article->id_user; ?>">Mettre à jour</i></a>
                        </div>

                        <!-- delete article -->
                        <div class="content-button-delete-article">
                            <a class="button-delete_article btnDeleteArticle" >supprimer l'article</i></a>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </section>
        <?php if (isset($_SESSION['role_slug'])) :
        ?>
        <section class="section-2-space-comment">
            <div class="spacing-content-title-comments">
                <div class="content-title-comments">
                    <h2 class="title-comments">ESPACE COMMENTAIRES</h2>
                </div>
            </div>


            <?php

            //request prepared comments
            $req = $db->prepare("
                SELECT c.id, c.id_user, c.comment_content, c.created_at, u.pseudo, u.id id_user, p.file_name
                FROM comment c
				INNER JOIN user u
				ON u.id = c.id_user
				LEFT JOIN picture p 
				ON u.id_image = p.id
				WHERE c.id_article = ?
                ORDER BY c.created_at DESC
			");

            //Here we execute the prepared statement by replacing the variable "?" pending by $id_article
            $req->execute(array($id_article));
            ?>

            <div class="comments">
                <?php
                if(
                isset($role_slug) //$role_slug is equal to administrator or user or editor and the session exists, then we display the add comment button
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
                    )
                )
                ) : ?>

                <div class="content-button-add-comment">

<!--                    button with redirection on the page for adding comments, we inject the url with the id of the article and the title-->
                    <a class="button-add-comment" href="<?php echo HOME_URL . 'views/add_comment.php?id=' . $id_article . '&title_article=' . $name_article ?>"> Ajouter un commentaire <i class="fa-solid fa-circle-plus"></i></a>
                </div>
                <div class="flex-comments">
                    <?php endif; ?>
                    <?php while($comment = $req->fetch(PDO::FETCH_OBJ)) :;

                        //time conversion function
                        $origin_date_comment = $comment->created_at;
                        $timestamp = strtotime($origin_date_comment);
                        $newDateComment = date("d/m/Y à H:i:s", $timestamp );


                        ?>
                        <div class="comment">
                            <div>
                                <div class="content-info-comment">
                                    <div class="content-img-profil-comment">
                                        <img class="img-content-profil-user-comment" src="<?php echo HOME_URL .'assets/img/dist/profil/'.sanitize_html($comment->file_name); ?>">
                                    </div>
                                    <div class="info-content-comment">
                                        <div class="content-info-comment-and-button-action"  >
                                            <div>
                                                <p class="comment-posted-by">Par : <span class="span-comment-posted-by"><?php echo sanitize_html($comment->pseudo) ?></span> </p>
                                                <p class="comment-published-on">Publié le :<span class="span-comment-published-on"><?php echo $newDateComment; ?></span></p>
                                            </div>
                                            <div class="comment_action">
                                                <?php

//                                                condition for editing and deleting a comment
                                                $enabled_comment = array('editor', 'user',);
                                                if(
                                                    isset($role_slug)
                                                    &&
                                                    (
                                                        $role_slug == "administrator"
                                                        ||
                                                        (
                                                            in_array($role_slug,$enabled_comment) && $comment->id_user == $_SESSION['id_user']
                                                        )
                                                    )
                                                ) :
                                                    $id_comment = $comment->id;
                                                endif; ?>

<!--                                                               link of update and delete buttons how to change comment id and article id variable-->
                                                    <?php if (isset($_SESSION['id_user']) && ($_SESSION['id_user'] ==  $comment->id_user || $_SESSION['role_slug'] == 'administrator')) : ?>
                                                    <!-- button update -->
                                                    <a class="button-update-comment" href="<?php echo HOME_URL . 'views/update_comment.php?id=' . $id_comment . '&id_article=' . $id_article .'&comment_id_user=' . $comment->id_user; ?>"><i class="fa-solid fa-pencil"></i></a>
                                                    <!-- button delete -->
                                                    <a class="delete_comment" href="<?php echo HOME_URL . 'requests/delete_comment_post.php?id=' . $id_comment . '&id_article=' . $id_article .'&id_user_comment=' . $comment->id_user; ?>"><i class="fa-solid fa-trash-can"></i></a>
                                                <?php  endif;?>

                                            </div>
                                        </div>
                                        <div class="content-comment-article">
                                            <p class="comment-in-html">commentaire : <span class="span-comment-in-html"><?php echo sanitize_html($comment->comment_content); ?></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>
    </main>
<?php require __DIR__ . '/footer.php';