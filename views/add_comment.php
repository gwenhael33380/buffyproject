<?php
require dirname(__DIR__) . '/functions.php';
require_once PATH_PROJECT . '/connect.php';
require __DIR__ . '/header.php';
enabled_access(array('administrator', 'editor', 'user'));
// require_once PATH_PROJECT . '/connect.php';

$id_article = intval($_GET['id']); // si le $_GET n'est pas numerique, il ne pourra pas le transformer en integer
?>

    <h1 class="title">Ajout de commentaire</h1>

    <div class="file_form">
        <form action="<?php echo HOME_URL . 'requests/add_comment_post.php'; ?>" method="POST">
            <div>
                <label for="text">Votre commentaire</label>
                <textarea id="text" name="text" rows="10"></textarea>
            </div>
            <!-- on envoie l'id de l'article pour pouvoir y rattacher le commentaire -->
            <input type="hidden" name="id_article" value="<?php echo $id_article; ?>">
            <button type="submit">Ajouter le commentaire</button>
        </form>
    </div>

<?php
require __DIR__ . '/footer.php';
