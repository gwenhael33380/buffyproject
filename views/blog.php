<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
define('TITLE', 'Le blog');
require __DIR__ . '/header.php';



$req = $db->query("
    SELECT COUNT(id) AS count_article
    FROM articles
    ");
$result = $req->fetchObject();

$count_articles = $result->count_article;



$per_page = 5; // nombre d'articles par page
$number_pages = ceil($count_articles / $per_page); // ceil arrondi au chiffre supérieur

// on détermine si l'utilisateur a déjà navigué :
// si oui, on récupére la page courante
// si non, on remet à la première page
if(isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $number_pages) {
    $current_page = $_GET['page'];
}
else {
    $current_page = 1;
}

//query prepare to display articles
$req = $db->prepare("
       SELECT a.id, a.id_user, a.title, a.content, a.created_at, a.id_image, u.first_name, u.last_name, u.pseudo, i.file_name, i.alt
    FROM articles a
    LEFT JOIN users u
    ON  a.id_user = u.id
    LEFT JOIN images i
    ON a.id_image = i.id
    
    ORDER BY a.created_at DESC
    -- offset va dire à partir de quel tuple la requete commence
    -- per_page indique le nombre de résultat à afficher
    -- LIMIT toujours à la fin de la requête
    LIMIT :offset, :per_page
    ");


$offset = ($current_page - 1) * $per_page;

$req->bindValue(':offset', $offset, PDO::PARAM_INT);
$req->bindValue(':per_page', $per_page, PDO::PARAM_INT);
$req->execute();
$articles = $req->fetchAll(PDO::FETCH_OBJ);





if(isset($_SESSION['role_slug'])) $role_slug = $_SESSION['role_slug'];

?>

    <!--    blog page-->
    <main>

        <div class="content-bgi-blog"></div>
        <div class="content-title-blog" >
            <h1 class="title-blog">Buffy Contre Les Vampires Le Blog <?php if(isset($role_slug) && $role_slug == 'administrator') echo "<span><a href=\"" . HOME_URL . "views/add_article.php\"><i class=\"fa-solid fa-circle-plus\"></i></a></span>"; ?></h1>
        </div>
        <section>
            <div class="content-content-article-blog" >
                <div class="content-article-blog" >
                    <h2 class="article-title">Les articles</h2>
                </div>
            </div>

            <!--            display of request $_GET messages-->
            <div class="msg-add-comment">
                <?php
                if(isset($_GET['msg'])) {
                    echo $_GET['msg'];
                } ?>
            </div>

            <!--            loop foreach for displaying items-->
            <?php


            foreach($articles as $article) :

                $id_article = $article->id;



//                time conversion function
                $origin_date_article = $article->created_at;
                $timestamp = strtotime($origin_date_article);
                $newDate = date("d-m-Y à h:i:s", $timestamp);


                ?>
                <article class="content2-preview-article-blog">
                        <div class="article preview-article-blog">
                            <div id="article_id">
                                <?php echo $article->id; ?>
                            </div>
                            <div class="content-preview-img-blog">
                                <a href="<?php echo HOME_URL . 'views/article.php?id=' .  $article->id; ?>"><img class="preview-img-article-blog" src="<?php echo HOME_URL.'assets/img/dist/articles/' . sanitize_html($article->file_name);?>" alt="<?php echo sanitize_html($article->alt) ?> "></a>
                            </div>
                            <div class="content-preview-article">

                                <!--                        sanitize_html : call of the sanitize_html function-->
                                <a href="<?php echo HOME_URL . 'views/article.php?id=' .  $article->id; ?>"><h2 class="title-preview-article" ><?php echo sanitize_html($article->title); ?></h2></a>
                                <p class="content-post-pseudo-preview">Par : <span class="content-pseudo-article-preview"><?php echo sanitize_html($article->pseudo); ?></span></p>

                                <!-- substr : returns a string segment with a value of 120 characters -->
                                <p class="content-post-preview-article" >Résumé : <a href="<?php echo HOME_URL . 'views/article.php?id=' .  $article->id; ?>"><span class="content-prewiew-article"><?= sanitize_html(substr($article->content, 0, 120)); ?> ...</span> </p></a>
                                <p class="content-post-time-preview">Publier le : <span class="content-time-preview" ><?php echo sanitize_html($newDate); ?></span> </p>
                            </div>
                            <div class="content-article-action" >
                                <div class="article_action">
                                    <!-- update article -->
                                    <?php if(isset($role_slug) && $role_slug == "administrator" ) : ?>
                                        <a class="update-article" href="<?php echo HOME_URL . 'views/update_article.php?id=' . $id_article; ?>"><i class="fa-solid fa-pencil fa-2x"></i></a>
                                    <?php endif; ?>
                                    <!-- delete article -->
                                    <?php if(isset($role_slug) && $role_slug == 'administrator') : ?>
<!--                                        <a class="delete_article" ><i class="fa-solid fa-trash-can fa-2x"></i></a>-->


                                        <button id="<?php echo $article->id; ?>" onclick="open_modal_delete(this); "><?php echo $article->id; ?><i class="fa-solid fa-trash-can fa-2x"></i></button>
                                    <?php endif; ?>
                                </div>
                                <div class="content-button-acces-article">
                                    <a class="button-prewiew-acces-blog" href="<?php echo HOME_URL . 'views/article.php?id=' .  $article->id; ?>">Lire l'article complet...</a>
                                </div>
                            </div>
                        </div>
                </article>
            <?php endforeach; ?>

            <!--            the include function calls a file external to the page and includes it in the current page-->
            <?php include PATH_PROJECT . '/views/pagination.php'; ?>
        </section>
        <div class="modal_delete_article"  id="modal_delete_article">
            <div id="article_id"></div>
            <div>
                <button href="<?php echo HOME_URL . 'requests/delete_article_post.php?id=' . $id_article; ?>" onclick=" close_modal_and_do_delete();" >Oui</button>
            </div>
            <div>
                <button onclick=" close_modal_and_cancel_delete();">Non</button>
            </div>
        </div>
    </main>

<?php
require PATH_PROJECT . '/views/footer.php';
