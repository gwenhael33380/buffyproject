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

    // var_dump($count_articles);

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

    // on veut tous les résultats, on injecte pas de variable php dans la requête sql => $db->query suffit
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


    var_dump($db->errorInfo());// affiche les erreurs SQL
    // on veut récupérer les résultats de la requête donc on utilise un fetch

    // Ici on utilise fetchAll pour obtenir tous les résultats d'un seul coup
    // il faudra donc les stocker dans une variable avant de l'utiliser

    // par defaut, nous obtiendrons un tableau de tableaux
    // $articles = $req->fetchAll(); // résultat de la requête
    // il peut s'ecrire aussi
    // $articles = $req->fetchAll(PDO::FETCH_ASSOC);

    // si vous voulez un resultat en forme de tableau contenant des objets

    $offset = ($current_page - 1) * $per_page;

    $req->bindValue(':offset', $offset, PDO::PARAM_INT);
    $req->bindValue(':per_page', $per_page, PDO::PARAM_INT);
    $req->execute();
    $articles = $req->fetchAll(PDO::FETCH_OBJ);



    if(isset($_SESSION['role_slug'])) $role_slug = $_SESSION['role_slug'];

    ?>

    <h1 class="titleBlog">Buffy Contre Les Vampires Le Blog <?php if(isset($role_slug) && $role_slug == 'administrator') echo "<span><a href=\"" . HOME_URL . "views/add_article.php\"><i class=\"fa-solid fa-circle-plus\"></i></a></span>"; ?></h1>

    <main>

        <?php


        include PATH_PROJECT . '/views/pagination.php';
        foreach($articles as $article) :

            $id_article = $article->id;
            ?>
            <!--
            exercice :
            ajouter, pour chaque article les icones éditer et supprimer :
            - pour les admins = éditer, supprimer pour tous les articles
            - pour les éditeurs = éditer seulement pour les articles qu'ils ont écrit
            -->
            <article class="article">
                <!-- Bouton action sur l'article si connecté et différent de user -->

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


                <h2><?php echo sanitize_html($article->title); ?></h2>
                <img src="<?php echo HOME_URL.'assets/img/dist/articles/' . sanitize_html($article->file_name);?>" alt="<?php echo sanitize_html($article->alt) ?> ">
                <p>Écrit par <?php echo sanitize_html($article->first_name . ' ' . $article->last_name); ?></p>
                <p>Date : <?= $article->created_at; ?></p>
                <!-- https://www.php.net/manual/fr/function.substr.php -->
                <p>Résumé : <?= sanitize_html(substr($article->content, 0, 70)); ?> ...<a class="red"
                                href="<?php echo HOME_URL . 'views/article.php?id=' .  $article->id; ?>">Lire l'article complet...</a></p>

            </article>
        <?php endforeach; ?>
    </main>
<?php
require PATH_PROJECT . '/views/footer.php';
