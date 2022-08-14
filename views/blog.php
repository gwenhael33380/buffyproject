<?php

require dirname(__DIR__) . '/functions.php'; //call function.php
require_once PATH_PROJECT . '/connect.php'; //call connect.php

define('TITLE', 'Le blog'); //title tag definition
define('META_DESCRIPTION', 'la page blog permet de visualiser les articles associés à cette page. Vous pouvez visualiser jusqu\'a 5 articles par page et voir le pseudo de la personne ayant publié l\'article ainsi que la date de parution.'); // Define meta description


require __DIR__ . '/header.php'; //call header.php

//query used to count the articles
$req = $db->query("
    SELECT COUNT(id) AS count_article
    FROM articles
    ");
$result = $req->fetchObject();

$count_articles = $result->count_article;



$per_page = 5; //number of articles per page
$number_pages = ceil($count_articles / $per_page); //ceil rounded up

// we determine if the user has already navigated:
// if yes, we retrieve the current page
// if not, we go back to the first page
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
    -- offset will say from which tuple the query starts
    -- per_page indicates the number of results to display
    -- LIMIT should always be written at the end of the query
    LIMIT :offset, :per_page
    ");


$offset = ($current_page - 1) * $per_page;

//bindValue of the request
$req->bindValue(':offset', $offset, PDO::PARAM_INT);
$req->bindValue(':per_page', $per_page, PDO::PARAM_INT);


//execute the query
$req->execute();

//we get all the results of the query and we inject them into the variable $articles
$articles = $req->fetchAll(PDO::FETCH_OBJ);


if(isset($_SESSION['role_slug'])) $role_slug = $_SESSION['role_slug'];

?>

    <!--    blog page-->
    <main class="content">

        <div class="content-bgi-blog"></div>
        <div class="content-title-blog" >

<!--            if $role_slug exists and if the role is administrator, then we display the icon for adding an article-->
            <h1 class="title-blog">Buffy project Le Blog <?php if(isset($role_slug) && $role_slug == 'administrator' || 'editor') echo "<span><a href=\"" . HOME_URL . "views/add_article.php\"><i class=\"fa-solid fa-circle-plus\"></i></a></span>"; ?></h1>
        </div>
        <section>
            <div class="content-content-article-blog" >
                <div class="content-article-blog" >
                    <h2 class="article-title">Les articles</h2>
                </div>
            </div>


            <!--            loop foreach for displaying items-->
            <?php
            foreach($articles as $article) :

                $id_article = $article->id;

//                time conversion function
                $origin_date_article = $article->created_at;
                $timestamp = strtotime($origin_date_article);
                $newDate = date("d-m-Y à H:i:s", $timestamp);


                ?>
                <article class="content2-preview-article-blog">
                        <div class="article preview-article-blog">
                            <div id="article_id">
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
                            <div class="content-article-action">
                                <div class="content-button-acces-article">
                                    <a class="button-prewiew-acces-blog" href="<?php echo HOME_URL . 'views/article.php?id=' .  $article->id; ?>">Lire l'article...</a>
                                </div>
                            </div>
                        </div>
                        <div class="transform-border">
                            <div class="beefore">
                        </div>

                    </div>
                </article>
            <?php endforeach; ?>

            <!--            the include function calls a file external to the page and includes it in the current page-->
            <?php include PATH_PROJECT . '/views/pagination.php'; ?>
        </section>
    </main>

<?php

require PATH_PROJECT . '/views/footer.php'; //call footer
