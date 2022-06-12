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
       SELECT a.id, a.id_user, a.title, a.content, a.created_at, a.id_image, u.first_name, u.last_name, i.file_name, i.alt
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
                ?>
                <article class="content2-preview-article-blog" >
                        <div class="article preview-article-blog">
                            <div class="content-preview-img-blog">
                                <img class="preview-img-article-blog" src="<?php echo HOME_URL.'assets/img/dist/articles/' . sanitize_html($article->file_name);?>" alt="<?php echo sanitize_html($article->alt) ?> ">
                            </div>
                            <div class="content-preview-article">

                                <!--                        sanitize_html : call of the sanitize_html function-->
                                <h2>Titre de l'article : <?php echo sanitize_html($article->title); ?></h2>
                                <p>Écrit par <?php echo sanitize_html($article->first_name . ' ' . $article->last_name); ?></p>
                                <p>Date : <?= $article->created_at; ?></p>

                                <!-- substr : returns a string segment with a value of 120 characters -->
                                <p>Résumé : <?= sanitize_html(substr($article->content, 0, 120)); ?> ...</p>
                            </div>
                            <div class="content-article-action" >
                                <div class="article_action">
                                    <!-- update article -->
                                    <?php if(isset($role_slug) && $role_slug == "administrator" ) : ?>
                                        <a href="<?php echo HOME_URL . 'views/update_article.php?id=' . $id_article; ?>"><i class="fa-solid fa-pencil fa-2x"></i></a>
                                    <?php endif; ?>
                                    <!-- delete article -->
                                    <?php if(isset($role_slug) && $role_slug == 'administrator') : ?>
                                        <a class="delete_article" href="<?php echo HOME_URL . 'requests/delete_article_post.php?id=' . $id_article; ?>"><i class="fa-solid fa-trash-can fa-2x"></i></a>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <a class="red" href="<?php echo HOME_URL . 'views/article.php?id=' .  $article->id; ?>">Lire l'article complet...</a>
                                </div>
                            </div>
                        </div>
                </article>
            <?php endforeach; ?>

            <!--            the include function calls a file external to the page and includes it in the current page-->
            <?php include PATH_PROJECT . '/views/pagination.php'; ?>
        </section>
    </main>

<?php
require PATH_PROJECT . '/views/footer.php';
